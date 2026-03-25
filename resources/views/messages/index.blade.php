@extends('layouts.app')

@section('title', 'Messages - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Your <span style="color: var(--gold-accent);">Messages</span></h1>
            <p class="lead" style="color: var(--primary-dark); opacity: 0.8;">Communicate with clients and professionals</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <div class="card-body p-0">
                    @if($conversations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                @php
                                    $otherParticipant = $conversation->participants->where('user_id', '!=', Auth::id())->first();
                                    $lastMessage = $conversation->messages()->latest()->first();
                                    $unreadCount = $conversation->messages()
                                        ->where('sender_id', '!=', Auth::id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                
                                <a href="{{ route('messages.show', $conversation) }}" class="list-group-item list-group-item-action p-4" style="border: none; border-bottom: 1px solid var(--light-grey);">
                                    <div class="d-flex align-items-center">
                                        <!-- Participant Avatar -->
                                        <div class="position-relative me-3">
                                            @if($otherParticipant && $otherParticipant->user)
                                                <img src="{{ $otherParticipant->user->profile_image ?? 'https://via.placeholder.com/60x60/0F172A/F8F8F9?text=' . substr($otherParticipant->user->name, 0, 1) }}" 
                                                     alt="{{ $otherParticipant->user->name }}"
                                                     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold-accent);">
                                            @else
                                                <img src="https://via.placeholder.com/60x60/0F172A/F8F8F9?text=U" 
                                                     alt="User"
                                                     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold-accent);">
                                            @endif
                                            
                                            @if($unreadCount > 0)
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background: var(--gold-accent); color: var(--primary-dark);">
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Conversation Info -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h5 class="fw-bold mb-0" style="color: var(--primary-dark);">
                                                    @if($otherParticipant && $otherParticipant->user)
                                                        {{ $otherParticipant->user->name }}
                                                        @if($otherParticipant->user->isProfessional())
                                                            <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent); font-size: 0.7rem;">Professional</span>
                                                        @elseif($otherParticipant->user->isStoreOwner())
                                                            <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent); font-size: 0.7rem;">Store Owner</span>
                                                        @elseif($otherParticipant->user->isClient())
                                                            <span class="badge ms-2" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent); font-size: 0.7rem;">Client</span>
                                                        @endif
                                                    @else
                                                        Unknown User
                                                    @endif
                                                </h5>
                                                @if($lastMessage)
                                                    <small class="text-muted">{{ $lastMessage->created_at->diffForHumans() }}</small>
                                                @endif
                                            </div>
                                            
                                            @if($conversation->projectJob)
                                                <p class="small mb-2" style="color: var(--gold-accent);">
                                                    <i class="fas fa-briefcase me-1"></i>Re: {{ $conversation->projectJob->title }}
                                                </p>
                                            @elseif($conversation->product)
                                                <p class="small mb-2" style="color: var(--gold-accent);">
                                                    <i class="fas fa-tools me-1"></i>Re: {{ $conversation->product->name }}
                                                </p>
                                            @endif
                                            
                                            @if($lastMessage)
                                                <p class="mb-0" style="color: var(--primary-dark); opacity: 0.8;">
                                                    @if($lastMessage->sender_id == Auth::id())
                                                        <span class="fw-semibold">You:</span>
                                                    @endif
                                                    {{ Str::limit($lastMessage->message, 60) }}
                                                </p>
                                            @else
                                                <p class="mb-0 text-muted">No messages yet</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-envelope fa-4x mb-3" style="color: var(--gold-accent); opacity: 0.5;"></i>
                            <h3 style="color: var(--primary-dark);">No Messages</h3>
                            <p style="color: var(--primary-dark); opacity: 0.7;">Start a conversation by contacting a client or professional</p>
                            <div class="mt-4">
                                <a href="{{ route('jobs.index') }}" class="btn me-2" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 50px; padding: 12px 30px; font-weight: 600;">
                                    <i class="fas fa-briefcase me-2"></i>Browse Jobs
                                </a>
                                <a href="{{ route('products.index') }}" class="btn" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 50px; padding: 12px 30px; font-weight: 600;">
                                    <i class="fas fa-tools me-2"></i>Browse Products
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection