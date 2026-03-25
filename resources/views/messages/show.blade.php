@extends('layouts.app')

@section('title', 'Conversation - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('messages.index') }}" class="btn btn-link text-decoration-none" style="color: var(--primary-dark);">
                <i class="fas fa-arrow-left me-2"></i>Back to Messages
            </a>
        </div>
    </div>

    @php
        $otherParticipant = $conversation->participants->where('user_id', '!=', Auth::id())->first();
    @endphp

    <!-- Chat Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <!-- Participant Avatar -->
                        <div class="me-3">
                            @if($otherParticipant && $otherParticipant->user)
                                <img src="{{ $otherParticipant->user->profile_image ?? 'https://via.placeholder.com/70x70/0F172A/F8F8F9?text=' . substr($otherParticipant->user->name, 0, 1) }}" 
                                     alt="{{ $otherParticipant->user->name }}"
                                     style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-accent);">
                            @else
                                <img src="https://via.placeholder.com/70x70/0F172A/F8F8F9?text=U" 
                                     alt="User"
                                     style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-accent);">
                            @endif
                        </div>
                        
                        <!-- Participant Info -->
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1" style="color: var(--primary-dark);">
                                @if($otherParticipant && $otherParticipant->user)
                                    {{ $otherParticipant->user->name }}
                                    @if($otherParticipant->user->isProfessional())
                                        <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent);">Professional</span>
                                    @elseif($otherParticipant->user->isStoreOwner())
                                        <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent);">Store Owner</span>
                                    @elseif($otherParticipant->user->isClient())
                                        <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent);">Client</span>
                                    @endif
                                @else
                                    Unknown User
                                @endif
                            </h4>
                            
                            @if($conversation->projectJob)
                                <p class="mb-0" style="color: var(--gold-accent);">
                                    <i class="fas fa-briefcase me-2"></i>Regarding: <a href="{{ route('jobs.show', $conversation->projectJob) }}" class="text-decoration-none" style="color: var(--gold-accent); font-weight: 600;">{{ $conversation->projectJob->title }}</a>
                                </p>
                            @elseif($conversation->product)
                                <p class="mb-0" style="color: var(--gold-accent);">
                                    <i class="fas fa-tools me-2"></i>Regarding: <a href="{{ route('products.show', $conversation->product) }}" class="text-decoration-none" style="color: var(--gold-accent); font-weight: 600;">{{ $conversation->product->name }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; height: 500px; display: flex; flex-direction: column;">
                <div class="card-body overflow-auto" id="messages-container" style="flex: 1; padding: 20px;">
                    @forelse($messages as $message)
                        @if($message->sender_id == Auth::id())
                            <!-- Sent Message -->
                            <div class="d-flex justify-content-end mb-3">
                                <div class="position-relative" style="max-width: 70%;">
                                    <div class="p-3 rounded-3" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 20px 20px 5px 20px;">
                                        <p class="mb-1">{{ $message->message }}</p>
                                        @if($message->attachments)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $attachment)
                                                    <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="small text-white-50 d-block">
                                                        <i class="fas fa-paperclip me-1"></i>{{ $attachment['name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <small class="text-muted mt-1 d-block text-end">{{ $message->created_at->format('M d, h:i A') }}</small>
                                </div>
                            </div>
                        @else
                            <!-- Received Message -->
                            <div class="d-flex justify-content-start mb-3">
                                <div class="position-relative" style="max-width: 70%;">
                                    <div class="p-3 rounded-3" style="background: var(--light-grey); color: var(--primary-dark); border-radius: 20px 20px 20px 5px;">
                                        <p class="mb-1">{{ $message->message }}</p>
                                        @if($message->attachments)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $attachment)
                                                    <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="small" style="color: var(--primary-dark); opacity: 0.7;">
                                                        <i class="fas fa-paperclip me-1"></i>{{ $attachment['name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <small class="text-muted mt-1 d-block">{{ $message->created_at->format('M d, h:i A') }}</small>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-4x mb-3" style="color: var(--gold-accent); opacity: 0.5;"></i>
                            <h5 style="color: var(--primary-dark);">No messages yet</h5>
                            <p style="color: var(--primary-dark); opacity: 0.7;">Start the conversation by sending a message below</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Message Input -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-4">
                    <form action="{{ route('messages.send', $conversation) }}" method="POST" enctype="multipart/form-data" id="message-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-9">
                                <textarea class="form-control" name="message" rows="2" placeholder="Type your message..." required style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;"></textarea>
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 12px; font-weight: 600;">
                                        <i class="fas fa-paper-plane me-2"></i>Send
                                    </button>
                                    <label for="attachments" class="btn w-100" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px; font-weight: 600;">
                                        <i class="fas fa-paperclip me-2"></i>Attach Files
                                        <input type="file" name="attachments[]" id="attachments" multiple class="d-none" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="file-preview" class="mt-2"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom of messages
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
});

// File preview
document.getElementById('attachments').addEventListener('change', function(e) {
    const preview = document.getElementById('file-preview');
    preview.innerHTML = '';
    
    for (let i = 0; i < this.files.length; i++) {
        const file = this.files[i];
        const div = document.createElement('div');
        div.className = 'small text-muted mt-1';
        div.innerHTML = '<i class="fas fa-paperclip me-1"></i>' + file.name;
        preview.appendChild(div);
    }
});

// Submit form with Enter key (but allow Shift+Enter for new line)
document.querySelector('textarea[name="message"]').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('message-form').submit();
    }
});
</script>
@endsection