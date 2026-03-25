<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Job;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['participants.user', 'messages' => function($query) {
                $query->latest();
            }])
            ->latest()
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->participants()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->with('sender')
            ->oldest()
            ->get();

        return view('messages.show', compact('conversation', 'messages'));
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('chat-attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ];
            }
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'attachments' => $attachments
        ]);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message sent successfully');
    }

public function startConversation(Request $request, $jobId)
    {
        $job = Job::find($jobId);
        
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }
        
        // Check if conversation already exists
        $existingConversation = Conversation::where('job_id', $job->id)
            ->whereHas('participants', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('participants', function($query) use ($job) {
                $query->where('user_id', $job->client_id);
            })
            ->first();

        if ($existingConversation) {
            return redirect()->route('messages.show', $existingConversation);
        }

        // Create new conversation
        $conversation = Conversation::create([
            'job_id' => $job->id
        ]);

        // Add participants
        $conversation->participants()->createMany([
            ['user_id' => Auth::id()],
            ['user_id' => $job->client_id]
        ]);

        // Add initial message
        $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => "I'm interested in your job: " . $job->title,
            'type' => 'job_inquiry'
        ]);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Conversation started successfully');
    }

public function startStoreConversation(Request $request, $storeId)
    {
        $store = Store::find($storeId);
        
        if (!$store) {
            return redirect()->back()->with('error', 'Store not found.');
        }
        
        // Check if conversation already exists for this store and user
        $existingConversation = Conversation::where('store_id', $store->id)
            ->whereHas('participants', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('participants', function($query) use ($store) {
                $query->where('user_id', $store->user_id);
            })
            ->first();

        if ($existingConversation) {
            return redirect()->route('messages.show', $existingConversation);
        }

        // Create new conversation for store
        $conversation = Conversation::create([
            'store_id' => $store->id
        ]);

        // Add participants
        $conversation->participants()->createMany([
            ['user_id' => Auth::id()],
            ['user_id' => $store->user_id]
        ]);

        // Add initial message
        $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => "I'm interested in your store: " . $store->store_name,
            'type' => 'store_inquiry'
        ]);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Conversation started with store owner');
    }

    public function unreadCount()
    {
        $count = Auth::user()->conversations()
            ->withCount(['messages' => function($query) {
                $query->where('sender_id', '!=', Auth::id())
                    ->where('is_read', false);
            }])
            ->get()
            ->sum('messages_count');

        return response()->json(['count' => $count]);
    }
}