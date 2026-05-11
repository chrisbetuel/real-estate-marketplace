@extends('layouts.app')

@section('title', 'Professional Dashboard - BuildConnect')

@section('content')
<div class="dashboard-layout">
    <!-- SIDEBAR NAVIGATION -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="company-badge">
                <span class="company-initial">{{ substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="company-info">
                <h4>{{ Auth::user()->first_name ?? Auth::user()->name }}</h4>
                <p>{{ Auth::user()->company_name ?? 'Professional' }}</p>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="#" class="nav-item active" data-section="overview">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-5v-7H9v7H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span>Overview</span>
            </a>
            <a href="#" class="nav-item" data-section="bids">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 12V8H4v12h12"/>
                    <path d="M12 2v4"/>
                    <path d="M8 2v4"/>
                    <path d="M16 2v4"/>
                    <path d="M4 12h16"/>
                </svg>
                <span>My Bids</span>
                @if(($stats['pending_bids'] ?? 0) > 0)
                    <span class="nav-badge warning">{{ $stats['pending_bids'] }}</span>
                @endif
            </a>
            <a href="#" class="nav-item" data-section="jobs">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <span>My Jobs</span>
                @if(($stats['active_jobs'] ?? 0) > 0)
                    <span class="nav-badge">{{ $stats['active_jobs'] }}</span>
                @endif
            </a>
            <a href="#" class="nav-item" data-section="messages">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span>Messages</span>
                @if(($unreadCount ?? 0) > 0)
                    <span class="nav-badge danger">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="#" class="nav-item" data-section="profile">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item" data-section="browse">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <span>Browse Jobs</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="dashboard-main">
        <div class="dashboard-container">
            
            <!-- SECTION 1: OVERVIEW -->
            <div id="section-overview" class="dashboard-section active">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>Professional Dashboard</h1>
                        <p>Welcome back, {{ Auth::user()->name }}</p>
                    </div>
                    <div class="header-right">
                        <a href="{{ route('jobs.index') }}" class="btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            Browse Jobs
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ $stats['total_bids'] ?? 0 }}</div>
                            <div class="stat-label">Total Bids</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ $stats['active_jobs'] ?? 0 }}</div>
                            <div class="stat-label">Active Jobs</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">{{ $stats['completed_jobs'] ?? 0 }}</div>
                            <div class="stat-label">Completed</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon gold">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">${{ number_format($stats['total_earned'] ?? 0, 2) }}</div>
                            <div class="stat-label">Total Earned</div>
                        </div>
                    </div>
                </div>

                <!-- Two Columns -->
                <div class="two-columns">
                    <!-- Recent Bids -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Recent Bids</h3>
                            <a href="{{ route('professional.bids') }}" class="card-link">View all →</a>
                        </div>
                        <div class="card-body">
                            @if(isset($recentBids) && $recentBids->count() > 0) 
                                @foreach($recentBids as $bid)
                                    <div class="list-item">
                                        <div class="list-item-status {{ $bid->status ?? 'pending' }}"></div>
                                        <div class="list-item-content">
                                            <div class="list-item-title">{{ Str::limit($bid->job->title ?? 'Unknown Job', 45) }}</div>
                                            <div class="list-item-meta">
                                                <span class="list-item-amount">${{ number_format($bid->amount ?? 0) }}</span>
                                                <span class="list-item-date">{{ $bid->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="list-item-badge">
                                            <span class="badge {{ $bid->status ?? 'pending' }}">
                                                {{ ucfirst($bid->status ?? 'pending') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-gavel"></i>
                                    <p>No bids submitted yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Active Jobs -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Active Jobs</h3>
                            <a href="{{ route('professional.jobs') }}" class="card-link">View all →</a>
                        </div>
                        <div class="card-body">
                            @if(isset($activeJobs) && $activeJobs->count() > 0)
                                @foreach($activeJobs as $job)
                                    <div class="list-item">
                                        <div class="list-item-icon">
                                            <i class="fas fa-hard-hat"></i>
                                        </div>
                                        <div class="list-item-content">
                                            <div class="list-item-title">
                                                <a href="{{ route('jobs.show', $job->id) }}">{{ Str::limit($job->title ?? 'Untitled', 45) }}</a>
                                            </div>
                                            <div class="list-item-meta">
                                                <span>${{ number_format($job->budget_min ?? 0) }} - ${{ number_format($job->budget_max ?? 0) }}</span>
                                                <span>{{ $job->location ?? 'Remote' }}</span>
                                            </div>
                                        </div>
                                        <div class="list-item-badge">
                                            <span class="badge in-progress">In Progress</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-briefcase"></i>
                                    <p>No active jobs</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="card full-width">
                    <div class="card-header">
                        <h3>Recent Messages</h3>
                        <a href="{{ route('messages.index') }}" class="card-link">View all →</a>
                    </div>
                    <div class="card-body">
                        @if(isset($recentMessages) && $recentMessages->count() > 0)
                            @foreach($recentMessages as $message)
                                @php
                                    $otherUser = $message->conversation->participants->firstWhere('id', '!=', Auth::id());
                                @endphp
                                <div class="message-item">
                                    <div class="message-avatar">
                                        <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=C6A43B&name=' . urlencode(substr($otherUser->name ?? 'U', 0, 1)) }}" alt="">
                                    </div>
                                    <div class="message-content">
                                        <div class="message-sender">{{ $otherUser->name ?? 'User' }}</div>
                                        <div class="message-preview">{{ Str::limit($message->message ?? '', 50) }}</div>
                                    </div>
                                    <div class="message-time">{{ $message->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-comment-dots"></i>
                                <p>No messages yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION 2: MY BIDS (FULL LIST) -->
            <div id="section-bids" class="dashboard-section">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>My Bids</h1>
                        <p>All bids you've submitted</p>
                    </div>
                    <div class="header-right">
                        <span class="total-count">{{ $stats['total_bids'] ?? 0 }} total bids</span>
                    </div>
                </div>
                <div class="card full-width">
                    <div class="card-body">
                        @if(isset($allBids) && $allBids->count() > 0)
                            @foreach($allBids as $bid)
                                <div class="list-item">
                                    <div class="list-item-status {{ $bid->status ?? 'pending' }}"></div>
                                    <div class="list-item-content">
                                        <div class="list-item-title">{{ Str::limit($bid->job->title ?? 'Unknown Job', 60) }}</div>
                                        <div class="list-item-meta">
                                            <span class="list-item-amount">${{ number_format($bid->amount ?? 0) }}</span>
                                            <span class="list-item-date">Submitted: {{ $bid->created_at->format('M d, Y') }}</span>
                                        </div>
                                        @if($bid->proposal)
                                            <div class="list-item-proposal">{{ Str::limit($bid->proposal, 80) }}</div>
                                        @endif
                                    </div>
                                    <div class="list-item-badge">
                                        <span class="badge {{ $bid->status ?? 'pending' }}">
                                            {{ ucfirst($bid->status ?? 'pending') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-gavel"></i>
                                <p>You haven't submitted any bids yet</p>
                                <a href="{{ route('jobs.index') }}" class="btn-sm">Browse Jobs →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION 3: MY JOBS (FULL LIST) -->
            <div id="section-jobs" class="dashboard-section">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>My Jobs</h1>
                        <p>Jobs assigned to you</p>
                    </div>
                    <div class="header-right">
                        <span class="total-count">{{ ($stats['active_jobs'] ?? 0) + ($stats['completed_jobs'] ?? 0) }} total jobs</span>
                    </div>
                </div>
                <div class="card full-width">
                    <div class="card-body">
                        @if(isset($myJobs) && $myJobs->count() > 0)
                            @foreach($myJobs as $job)
                                <div class="list-item">
                                    <div class="list-item-icon">
                                        <i class="fas {{ $job->status == 'completed' ? 'fa-check-circle' : 'fa-hard-hat' }}"></i>
                                    </div>
                                    <div class="list-item-content">
                                        <div class="list-item-title">
                                            <a href="{{ route('jobs.show', $job->id) }}">{{ Str::limit($job->title ?? 'Untitled', 60) }}</a>
                                        </div>
                                        <div class="list-item-meta">
                                            <span>Budget: ${{ number_format($job->budget_min ?? 0) }} - ${{ number_format($job->budget_max ?? 0) }}</span>
                                            <span>Location: {{ $job->location ?? 'Remote' }}</span>
                                            <span>Started: {{ $job->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="list-item-badge">
                                        <span class="badge {{ $job->status == 'completed' ? 'completed' : 'in-progress' }}">
                                            {{ $job->status == 'completed' ? 'Completed' : 'In Progress' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="fas fa-briefcase"></i>
                                <p>No jobs assigned to you yet</p>
                                <a href="{{ route('jobs.index') }}" class="btn-sm">Browse Jobs →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION 4: MESSAGES -->
            <div id="section-messages" class="dashboard-section">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>Messages</h1>
                        <p>Your conversations with clients</p>
                    </div>
                    @if(($unreadCount ?? 0) > 0)
                        <div class="header-right">
                            <span class="unread-badge">{{ $unreadCount }} unread</span>
                        </div>
                    @endif
                </div>
                <div class="card full-width">
                    <div class="card-body">
                        @if(isset($recentMessages) && $recentMessages->count() > 0)
                            @foreach($recentMessages as $message)
                                @php
                                    $otherUser = $message->conversation->participants->firstWhere('id', '!=', Auth::id());
                                    $convId = $message->conversation_id;
                                @endphp
                                <a href="{{ route('messages.show', $convId) }}" class="message-item-link">
                                    <div class="message-avatar">
                                        <img src="{{ $otherUser->profile_image_url ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=C6A43B&name=' . urlencode(substr($otherUser->name ?? 'U', 0, 1)) }}" alt="">
                                    </div>
                                    <div class="message-content">
                                        <div class="message-sender">{{ $otherUser->name ?? 'User' }}</div>
                                        <div class="message-preview">{{ Str::limit($message->message ?? '', 60) }}</div>
                                    </div>
                                    <div class="message-time">{{ $message->created_at->diffForHumans() }}</div>
                                </a>
                            @endforeach
                            <div class="view-all-messages">
                                <a href="{{ route('messages.index') }}" class="btn-outline">View All Messages →</a>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-comment-dots"></i>
                                <p>No messages yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION 5: PROFILE -->
            <div id="section-profile" class="dashboard-section">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>My Profile</h1>
                        <p>Manage your account information</p>
                    </div>
                    <div class="header-right">
                        <a href="{{ route('profile.edit') }}" class="btn-primary">Edit Profile</a>
                    </div>
                </div>
                <div class="profile-card">
                    <div class="profile-avatar">
                        <img src="{{ Auth::user()->profile_image_url ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=fff&name=' . urlencode(Auth::user()->name) }}" alt="">
                    </div>
                    <div class="profile-info">
                        <div class="info-row">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ Auth::user()->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ Auth::user()->address ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ Auth::user()->created_at->format('F j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 6: BROWSE JOBS -->
            <div id="section-browse" class="dashboard-section">
                <div class="dashboard-header">
                    <div class="header-left">
                        <h1>Browse Jobs</h1>
                        <p>Find opportunities that match your skills</p>
                    </div>
                </div>
                <div class="card full-width">
                    <div class="card-body">
                        @if(isset($availableJobs) && $availableJobs->count() > 0)
                            <div class="jobs-grid">
                                @foreach($availableJobs as $job)
                                    <div class="job-card">
                                        <div class="job-card-header">
                                            <h4>{{ Str::limit($job->title ?? 'Untitled', 40) }}</h4>
                                            <span class="job-price">${{ number_format($job->budget_max ?? 0) }}</span>
                                        </div>
                                        <div class="job-card-body">
                                            <p>{{ Str::limit($job->description ?? 'No description', 80) }}</p>
                                            <div class="job-card-meta">
                                                <span><i class="fas fa-map-marker-alt"></i> {{ $job->location ?? 'Remote' }}</span>
                                                <span><i class="fas fa-clock"></i> {{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="job-card-footer">
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn-outline">View Details</a>
                                            <form action="{{ route('bids.store', $job->id) }}" method="POST" class="quick-bid">
                                                @csrf
                                                <input type="hidden" name="bid_amount" value="{{ $job->budget_min ?? 100 }}">
                                                <input type="hidden" name="timeline" value="14">
                                                <input type="hidden" name="proposal" value="I'm interested in this project">
                                                <button type="submit" class="btn-bid">Quick Bid</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="view-all-jobs">
                                <a href="{{ route('jobs.index') }}" class="btn-outline">Browse All Jobs →</a>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-search"></i>
                                <p>No available jobs at the moment</p>
                                <a href="{{ route('jobs.index') }}" class="btn-sm">Browse all jobs →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

@push('styles')
<style>
/* ============================================
   PROFESSIONAL DASHBOARD - COMPLETE STYLES
============================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-layout {
    display: flex;
    min-height: calc(100vh - 64px);
    background: #F5F7FA;
}

/* SIDEBAR */
.dashboard-sidebar {
    width: 280px;
    background: #1A2C3E;
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: calc(100vh - 64px);
    flex-shrink: 0;
}

.sidebar-header {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.company-badge {
    width: 48px;
    height: 48px;
    background: #C6A43B;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-initial {
    font-size: 20px;
    font-weight: 700;
    color: #1A2C3E;
}

.company-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: #FFFFFF;
    margin: 0 0 2px 0;
}

.company-info p {
    font-size: 12px;
    color: #94A3B8;
    margin: 0;
}

.sidebar-nav {
    flex: 1;
    padding: 16px 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    color: #94A3B8;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.nav-item svg {
    width: 20px;
    height: 20px;
    stroke: #94A3B8;
}

.nav-item span {
    flex: 1;
}

.nav-item:hover {
    background: rgba(255,255,255,0.06);
    color: #FFFFFF;
}

.nav-item:hover svg {
    stroke: #C6A43B;
}

.nav-item.active {
    background: rgba(198,164,59,0.12);
    color: #C6A43B;
}

.nav-item.active svg {
    stroke: #C6A43B;
}

.nav-badge {
    background: #334155;
    color: #94A3B8;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.nav-badge.warning {
    background: rgba(245,166,35,0.2);
    color: #F5A623;
}

.nav-badge.danger {
    background: rgba(239,68,68,0.2);
    color: #F87171;
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px;
    background: transparent;
    color: #94A3B8;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: rgba(239,68,68,0.15);
    color: #F87171;
}

/* MAIN CONTENT */
.dashboard-main {
    flex: 1;
    overflow-x: auto;
    padding: 24px 0;
}

.dashboard-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Dashboard Sections */
.dashboard-section {
    display: none;
    animation: fadeIn 0.25s ease;
}

.dashboard-section.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 16px;
}

.header-left h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.header-left p {
    font-size: 14px;
    color: #6B7A8F;
    margin: 0;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #C6A43B;
    color: #1A2C3E;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #AD8E32;
}

.total-count {
    font-size: 13px;
    color: #6B7A8F;
    background: white;
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid #E2E8F0;
}

.unread-badge {
    background: #C6A43B;
    color: #1A2C3E;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid #E2E8F0;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon.purple { background: #F3E8FF; }
.stat-icon.purple i { color: #8B5CF6; font-size: 20px; }
.stat-icon.blue { background: #EFF6FF; }
.stat-icon.blue i { color: #3B82F6; font-size: 20px; }
.stat-icon.green { background: #ECFDF5; }
.stat-icon.green i { color: #10B981; font-size: 20px; }
.stat-icon.gold { background: #FEF8E8; }
.stat-icon.gold i { color: #C6A43B; font-size: 20px; }

.stat-info {
    flex: 1;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #1A2C3E;
}

.stat-label {
    font-size: 12px;
    color: #8A99B0;
}

/* Two Columns */
.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

/* Cards */
.card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

.card.full-width {
    margin-bottom: 20px;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #F0F2F5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}

.card-link {
    font-size: 12px;
    color: #C6A43B;
    text-decoration: none;
}

.card-link:hover {
    text-decoration: underline;
}

.card-body {
    padding: 0;
}

/* List Items */
.list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid #F0F2F5;
}

.list-item-status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.list-item-status.pending { background: #F59E0B; }
.list-item-status.accepted { background: #10B981; }
.list-item-status.rejected { background: #EF4444; }

.list-item-icon {
    width: 32px;
    height: 32px;
    background: #F0F2F5;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-item-icon i {
    color: #C6A43B;
    font-size: 14px;
}

.list-item-content {
    flex: 1;
}

.list-item-title {
    font-size: 13px;
    font-weight: 600;
    color: #1A2C3E;
    margin-bottom: 4px;
}

.list-item-title a {
    color: #1A2C3E;
    text-decoration: none;
}

.list-item-title a:hover {
    color: #C6A43B;
}

.list-item-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: #8A99B0;
}

.list-item-amount {
    font-weight: 600;
    color: #C6A43B;
}

.list-item-proposal {
    font-size: 11px;
    color: #8A99B0;
    margin-top: 6px;
}

.list-item-badge {
    flex-shrink: 0;
}

.badge {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.badge.pending { background: #FEF3C7; color: #D97706; }
.badge.accepted { background: #ECFDF5; color: #059669; }
.badge.rejected { background: #FEF2F2; color: #DC2626; }
.badge.in-progress { background: #EFF6FF; color: #2563EB; }
.badge.completed { background: #ECFDF5; color: #059669; }

/* Jobs Grid */
.jobs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1px;
    background: #E2E8F0;
}

.job-card {
    background: white;
    padding: 16px;
}

.job-card-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.job-card-header h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}

.job-price {
    font-size: 14px;
    font-weight: 700;
    color: #C6A43B;
}

.job-card-body p {
    font-size: 12px;
    color: #6B7A8F;
    margin-bottom: 10px;
}

.job-card-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: #8A99B0;
}

.job-card-footer {
    display: flex;
    gap: 10px;
    margin-top: 14px;
}

.btn-outline {
    flex: 1;
    padding: 7px;
    background: transparent;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #5A6E85;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s;
}

.btn-outline:hover {
    border-color: #C6A43B;
    color: #C6A43B;
}

.btn-bid {
    flex: 1;
    padding: 7px;
    background: #C6A43B;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #1A2C3E;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-bid:hover {
    background: #AD8E32;
}

.quick-bid {
    flex: 1;
}

/* Messages */
.message-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid #F0F2F5;
}

.message-item-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    text-decoration: none;
    border-bottom: 1px solid #F0F2F5;
    transition: background 0.2s;
}

.message-item-link:hover {
    background: #F8FAFC;
}

.message-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.message-content {
    flex: 1;
}

.message-sender {
    font-size: 13px;
    font-weight: 600;
    color: #1A2C3E;
    margin-bottom: 2px;
}

.message-preview {
    font-size: 12px;
    color: #8A99B0;
}

.message-time {
    font-size: 11px;
    color: #8A99B0;
}

.view-all-messages, .view-all-jobs {
    padding: 16px;
    text-align: center;
    border-top: 1px solid #F0F2F5;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 24px;
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.profile-avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-info {
    flex: 1;
}

.info-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #F0F2F5;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    width: 130px;
    font-size: 13px;
    font-weight: 600;
    color: #1A2C3E;
}

.info-value {
    flex: 1;
    font-size: 13px;
    color: #6B7A8F;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-state i {
    font-size: 40px;
    color: #CBD5E1;
    margin-bottom: 12px;
}

.empty-state p {
    font-size: 13px;
    color: #8A99B0;
    margin-bottom: 12px;
}

.btn-sm {
    display: inline-block;
    padding: 6px 16px;
    background: #C6A43B;
    color: #1A2C3E;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-sm:hover {
    background: #AD8E32;
}

/* Responsive */
@media (max-width: 900px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .two-columns {
        grid-template-columns: 1fr;
    }
    
    .jobs-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .info-row {
        flex-direction: column;
    }
    
    .info-label {
        width: auto;
        margin-bottom: 4px;
    }
}

@media (max-width: 768px) {
    .dashboard-layout {
        flex-direction: column;
    }
    
    .dashboard-sidebar {
        width: 100%;
        position: static;
        height: auto;
    }
    
    .sidebar-nav {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .nav-item {
        flex: 1;
        min-width: 100px;
        justify-content: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-container {
        padding: 0 16px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
    const sections = {
        overview: document.getElementById('section-overview'),
        bids: document.getElementById('section-bids'),
        jobs: document.getElementById('section-jobs'),
        messages: document.getElementById('section-messages'),
        profile: document.getElementById('section-profile'),
        browse: document.getElementById('section-browse')
    };
    
    function showSection(sectionId) {
        // Hide all sections
        Object.values(sections).forEach(section => {
            if (section) section.classList.remove('active');
        });
        
        // Show selected section
        if (sections[sectionId]) {
            sections[sectionId].classList.add('active');
        }
        
        // Update active state on nav items
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-section') === sectionId) {
                item.classList.add('active');
            }
        });
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // ONLY sidebar navigation items control section toggling
    // Regular links (Browse Jobs button, View all links, etc.) will work normally
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            if (sectionId) showSection(sectionId);
        });
    });
    
    // Set active section from URL hash if present
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        if (sections[hash]) showSection(hash);
    } else {
        // Default to overview
        showSection('overview');
    }
});
</script>
@endpush
@endsection