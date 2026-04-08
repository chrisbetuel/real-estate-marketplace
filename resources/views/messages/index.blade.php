@extends('layouts.app')

@section('title', 'Messages - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="position-relative d-inline-block mb-4">
                <h1 class="fw-bold mb-2">Messages</h1>
                <div style="position: absolute; bottom: -8px; left: 0; width: 60px; height: 3px; background: var(--brand-gold); border-radius: 3px;"></div>
            </div>
            <p class="text-muted mb-4">Your conversations with professionals and clients</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($conversations->count() > 0)
                <div class="messages-list">
                    @foreach($conversations as $conversation)
                        @php
                            $otherUser = $conversation->participants->firstWhere('id', '!=', Auth::id());
                            $unreadCount = $conversation->unreadCountForUser(Auth::id());
                        @endphp
                        <a href="{{ route('messages.show', $conversation->id) }}" class="message-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                            <div class="message-avatar">
                                <img src="{{ $otherUser->profile_image_url }}" alt="{{ $otherUser->name }}">
                            </div>
                            <div class="message-content">
                                <div class="message-header">
                                    <h5 class="message-name">{{ $otherUser->name }}</h5>
                                    <span class="message-time">{{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'No messages' }}</span>
                                </div>
                                <div class="message-preview">
                                    @if($conversation->lastMessage)
                                        <p>{{ Str::limit($conversation->lastMessage->message, 50) }}</p>
                                    @else
                                        <p class="text-muted">No messages yet</p>
                                    @endif
                                    @if($unreadCount > 0)
                                        <span class="unread-badge">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                                @if($conversation->job)
                                    <div class="message-job">
                                        <i class="fas fa-briefcase me-1"></i> {{ Str::limit($conversation->job->title, 40) }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>No messages yet</h5>
                    <p>When you start a conversation, it will appear here</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .messages-list {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        overflow: hidden;
    }
    
    .message-item {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid var(--gray-200);
        text-decoration: none;
        transition: background 0.2s;
        position: relative;
    }
    
    .message-item:hover {
        background: var(--gray-50);
    }
    
    .message-item.unread {
        background: rgba(201, 165, 59, 0.05);
    }
    
    .message-item:last-child {
        border-bottom: none;
    }
    
    .message-avatar {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        margin-right: 16px;
    }
    
    .message-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--brand-gold);
    }
    
    .message-content {
        flex: 1;
        min-width: 0;
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .message-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: var(--gray-500);
    }
    
    .message-preview {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    
    .message-preview p {
        font-size: 0.85rem;
        color: var(--gray-600);
        margin-bottom: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }
    
    .unread-badge {
        display: inline-block;
        background: var(--brand-gold);
        color: var(--brand-dark);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        min-width: 24px;
        text-align: center;
    }
    
    .message-job {
        margin-top: 8px;
        font-size: 0.7rem;
        color: var(--gray-500);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .empty-icon i {
        font-size: 2.5rem;
        color: var(--brand-gold);
    }
    
    .empty-state h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-bottom: 0;
    }
</style>
@endpush
@endsection