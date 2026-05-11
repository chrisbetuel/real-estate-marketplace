@extends('layouts.app')

@section('title', 'Chat with ' . ($otherUser->name ?? 'User') . ' - Oweru BuildConnect')

@section('content')
<div class="chat-app">
    <div class="chat-container">
        <!-- Chat Header - Phone Style -->
        <div class="chat-header">
            <div class="header-left">
                <a href="{{ route('messages.index') }}" class="back-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <div class="contact-info">
                    <div class="contact-avatar">
                        <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($otherUser->name) }}" alt="{{ $otherUser->name }}">
                        <span class="online-status {{ $otherUser->is_online ? 'online' : 'offline' }}"></span>
                    </div>
                    <div class="contact-details">
                        <h4>{{ $otherUser->name }}</h4>
                        <p class="contact-status">{{ $otherUser->is_online ? 'Online' : 'Offline' }}</p>
                        @if($conversation->job)
                            <div class="job-tag">
                                <i class="fas fa-briefcase"></i> {{ Str::limit($conversation->job->title, 25) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-right">
                <button class="icon-btn" id="callBtn">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="icon-btn" id="videoBtn">
                    <i class="fas fa-video"></i>
                </button>
                <button class="icon-btn" id="menuBtn">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="messages-area" id="messagesArea">
            <div class="messages-list" id="messagesList">
                @php
                    $lastDate = null;
                @endphp
                @foreach($conversation->messages as $message)
                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                        $showDate = $lastDate !== $messageDate;
                        $lastDate = $messageDate;
                    @endphp
                    
                    @if($showDate)
                        <div class="date-divider">
                            <span>{{ $message->created_at->format('l, F j') }}</span>
                        </div>
                    @endif
                    
                    @if($message->user_id == Auth::id())
                        <!-- Sent Message -->
                        <div class="message sent">
                            <div class="message-bubble">
                                <p>{{ $message->message }}</p>
                                <span class="message-time">{{ $message->created_at->format('g:i A') }}</span>
                                <span class="message-status">
                                    <i class="fas fa-check-double {{ $message->is_read ? 'read' : '' }}"></i>
                                </span>
                            </div>
                        </div>
                    @else
                        <!-- Received Message -->
                        <div class="message received">
                            <div class="message-avatar">
                                <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($otherUser->name) }}" alt="{{ $otherUser->name }}">
                            </div>
                            <div class="message-bubble">
                                <p>{{ $message->message }}</p>
                                <span class="message-time">{{ $message->created_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator" style="display: none;">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="typing-text">Typing...</span>
        </div>

        <!-- Message Input - Phone Style -->
        <div class="message-input-area">
            <form id="messageForm" action="{{ route('messages.send', $conversation->id) }}" method="POST">
                @csrf
                <div class="input-wrapper">
                    <button type="button" class="attach-btn" id="attachBtn">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                    <textarea name="message" class="message-input" rows="1" placeholder="Type a message..." required></textarea>
                    <button type="submit" class="send-btn" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            
            <!-- Attachment Menu -->
            <div class="attach-menu" id="attachMenu" style="display: none;">
                <button type="button" class="attach-option">
                    <i class="fas fa-camera"></i> Camera
                </button>
                <button type="button" class="attach-option">
                    <i class="fas fa-image"></i> Gallery
                </button>
                <button type="button" class="attach-option">
                    <i class="fas fa-file-alt"></i> Document
                </button>
                <button type="button" class="attach-option">
                    <i class="fas fa-map-marker-alt"></i> Location
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Phone SMS App Styles */
    .chat-app {
        background: #F5F7FA;
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .chat-container {
        max-width: 500px;
        width: 100%;
        height: 700px;
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
    }

    /* Chat Header */
    .chat-header {
        background: #1E2A3A;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .back-btn {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.2s;
    }

    .back-btn:hover {
        background: #F5A623;
        color: #1E2A3A;
    }

    .contact-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .contact-avatar {
        position: relative;
        width: 48px;
        height: 48px;
    }

    .contact-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .online-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .online-status.online {
        background: #10B981;
    }

    .online-status.offline {
        background: #9CA3AF;
    }

    .contact-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin: 0 0 2px 0;
    }

    .contact-status {
        font-size: 11px;
        color: rgba(255,255,255,0.6);
        margin: 0;
    }

    .job-tag {
        font-size: 10px;
        color: #F5A623;
        margin-top: 2px;
    }

    .job-tag i {
        font-size: 9px;
        margin-right: 2px;
    }

    .header-right {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.1);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .icon-btn:hover {
        background: #F5A623;
        color: #1E2A3A;
    }

    /* Messages Area */
    .messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #F8FAFC;
    }

    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Date Divider */
    .date-divider {
        text-align: center;
        margin: 16px 0;
    }

    .date-divider span {
        background: #E2E8F0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        color: #64748B;
    }

    /* Message Bubbles */
    .message {
        display: flex;
        gap: 8px;
        animation: fadeInUp 0.3s ease;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message.received {
        justify-content: flex-start;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .message-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .message-bubble {
        max-width: 75%;
        padding: 10px 14px;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
    }

    .message.sent .message-bubble {
        background: #1E2A3A;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message.received .message-bubble {
        background: white;
        color: #1E293B;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .message-bubble p {
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
    }

    .message-time {
        font-size: 10px;
        color: rgba(0,0,0,0.4);
        margin-left: 8px;
    }

    .message.sent .message-time {
        color: rgba(255,255,255,0.5);
    }

    .message-status {
        margin-left: 4px;
    }

    .message-status i {
        font-size: 10px;
        color: rgba(255,255,255,0.5);
    }

    .message-status i.read {
        color: #34B7F1;
    }

    /* Typing Indicator */
    .typing-indicator {
        padding: 10px 16px;
        background: white;
        border-top: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
    }

    .typing-dots span {
        width: 6px;
        height: 6px;
        background: #94A3B8;
        border-radius: 50%;
        animation: typingBounce 1.4s infinite;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typingBounce {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-6px);
        }
    }

    .typing-text {
        font-size: 12px;
        color: #94A3B8;
    }

    /* Message Input Area */
    .message-input-area {
        background: white;
        border-top: 1px solid #E2E8F0;
        padding: 12px 16px;
        position: relative;
    }

    .input-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .attach-btn {
        width: 40px;
        height: 40px;
        background: none;
        border: none;
        color: #F5A623;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .attach-btn:hover {
        transform: rotate(45deg);
    }

    .message-input {
        flex: 1;
        border: none;
        background: #F1F5F9;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 14px;
        resize: none;
        font-family: inherit;
        max-height: 100px;
        transition: all 0.2s;
    }

    .message-input:focus {
        outline: none;
        background: white;
        box-shadow: 0 0 0 2px rgba(245,166,35,0.2);
    }

    .send-btn {
        width: 40px;
        height: 40px;
        background: #F5A623;
        border: none;
        border-radius: 50%;
        color: #1E2A3A;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .send-btn:hover {
        background: #D4891A;
        transform: translateY(-2px);
    }

    .send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Attachment Menu */
    .attach-menu {
        position: absolute;
        bottom: 70px;
        left: 16px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        z-index: 10;
    }

    .attach-option {
        padding: 12px 20px;
        background: none;
        border: none;
        text-align: left;
        font-size: 14px;
        color: #1E293B;
        cursor: pointer;
        border-radius: 12px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .attach-option i {
        width: 20px;
        color: #F5A623;
    }

    .attach-option:hover {
        background: #F1F5F9;
    }

    /* Scrollbar */
    .messages-area::-webkit-scrollbar {
        width: 4px;
    }

    .messages-area::-webkit-scrollbar-track {
        background: #E2E8F0;
    }

    .messages-area::-webkit-scrollbar-thumb {
        background: #94A3B8;
        border-radius: 4px;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
@media (max-width: 600px) {
        .chat-app {
            padding: 0;
        }

        .chat-container {
            border-radius: 0;
            height: 100vh;
        }
    }

    /* Call Modal Styles */
    .call-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #1E2A3A;
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    .call-modal-content {
        width: 100%;
        max-width: 800px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .call-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .call-header h4 {
        color: white;
        margin: 0;
    }

    .close-call {
        background: none;
        border: none;
        color: white;
        font-size: 28px;
        cursor: pointer;
    }

    .call-body {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .video-container {
        width: 100%;
        max-width: 400px;
        aspect-ratio: 16/9;
        background: #0F172A;
        border-radius: 16px;
        overflow: hidden;
    }

    .video-container video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-container.remote {
        max-width: 600px;
    }

    .remote-placeholder {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120px;
        height: 120px;
    }

    .remote-placeholder img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .call-status {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(255,255,255,0.7);
        font-size: 14px;
    }

    .call-actions {
        padding: 30px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .call-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.2s;
    }

    .call-btn.mute, .call-btn.video {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .call-btn.end {
        background: #EF4444;
        color: white;
    }

    .call-btn:hover {
        transform: scale(1.1);
    }

    .call-btn.active {
        background: #EF4444;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messagesArea');
    const messagesList = document.getElementById('messagesList');
    const form = document.getElementById('messageForm');
    const messageInput = document.querySelector('.message-input');
    const sendBtn = document.getElementById('sendBtn');
    const attachBtn = document.getElementById('attachBtn');
    const attachMenu = document.getElementById('attachMenu');
    const typingIndicator = document.getElementById('typingIndicator');
    
    let lastMessageId = {{ $conversation->messages->last()->id ?? 0 }};
    let typingTimeout;
    let isTyping = false;
    
    // Scroll to bottom on load
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
    
    // Auto-resize textarea
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 100) + 'px';
            
            // Send typing indicator
            if (!isTyping) {
                isTyping = true;
                fetch('/messages/typing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ conversation_id: {{ $conversation->id }}, typing: true })
                });
            }
            
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
                fetch('/messages/typing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ conversation_id: {{ $conversation->id }}, typing: false })
                });
            }, 1000);
        });
    }
    
    // Add message to chat
    function addMessageToChat(message, isSent) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
        messageDiv.setAttribute('data-message-id', message.id);
        
        if (!isSent) {
            messageDiv.innerHTML = `
                <div class="message-avatar">
                    <img src="{{ $otherUser->profile_image_url ?? '' }}" alt="{{ $otherUser->name }}">
                </div>
                <div class="message-bubble">
                    <p>${escapeHtml(message.content)}</p>
                    <span class="message-time">${message.created_at}</span>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-bubble">
                    <p>${escapeHtml(message.content)}</p>
                    <span class="message-time">${message.created_at}</span>
                    <span class="message-status">
                        <i class="fas fa-check-double"></i>
                    </span>
                </div>
            `;
        }
        
        messagesList.appendChild(messageDiv);
        container.scrollTop = container.scrollHeight;
    }
    
    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Show notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: ${type === 'error' ? '#EF4444' : '#10B981'};
            color: white;
            padding: 10px 20px;
            border-radius: 40px;
            font-size: 13px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: fadeInUp 0.3s ease;
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
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
                    addMessageToChat(data.message, true);
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    messageInput.focus();
                } else {
                    throw new Error(data.error || 'Failed to send message');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message, 'error');
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            }
        });
    }
    
    // Attachment button
    if (attachBtn && attachMenu) {
        attachBtn.addEventListener('click', function() {
            const isVisible = attachMenu.style.display === 'flex';
            attachMenu.style.display = isVisible ? 'none' : 'flex';
        });
        
        document.addEventListener('click', function(e) {
            if (!attachBtn.contains(e.target) && !attachMenu.contains(e.target)) {
                attachMenu.style.display = 'none';
            }
        });
    }
    
