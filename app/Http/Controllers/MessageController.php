<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Store;
use App\Models\CallSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all conversations for the logged-in user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get conversations where user is a participant
        $conversations = $user->conversations()
            ->with(['job', 'participants', 'lastMessage'])
            ->latest('updated_at')
            ->get();
        
        return view('messages.index', compact('conversations'));
    }

    /**
     * Start a new conversation for a job
     */
    public function start($jobId)
    {
        $user = Auth::user();
        $job = Job::findOrFail($jobId);
        
        // Check if user is the client who posted the job
        if ($user->user_type == 'client' && $job->client_id != $user->id) {
            return redirect()->back()->with('error', 'You can only message professionals about your own jobs.');
        }
        
        // Check if user is a professional trying to message about a job
        if ($user->user_type == 'professional') {
            // Check if the professional has already bid on this job
            $hasBid = $job->bids()->where('professional_id', $user->id)->exists();
            
            if (!$hasBid) {
                return redirect()->back()->with('error', 'You can only message about jobs you have bid on.');
            }
        }
        
        // Determine the other participant
        if ($user->id == $job->client_id) {
            // User is client, find the accepted professional
            $acceptedBid = $job->bids()->where('status', 'accepted')->first();
            if (!$acceptedBid) {
                return redirect()->back()->with('error', 'No professional has been assigned to this job yet.');
            }
            $otherUser = User::find($acceptedBid->professional_id);
        } else {
            // User is professional, find the client
            $otherUser = User::find($job->client_id);
        }
        
        if (!$otherUser) {
            return redirect()->back()->with('error', 'Unable to find the user to message.');
        }
        
        // Check if conversation already exists between these users for this job
        $conversation = Conversation::where('job_id', $jobId)
            ->whereHas('participants', function($query) use ($user, $otherUser) {
                $query->whereIn('user_id', [$user->id, $otherUser->id]);
            }, '=', 2)
            ->first();
        
        if ($conversation) {
            return redirect()->route('messages.show', $conversation->id);
        }
        
        // Create new conversation
        DB::transaction(function () use ($jobId, $user, $otherUser) {
            $conversation = Conversation::create([
                'job_id' => $jobId,
                'status' => 'active',
                'last_message_at' => now(),
            ]);
            
            // Attach participants
            $conversation->participants()->attach([$user->id, $otherUser->id]);
        });
        
        $conversation = Conversation::where('job_id', $jobId)
            ->whereHas('participants', function($query) use ($user, $otherUser) {
                $query->whereIn('user_id', [$user->id, $otherUser->id]);
            }, '=', 2)
            ->first();
        
        return redirect()->route('messages.show', $conversation->id);
    }

    /**
     * Start a conversation with a professional (for clients)
     */
    public function startWithProfessional($professionalId)
    {
        $user = Auth::user();
        
        if ($user->user_type != 'client') {
            return redirect()->back()->with('error', 'Only clients can message professionals.');
        }
        
        $professional = User::where('user_type', 'professional')->findOrFail($professionalId);
        
        // Check if conversation already exists
        $conversation = Conversation::whereNull('job_id')
            ->whereHas('participants', function($query) use ($user, $professional) {
                $query->whereIn('user_id', [$user->id, $professional->id]);
            }, '=', 2)
            ->first();
        
        if ($conversation) {
            return redirect()->route('messages.show', $conversation->id);
        }
        
        // Create new conversation
        DB::transaction(function () use ($user, $professional) {
            $conversation = Conversation::create([
                'job_id' => null,
                'status' => 'active',
                'last_message_at' => now(),
            ]);
            
            $conversation->participants()->attach([$user->id, $professional->id]);
        });
        
        $conversation = Conversation::whereNull('job_id')
            ->whereHas('participants', function($query) use ($user, $professional) {
                $query->whereIn('user_id', [$user->id, $professional->id]);
            }, '=', 2)
            ->first();
        
return redirect()->route('messages.show', $conversation->id);
    }

    /**
     * Start a conversation with a store
     */
    public function startStoreConversation($storeId)
    {
        $user = Auth::user();
        $store = Store::findOrFail($storeId);
        $storeOwner = $store->user;

        // Check if conversation already exists
        $conversation = Conversation::where('store_id', $storeId)
            ->whereHas('participants', function($query) use ($user, $storeOwner) {
                $query->whereIn('user_id', [$user->id, $storeOwner->id]);
            }, '=', 2)
            ->first();

        if ($conversation) {
            return redirect()->route('messages.show', $conversation->id);
        }

        // Create new conversation
        DB::transaction(function () use ($storeId, $user, $storeOwner) {
            $conversation = Conversation::create([
                'job_id' => null,
                'store_id' => $storeId,
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            $conversation->participants()->attach([$user->id, $storeOwner->id]);
        });

        $conversation = Conversation::where('store_id', $storeId)
            ->whereHas('participants', function($query) use ($user, $storeOwner) {
                $query->whereIn('user_id', [$user->id, $storeOwner->id]);
            }, '=', 2)
            ->first();

        return redirect()->route('messages.show', $conversation->id);
    }

    /**
     * Show a specific conversation
     */
    public function show($conversationId)
    {
        $conversation = Conversation::with(['job', 'participants', 'messages.user'])
            ->findOrFail($conversationId);
        
        $user = Auth::user();
        
        // Check if user is part of this conversation
        $isParticipant = $conversation->participants->contains($user->id);
        
        if (!$isParticipant) {
            abort(403, 'Unauthorized');
        }
        
        // Get the other participant
        $otherUser = $conversation->participants->firstWhere('id', '!=', $user->id);
        
        // Mark messages as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('messages.show', compact('conversation', 'otherUser'));
    }

    /**
     * Send a message in a conversation
     */
    public function send(Request $request, $conversationId)
    {
        try {
            // Log the request for debugging
            Log::info('Send message request', [
                'conversation_id' => $conversationId,
                'user_id' => Auth::id(),
                'message' => $request->message
            ]);
            
            $request->validate([
                'message' => 'required|string|max:5000'
            ]);

            $conversation = Conversation::findOrFail($conversationId);
            $user = Auth::user();

            // Check if user is part of this conversation
            $isParticipant = $conversation->participants()->where('user_id', $user->id)->exists();

            if (!$isParticipant) {
                return response()->json(['error' => 'You are not a participant in this conversation.'], 403);
            }

            // Create the message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'message' => $request->message,
                'is_read' => false
            ]);

            // Update conversation last message time
            $conversation->update(['last_message_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'content' => $message->message,
                    'created_at' => $message->created_at->format('g:i A'),
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'avatar' => $user->profile_image_url
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Message send error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check for new messages in a conversation
     */
    public function checkNewMessages($conversationId, Request $request)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();
        
        // Check if user is part of this conversation
        $isParticipant = $conversation->participants()->where('user_id', $user->id)->exists();
        
        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $lastMessageId = $request->input('last_message_id', 0);
        
        $messages = $conversation->messages()
            ->where('id', '>', $lastMessageId)
            ->with('user')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->message,
                    'created_at' => $message->created_at->format('g:i A'),
                    'user' => [
                        'id' => $message->user->id,
                        'name' => $message->user->name,
                        'avatar' => $message->user->profile_image_url
                    ]
                ];
            });
        
return response()->json(['messages' => $messages]);
    }

    /**
     * Start an audio/video call
     */
    public function startCall(Request $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        // Verify user is participant
        $isParticipant = $conversation->participants()->where('user_id', $user->id)->exists();
        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get the other participant (callee)
        $callee = $conversation->participants()->where('user_id', '!=', $user->id)->first();
        if (!$callee) {
            return response()->json(['error' => 'No participant to call'], 400);
        }

        // Validate request
        $request->validate([
            'type' => 'required|in:audio,video'
        ]);

        // Create call session
        $call = CallSession::create([
            'conversation_id' => $conversation->id,
            'caller_id' => $user->id,
            'callee_id' => $callee->id,
            'type' => $request->type,
            'status' => 'pending'
        ]);

        // Broadcast WebSocket event for incoming call (using Pusher or similar)
        // event(new IncomingCall($call, $callee));

        Log::info('Call initiated', [
            'call_id' => $call->id,
            'caller' => $user->id,
            'callee' => $callee->id,
            'type' => $request->type
        ]);

        return response()->json([
            'success' => true,
            'call' => [
                'id' => $call->id,
                'type' => $call->type,
                'caller' => [
                    'id' => $user->id,
                    'name' => $user->name
                ],
                'callee' => [
                    'id' => $callee->id,
                    'name' => $callee->name
                ],
                'status' => $call->status
            ]
        ]);
    }

    /**
     * Accept an incoming call
     */
    public function acceptCall($callSessionId)
    {
        $call = CallSession::findOrFail($callSessionId);
        $user = Auth::user();

        // Only callee can accept
        if ($call->callee_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($call->status !== 'pending') {
            return response()->json(['error' => 'Call is no longer pending'], 400);
        }

        $call->update([
            'status' => 'accepted',
            'started_at' => now()
        ]);

        Log::info('Call accepted', ['call_id' => $call->id]);

        return response()->json([
            'success' => true,
            'call' => [
                'id' => $call->id,
                'status' => $call->status,
                'started_at' => $call->started_at
            ]
        ]);
    }

    /**
     * Reject an incoming call
     */
    public function rejectCall($callSessionId)
    {
        $call = CallSession::findOrFail($callSessionId);
        $user = Auth::user();

        if ($call->callee_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($call->status !== 'pending') {
            return response()->json(['error' => 'Call is no longer pending'], 400);
        }

        $call->update(['status' => 'rejected']);

        Log::info('Call rejected', ['call_id' => $call->id]);

        return response()->json(['success' => true]);
    }

/**
     * End a call (by ID in request body - for frontend)
     */
    public function endCallById(Request $request)
    {
        $request->validate(['call_id' => 'required|exists:call_sessions,id']);

        $call = CallSession::findOrFail($request->call_id);
        $user = Auth::user();

        // Either party can end the call
        if ($call->caller_id !== $user->id && $call->callee_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!in_array($call->status, ['accepted', 'pending'])) {
            return response()->json(['error' => 'Call is not active'], 400);
        }

        $endedAt = now();
        $duration = $call->started_at ? $endedAt->diffInSeconds($call->started_at) : 0;

        $call->update([
            'status' => 'ended',
            'ended_at' => $endedAt,
            'duration' => $duration
        ]);

        Log::info('Call ended', [
            'call_id' => $call->id,
            'duration' => $duration
        ]);

        return response()->json([
            'success' => true,
            'call' => [
                'id' => $call->id,
                'status' => $call->status,
                'duration' => $duration
            ]
        ]);
    }

    /**
     * End an active call
     */
    public function endCall(Request $request, $callSessionId)
    {
        $call = CallSession::findOrFail($callSessionId);
        $user = Auth::user();

        // Either party can end the call
        if ($call->caller_id !== $user->id && $call->callee_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!in_array($call->status, ['accepted', 'pending'])) {
            return response()->json(['error' => 'Call is not active'], 400);
        }

        $endedAt = now();
        $duration = $call->started_at ? $endedAt->diffInSeconds($call->started_at) : 0;

        $call->update([
            'status' => 'ended',
            'ended_at' => $endedAt,
            'duration' => $duration
        ]);

        Log::info('Call ended', [
            'call_id' => $call->id,
            'duration' => $duration
        ]);

        return response()->json([
            'success' => true,
            'call' => [
                'id' => $call->id,
                'status' => $call->status,
                'duration' => $duration
            ]
        ]);
    }

/**
     * Initiate a call (called from frontend with conversation_id in body)
     */
    public function initiateCall(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'type' => 'required|in:audio,video'
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $user = Auth::user();

        // Verify user is participant
        $isParticipant = $conversation->participants()->where('user_id', $user->id)->exists();
        if (!$isParticipant) {
            return response()->json(['error' => 'You are not a participant in this conversation.'], 403);
        }

        // Get the other participant (callee)
        $callee = $conversation->participants()->where('user_id', '!=', $user->id)->first();
        if (!$callee) {
            return response()->json(['error' => 'No participant to call'], 400);
        }

        // Check if callee is online (in production, use presence channels)
        // For now, we allow calling even if offline

        // Create call session
        $call = CallSession::create([
            'conversation_id' => $conversation->id,
            'caller_id' => $user->id,
            'callee_id' => $callee->id,
            'type' => $request->type,
            'status' => 'pending'
        ]);

        Log::info('Call initiated', [
            'call_id' => $call->id,
            'caller' => $user->id,
            'callee' => $callee->id,
            'type' => $request->type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Call initiated - waiting for answer',
            'call_id' => $call->id,
            'call' => [
                'id' => $call->id,
                'type' => $call->type,
                'caller' => [
                    'id' => $user->id,
                    'name' => $user->name
                ],
                'callee' => [
                    'id' => $callee->id,
                    'name' => $callee->name
                ],
                'status' => $call->status
            ]
        ]);
    }

    /**
     * Handle ICE candidate exchange (WebRTC signaling)
     */
    public function iceCandidate(Request $request, $callSessionId)
    {
        $call = CallSession::findOrFail($callSessionId);
        $user = Auth::user();

        // Verify participant
        if ($call->caller_id !== $user->id && $call->callee_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'candidate' => 'required',
            'sdpMid' => 'required',
            'sdpMidLineIndex' => 'required'
        ]);

        // In production, broadcast this via WebSocket to the other participant
        Log::info('ICE candidate received', [
            'call_id' => $call->id,
            'user_id' => $user->id,
            'sdpMid' => $request->sdpMid
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get call status for polling
     */
    public function callStatus($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        $isParticipant = $conversation->participants()->where('user_id', $user->id)->exists();
        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get the latest pending/active call for this conversation
        $call = CallSession::where('conversation_id', $conversation->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->first();

        if (!$call) {
            return response()->json(['call' => null]);
        }

        return response()->json([
            'call' => [
                'id' => $call->id,
                'type' => $call->type,
                'status' => $call->status,
                'caller_id' => $call->caller_id,
                'callee_id' => $call->callee_id,
                'started_at' => $call->started_at?->toIso8601String()
            ]
        ]);
    }
}

