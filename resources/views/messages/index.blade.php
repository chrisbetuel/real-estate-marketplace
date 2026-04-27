@extends('layouts.app')

@section('title', 'Messages - Oweru BuildConnect')

@section('content')
<div class="messages-app">
    <div class="messages-container">
        <!-- Header -->
        <div class="messages-header">
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <h1>Messages</h1>
            </div>
            <div class="header-right">
                <button class="icon-btn" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
                <button class="icon-btn" id="newChatBtn">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar" id="searchBar" style="display: none;">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search conversations..." id="searchInput">
                <button class="clear-search" id="clearSearch">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Messages List -->
        <div class="messages-list" id="messagesList">
            @if($conversations->count() > 0)
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = $conversation->participants->firstWhere('id', '!=', Auth::id());
                        $unreadCount = $conversation->unreadCountForUser(Auth::id());
                        $lastMessage = $conversation->lastMessage;
                        $isOnline = $otherUser->is_online ?? false;
                    @endphp
                    <a href="{{ route('messages.show', $conversation->id) }}" class="message-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                        <div class="message-avatar">
                            <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($otherUser->name) }}" alt="{{ $otherUser->name }}">
                            <span class="online-dot {{ $isOnline ? 'online' : '' }}"></span>
                        </div>
                        <div class="message-details">
                            <div class="message-top">
                                <h4 class="contact-name">{{ $otherUser->name }}</h4>
                                <span class="message-time">
                                    @if($lastMessage)
                                        {{ $lastMessage->created_at->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                            <div class="message-bottom">
                                <div class="message-preview">
                                    @if($lastMessage)
                                        @if($lastMessage->user_id == Auth::id())
                                            <span class="sent-indicator">
                                                <i class="fas fa-check-double {{ $lastMessage->is_read ? 'read' : '' }}"></i>
                                            </span>
                                        @endif
                                        <p>{{ Str::limit($lastMessage->message, 45) }}</p>
                                    @else
                                        <p class="text-muted">No messages yet</p>
                                    @endif
                                </div>
                                @if($unreadCount > 0)
                                    <span class="unread-badge">{{ $unreadCount }}</span>
                                @endif
                            </div>
                            @if($conversation->job)
                                <div class="job-ref">
                                    <i class="fas fa-briefcase"></i> {{ Str::limit($conversation->job->title, 35) }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3>No messages yet</h3>
                    <p>When you start a conversation, it will appear here</p>
                    <a href="{{ route('jobs.index') }}" class="empty-btn">Browse Jobs</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Messages App Styles - Phone SMS Inbox */
    .messages-app {
        background: #F5F7FA;
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .messages-container {
        max-width: 600px;
        width: 100%;
        background: white;
        border-radius: 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        height: 700px;
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .messages-header {
        background: #1E2A3A;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
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

    .messages-header h1 {
        font-size: 20px;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .header-right {
        display: flex;
        gap: 12px;
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
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-btn:hover {
        background: #F5A623;
        color: #1E2A3A;
    }

    /* Search Bar */
    .search-bar {
        padding: 12px 16px;
        background: white;
        border-bottom: 1px solid #E2E8F0;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        background: #F1F5F9;
        border-radius: 24px;
        padding: 8px 16px;
        gap: 10px;
    }

    .search-wrapper i {
        color: #94A3B8;
        font-size: 14px;
    }

    .search-wrapper input {
        flex: 1;
        border: none;
        background: none;
        font-size: 14px;
        outline: none;
    }

    .search-wrapper input::placeholder {
        color: #94A3B8;
    }

    .clear-search {
        background: none;
        border: none;
        color: #94A3B8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Messages List */
    .messages-list {
        flex: 1;
        overflow-y: auto;
    }

    .message-item {
        display: flex;
        padding: 16px;
        border-bottom: 1px solid #F1F5F9;
        text-decoration: none;
        transition: all 0.2s;
        position: relative;
    }

    .message-item:hover {
        background: #F8FAFC;
    }

    .message-item.unread {
        background: rgba(245,166,35,0.05);
    }

    .message-avatar {
        position: relative;
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        margin-right: 14px;
    }

    .message-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .online-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        background: #9CA3AF;
    }

    .online-dot.online {
        background: #10B981;
    }

    .message-details {
        flex: 1;
        min-width: 0;
    }

    .message-top {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .contact-name {
        font-size: 15px;
        font-weight: 600;
        color: #1E293B;
        margin: 0;
    }

    .message-time {
        font-size: 11px;
        color: #94A3B8;
    }

    .message-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .message-preview {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        min-width: 0;
    }

    .sent-indicator {
        display: inline-flex;
        align-items: center;
    }

    .sent-indicator i {
        font-size: 12px;
        color: #94A3B8;
    }

    .sent-indicator i.read {
        color: #34B7F1;
    }

    .message-preview p {
        font-size: 13px;
        color: #64748B;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .message-item.unread .contact-name {
        color: #1E2A3A;
    }

    .message-item.unread .message-preview p {
        color: #1E293B;
        font-weight: 500;
    }

    .unread-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        background: #F5A623;
        color: #1E2A3A;
        font-size: 11px;
        font-weight: 700;
        border-radius: 20px;
        padding: 0 6px;
    }

    .job-ref {
        margin-top: 6px;
        font-size: 11px;
        color: #94A3B8;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .job-ref i {
        font-size: 10px;
    }

    /* Empty State */
    .empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 24px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: rgba(245,166,35,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .empty-icon i {
        font-size: 36px;
        color: #F5A623;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 20px;
    }

    .empty-btn {
        display: inline-block;
        padding: 10px 24px;
        background: #1E2A3A;
        color: white;
        border-radius: 40px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .empty-btn:hover {
        background: #F5A623;
        color: #1E2A3A;
    }

    /* Scrollbar */
    .messages-list::-webkit-scrollbar {
        width: 4px;
    }

    .messages-list::-webkit-scrollbar-track {
        background: #E2E8F0;
    }

    .messages-list::-webkit-scrollbar-thumb {
        background: #94A3B8;
        border-radius: 4px;
    }

    /* Responsive */
    @media (max-width: 600px) {
        .messages-app {
            padding: 0;
        }
        
        .messages-container {
            border-radius: 0;
            height: 100vh;
        }
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-item {
        animation: slideIn 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchBtn = document.getElementById('searchBtn');
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const messageItems = document.querySelectorAll('.message-item');
    
    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', function() {
            const isVisible = searchBar.style.display === 'flex';
            searchBar.style.display = isVisible ? 'none' : 'flex';
            if (!isVisible) {
                searchInput.focus();
            } else {
                searchInput.value = '';
                filterMessages('');
            }
        });
    }
    
    // Search filter
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            filterMessages(query);
        });
    }
    
    // Clear search
    if (clearSearch) {
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            filterMessages('');
            searchInput.focus();
        });
    }
    
    function filterMessages(query) {
        messageItems.forEach(item => {
            const contactName = item.querySelector('.contact-name')?.textContent.toLowerCase() || '';
            const messagePreview = item.querySelector('.message-preview p')?.textContent.toLowerCase() || '';
            const jobRef = item.querySelector('.job-ref')?.textContent.toLowerCase() || '';
            
            if (contactName.includes(query) || messagePreview.includes(query) || jobRef.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide empty search state
        const visibleMessages = document.querySelectorAll('.message-item[style="display: flex;"]');
        const emptyState = document.querySelector('.empty-state');
        
        if (visibleMessages.length === 0 && messageItems.length > 0) {
            if (!document.querySelector('.search-empty')) {
                const emptySearch = document.createElement('div');
                emptySearch.className = 'empty-state search-empty';
                emptySearch.innerHTML = `
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No results found</h3>
                    <p>Try a different search term</p>
                `;
                document.querySelector('.messages-list').appendChild(emptySearch);
            }
        } else {
            const searchEmpty = document.querySelector('.search-empty');
            if (searchEmpty) searchEmpty.remove();
        }
    }
    
    // New chat button
    const newChatBtn = document.getElementById('newChatBtn');
    if (newChatBtn) {
        newChatBtn.addEventListener('click', function() {
            // Redirect to jobs page to start a new conversation
            window.location.href = '{{ route("jobs.index") }}';
        });
    }
});
</script>
@endpush
@endsection