// Call button - initiate audio call
    const callBtn = document.getElementById('callBtn');
    if (callBtn) {
        callBtn.addEventListener('click', function() {
            initiateCall('audio');
        });
    }

    // Video button - initiate video call
    const videoBtn = document.getElementById('videoBtn');
    if (videoBtn) {
        videoBtn.addEventListener('click', function() {
            initiateCall('video');
        });
    }

    // Initialize call function
async function initiateCall(callType) {
        try {
            const response = await fetch('{{ route("messages.call.initiate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    conversation_id: {{ $conversation->id }},
                    type: callType
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showNotification(data.message || (callType === 'video' ? 'Video' : 'Audio') + ' call initiated', 'success');
                // Open call modal
                openCallModal(callType, data.call_id);
            } else {
                throw new Error(data.error || 'Failed to initiate call');
            }
        } catch (error) {
            console.error('Call error:', error);
            showNotification(error.message || 'Failed to initiate call. User may be offline.', 'error');
        }
    }

    // Call modal handling
    function openCallModal(callType, callId) {
        // Create modal if not exists
        let modal = document.getElementById('callModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'callModal';
            modal.className = 'call-modal';
            modal.innerHTML = `
                <div class="call-modal-content">
                    <div class="call-header">
                        <h4 id="callTypeTitle">${callType === 'video' ? 'Video' : 'Audio'} Call</h4>
                        <button class="close-call" id="closeCallModal">&times;</button>
                    </div>
                    <div class="call-body">
                        <div class="video-container" id="localVideoContainer">
                            <video id="localVideo" autoplay muted playsinline></video>
                        </div>
                        <div class="video-container remote" id="remoteVideoContainer">
                            <video id="remoteVideo" autoplay playsinline></video>
                            <div class="remote-placeholder" id="remotePlaceholder">
                                <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($otherUser->name ?? 'User') }}" alt="{{ $otherUser->name ?? 'User' }}">
                            </div>
                        </div>
                        <div class="call-status" id="callStatus">Connecting...</div>
                    </div>
                    <div class="call-actions">
                        <button class="call-btn mute" id="toggleMuteBtn" title="Mute">
                            <i class="fas fa-microphone"></i>
                        </button>
                        <button class="call-btn video" id="toggleVideoBtn" title="Toggle Video">
                            <i class="fas fa-video"></i>
                        </button>
                        <button class="call-btn end" id="endCallBtn" title="End Call">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        modal.style.display = 'flex';

        // Setup event listeners
        document.getElementById('closeCallModal').addEventListener('click', () => closeCallModal());
        document.getElementById('endCallBtn').addEventListener('click', () => endCall(callId));

        // Start local video
        startLocalVideo(callType);
    }

    async function startLocalVideo(callType) {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true,
                video: callType === 'video'
            });

            const localVideo = document.getElementById('localVideo');
            if (localVideo && callType === 'video') {
                localVideo.srcObject = stream;
            }

            // Hide local video for audio-only calls
            if (callType === 'audio') {
                const container = document.getElementById('localVideoContainer');
                if (container) container.style.display = 'none';
            }

            showNotification('Call connected - waiting for answer', 'info');
        } catch (error) {
            console.error('Media error:', error);
            showNotification('Could not access camera/microphone', 'error');
        }
    }

    function closeCallModal() {
        const modal = document.getElementById('callModal');
        if (modal) {
            modal.style.display = 'none';

            // Stop all tracks
            const localVideo = document.getElementById('localVideo');
            if (localVideo && localVideo.srcObject) {
                localVideo.srcObject.getTracks().forEach(track => track.stop());
            }
        }
    }

    async function endCall(callId) {
        try {
            await fetch('/messages/call/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ call_id: callId })
            });
        } catch (e) {
            console.error('Error ending call:', e);
        } finally {
            closeCallModal();
        }
    }
    
    // Menu button
    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn) {
        menuBtn.addEventListener('click', function() {
            showNotification('More options coming soon', 'info');
        });
    }
    
    // Enter key to send (Shift+Enter for new line)
    if (messageInput) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });
    }
});
</script>
@endpush
@endsection