@extends('layouts.app')

@section('title', 'Chat with ' . ($otherUser->name ?? 'User') . ' - BuildConnect')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Chat Header -->
            <div class="chat-header mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('messages.index') }}" class="btn-back me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="chat-avatar me-3">
                        <img src="{{ $otherUser->profile_image_url }}" alt="{{ $otherUser->name }}">
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $otherUser->name }}</h5>
                        <small class="text-muted">{{ ucfirst($otherUser->user_type) }}</small>
                        @if($conversation->job)
                            <div class="job-reference mt-1">
                                <i class="fas fa-briefcase me-1"></i>
                                <span>Job: {{ Str::limit($conversation->job->title, 40) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="chat-container" id="messagesContainer">
                <div class="messages-list">
                    @foreach($conversation->messages as $message)
                        @if($message->user_id == Auth::id())
                            <!-- Sent Message -->
                            <div class="message sent">
                                <div class="message-content">
                                    <div class="message-bubble">
                                        <p class="mb-0">{{ $message->message }}</p>
                                    </div>
                                    <div class="message-time">
                                        {{ $message->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Received Message -->
                            <div class="message received">
                                <div class="message-avatar">
                                    <img src="{{ $otherUser->profile_image_url }}" alt="{{ $otherUser->name }}">
                                </div>
                                <div class="message-content">
                                    <div class="message-bubble">
                                        <p class="mb-0">{{ $message->message }}</p>
                                    </div>
                                    <div class="message-time">
                                        {{ $message->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Message Input -->
            <div class="chat-input-container">
                <form id="messageForm" action="{{ route('messages.send', $conversation->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <textarea name="message" class="form-control message-input" rows="1" placeholder="Type your message..." required></textarea>
                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .chat-header {
        background: white;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    
    .btn-back {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--gray-100);
        border-radius: 50%;
        color: var(--gray-700);
        transition: all 0.2s;
    }
    
    .btn-back:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    .chat-avatar {
        width: 48px;
        height: 48px;
    }
    
    .chat-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--brand-gold);
    }
    
    .job-reference {
        font-size: 0.7rem;
        color: var(--gray-500);
        margin-top: 4px;
    }
    
    .chat-container {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        height: 500px;
        overflow-y: auto;
        margin-bottom: 20px;
    }
    
    .messages-list {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .message {
        display: flex;
        gap: 12px;
        animation: fadeIn 0.3s ease;
    }
    
    .message.sent {
        justify-content: flex-end;
    }
    
    .message.received {
        justify-content: flex-start;
    }
    
    .message-avatar {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
    }
    
    .message-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .message-content {
        max-width: 70%;
    }
    
    .message.sent .message-content {
        text-align: right;
    }
    
    .message-bubble {
        background: var(--gray-100);
        padding: 10px 16px;
        border-radius: 18px;
        display: inline-block;
    }
    
    .message.sent .message-bubble {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    .message.received .message-bubble {
        background: var(--gray-100);
        color: var(--gray-800);
    }
    
    .message-bubble p {
        font-size: 0.9rem;
        line-height: 1.4;
        word-break: break-word;
    }
    
    .message-time {
        font-size: 0.65rem;
        color: var(--gray-500);
        margin-top: 4px;
    }
    
    .chat-input-container {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        padding: 16px 20px;
    }
    
    .message-input {
        border: 1px solid var(--gray-300);
        border-radius: 24px;
        padding: 12px 16px;
        resize: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .message-input:focus {
        border-color: var(--brand-gold);
        box-shadow: 0 0 0 3px rgba(201, 165, 59, 0.1);
        outline: none;
    }
    
    .btn-send {
        background: var(--brand-gold);
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-dark);
        transition: all 0.2s;
        margin-left: 12px;
    }
    
    .btn-send:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Scrollbar */
    .chat-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-container::-webkit-scrollbar-track {
        background: var(--gray-200);
        border-radius: 3px;
    }
    
    .chat-container::-webkit-scrollbar-thumb {
        background: var(--brand-gold);
        border-radius: 3px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messagesContainer');
    const form = document.getElementById('messageForm');
    const messageInput = document.querySelector('.message-input');
    const messagesList = document.querySelector('.messages-list');
    
    // Scroll to bottom on load
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
    
    // Function to add a message to the chat
    function addMessageToChat(message, isSent, userName, userAvatar) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
        messageDiv.setAttribute('data-message-id', message.id);
        
        if (!isSent) {
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <img src="${userAvatar}" alt="${userName}">
                </div>
                <div class="message-content">
                    <div class="message-bubble">
                        <p class="mb-0">${escapeHtml(message.content)}</p>
                    </div>
                    <div class="message-time">${message.created_at}</div>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-bubble">
                        <p class="mb-0">${escapeHtml(message.content)}</p>
                    </div>
                    <div class="message-time">${message.created_at}</div>
                </div>
            `;
        }
        
        messagesList.appendChild(messageDiv);
        container.scrollTop = container.scrollHeight;
    }
    
    // Handle form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) {
                showNotification('Please enter a message', 'error');
                return;
            }
            
            const submitBtn = this.querySelector('.btn-send');
            const originalHtml = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Add the sent message to chat
                    addMessageToChat(data.message, true, null, null);
                    
                    // Clear input
                    messageInput.value = '';
                    
                    // Focus back on input
                    messageInput.focus();
                } else {
                    throw new Error(data.error || 'Failed to send message');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to send message. Please try again.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        });
    }
    
    // Function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Function to show notifications
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Optional: Auto-refresh messages every few seconds (for real-time)
    let lastMessageId = document.querySelector('.message:last-child')?.dataset.messageId || 0;
    
    async function checkForNewMessages() {
        try {
            const response = await fetch(`/messages/${conversationId}/check-new`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(message => {
                    if (message.user.id !== {{ Auth::id() }}) {
                        addMessageToChat(message, false, message.user.name, message.user.avatar);
                    }
                });
                lastMessageId = data.messages[data.messages.length - 1]?.id || lastMessageId;
            }
        } catch (error) {
            console.error('Error checking for new messages:', error);
        }
    }
    
    // Check for new messages every 5 seconds (optional)
    // setInterval(checkForNewMessages, 5000);
});
</script>
@endpush
@endsection