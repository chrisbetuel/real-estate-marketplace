@extends('layouts.app')

@section('title', 'Dashboard - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Welcome Section - American Bold -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Good {{ \Carbon\Carbon::now()->format('A') == 'AM' ? 'morning' : 'afternoon' }}, {{ Auth::user()->first_name ?? Auth::user()->name }}</h1>
                <p>Here's what's happening with your business today.</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('jobs.create') }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Post a Job
                </a>
                <a href="{{ route('messages.index') }}" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    Messages
                    @if(($unreadCount ?? 0) > 0)
                        <span class="badge">{{ $unreadCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Stats Cards - American Financial Style -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Jobs</span>
                    <span class="stat-value">{{ $stats['total_jobs'] }}</span>
                </div>
                <div class="stat-icon total">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Open Jobs</span>
                    <span class="stat-value">{{ $stats['open_jobs'] }}</span>
                </div>
                <div class="stat-icon open">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Bids Received</span>
                    <span class="stat-value">{{ $stats['total_bids_received'] }}</span>
                    @if(($stats['bid_growth'] ?? 0) != 0)
                        <span class="stat-trend {{ ($stats['bid_growth'] ?? 0) > 0 ? 'up' : 'down' }}">
                            {{ ($stats['bid_growth'] ?? 0) > 0 ? '+' : '' }}{{ $stats['bid_growth'] ?? 0 }}%
                        </span>
                    @endif
                </div>
                <div class="stat-icon bids">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 12V8H4v12h12"/>
                        <path d="M12 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                        <path d="M4 12h16"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Completion Rate</span>
                    <span class="stat-value">{{ $stats['completion_rate'] ?? 0 }}%</span>
                </div>
                <div class="stat-icon completed">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Actions Row -->
        <div class="quick-actions">
            <a href="{{ route('client.jobs') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div>
                    <h4>Manage Jobs</h4>
                    <p>{{ $stats['active_jobs'] ?? 0 }} active listings</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>
            <a href="{{ route('client.bids') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 12V8H4v12h12"/>
                        <path d="M12 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                        <path d="M4 12h16"/>
                    </svg>
                </div>
                <div>
                    <h4>Review Bids</h4>
                    <p>{{ $stats['pending_bids'] ?? 0 }} pending review</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="quick-card">
                <div class="quick-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div>
                    <h4>Company Profile</h4>
                    <p>Update your business info</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>
            <a href="#" class="quick-card">
                <div class="quick-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" x2="22" y="6" width="20" height="12" rx="2"/>
                        <path d="M2 10h20"/>
                        <path d="M7 15h4"/>
                    </svg>
                </div>
                <div>
                    <h4>Payments</h4>
                    <p>${{ number_format($stats['total_spent'] ?? 0) }} spent</p>
                </div>
                <span class="quick-arrow">→</span>
            </a>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Recent Bids Section -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>Recent Bids</h3>
                        <p>Latest proposals from professionals</p>
                    </div>
                    <a href="{{ route('client.bids') }}" class="card-link">View All →</a>
                </div>
                <div class="card-body">
                    @if($recentBids->count() > 0)
                        <div class="bids-list">
                            @foreach($recentBids as $bid)
                                <div class="bid-item">
                                    <div class="bid-avatar">
                                        <img src="{{ $bid->professional->profile_image_url ?? 'https://ui-avatars.com/api/?background=2563EB&color=fff&name=' . urlencode($bid->professional->name) }}" alt="{{ $bid->professional->name }}">
                                        @if($bid->professional->is_verified ?? false)
                                            <span class="verified-badge">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="bid-details">
                                        <div class="bid-row-top">
                                            <h4>{{ $bid->professional->name }}</h4>
                                            <span class="bid-amount">${{ number_format($bid->amount) }}</span>
                                        </div>
                                        <div class="bid-job">{{ Str::limit($bid->job->title, 60) }}</div>
                                        <div class="bid-footer">
                                            <span class="bid-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $bid->estimated_days }} days</span>
                                            <span class="bid-proposal">{{ Str::limit($bid->proposal, 70) }}</span>
                                        </div>
                                    </div>
                                    <div class="bid-actions">
                                        <span class="status-badge {{ $bid->status }}">
                                            @if($bid->status == 'pending') Pending
                                            @elseif($bid->status == 'accepted') Accepted
                                            @else Declined
                                            @endif
                                        </span>
                                        @if($bid->status == 'pending')
                                            <div class="action-buttons">
                                                <button class="accept-btn" onclick="acceptBid({{ $bid->id }})">Accept</button>
                                                <button class="decline-btn" onclick="declineBid({{ $bid->id }})">Decline</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('client.bids') }}">View all bids →</a>
                        </div>
                    @else
                        <div class="empty-state">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                <path d="M20 12V8H4v12h12"/>
                                <path d="M12 2v4"/>
                                <path d="M8 2v4"/>
                                <path d="M16 2v4"/>
                                <path d="M4 12h16"/>
                            </svg>
                            <h4>No bids yet</h4>
                            <p>When professionals submit bids, they'll appear here</p>
                            <a href="{{ route('jobs.create') }}" class="btn-outline">Post a Job</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Active Jobs Section -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>Active Jobs</h3>
                        <p>Jobs needing your attention</p>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $activeJobs = $jobs->whereIn('status', ['open', 'in_progress']);
                    @endphp
                    
                    @if($activeJobs->count() > 0)
                        <div class="jobs-list">
                            @foreach($activeJobs->take(5) as $job)
                                <div class="job-item">
                                    <div class="job-status-indicator {{ $job->status }}"></div>
                                    <div class="job-details">
                                        <div class="job-title">
                                            <a href="{{ route('jobs.show', $job) }}">{{ Str::limit($job->title, 55) }}</a>
                                            <span class="job-badge {{ $job->status }}">
                                                {{ $job->status == 'open' ? 'Open' : 'In Progress' }}
                                            </span>
                                        </div>
                                        <div class="job-meta">
                                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>{{ $job->created_at->diffForHumans() }}</span>
                                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 12V8H4v12h12"/><path d="M12 2v4"/></svg>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</span>
                                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $job->location ?? 'Remote' }}</span>
                                        </div>
                                    </div>
                                    <div class="job-action">
                                        @if($job->status == 'open')
                                            <a href="{{ route('client.job-bids', $job->id) }}" class="bids-btn">
                                                View Bids
                                                @if($job->bids_count > 0)
                                                    <span class="bid-count">{{ $job->bids_count }}</span>
                                                @endif
                                            </a>
                                        @else
                                            <form action="{{ route('client.complete-job', $job->id) }}" method="POST" class="complete-form">
                                                @csrf
                                                <button type="submit" class="complete-btn" onclick="return confirm('Mark this job as completed?')">
                                                    Mark Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($activeJobs->count() > 5)
                            <div class="card-footer">
                                <a href="{{ route('client.jobs') }}">View all {{ $activeJobs->count() }} active jobs →</a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                            <h4>No active jobs</h4>
                            <p>Post your first job to start receiving bids</p>
                            <a href="{{ route('jobs.create') }}" class="btn-outline">Post a Job</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="activity-card">
            <div class="activity-header">
                <h3>Recent Activity</h3>
                <a href="#" class="card-link">View History →</a>
            </div>
            <div class="activity-timeline">
                @php
                    $activities = $recentActivities ?? collect();
                @endphp
                @forelse($activities->take(5) as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity->type }}">
                            @if($activity->type == 'bid')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 12V8H4v12h12"/><path d="M12 2v4"/></svg>
                            @elseif($activity->type == 'job')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/></svg>
                            @elseif($activity->type == 'message')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            @endif
                        </div>
                        <div class="activity-content">
                            <p>{{ $activity->description }}</p>
                            <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="activity-empty">
                        <p>No recent activity to show</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ═══════════════════════════════════════════
   AMERICAN STYLE DASHBOARD
   Clean | Bold | Data-Driven | Functional
═══════════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    background: #F1F5F9;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ═══════════════════════════════════════════
   TYPOGRAPHY
═══════════════════════════════════════════ */
h1, h2, h3, h4 {
    font-weight: 600;
    letter-spacing: -0.02em;
}

/* ═══════════════════════════════════════════
   WELCOME SECTION
═══════════════════════════════════════════ */
.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 32px;
}

.welcome-text h1 {
    font-size: 28px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.welcome-text p {
    font-size: 15px;
    color: #475569;
    margin: 0;
}

.welcome-actions {
    display: flex;
    gap: 12px;
}

/* Buttons - Clean American Style */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #2563EB;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}

.btn-primary:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    color: #1E293B;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #F8FAFC;
    border-color: #CBD5E1;
}

.btn-secondary .badge {
    background: #EF4444;
    color: white;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 4px;
}

.btn-outline {
    display: inline-block;
    padding: 10px 20px;
    background: transparent;
    color: #2563EB;
    border: 1px solid #2563EB;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-outline:hover {
    background: #2563EB;
    color: white;
}

/* ═══════════════════════════════════════════
   STATS CARDS
═══════════════════════════════════════════ */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.stat-card:hover {
    border-color: #CBD5E1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 13px;
    font-weight: 500;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1;
}

.stat-trend {
    font-size: 12px;
    font-weight: 600;
    margin-top: 8px;
}

.stat-trend.up {
    color: #10B981;
}

.stat-trend.down {
    color: #EF4444;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon.total {
    background: #EFF6FF;
}
.stat-icon.total svg { stroke: #2563EB; }

.stat-icon.open {
    background: #FEF3C7;
}
.stat-icon.open svg { stroke: #D97706; }

.stat-icon.bids {
    background: #ECFDF5;
}
.stat-icon.bids svg { stroke: #10B981; }

.stat-icon.completed {
    background: #F3E8FF;
}
.stat-icon.completed svg { stroke: #8B5CF6; }

/* ═══════════════════════════════════════════
   QUICK ACTIONS
═══════════════════════════════════════════ */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.quick-card {
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.quick-card:hover {
    border-color: #2563EB;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.quick-icon {
    width: 44px;
    height: 44px;
    background: #F8FAFC;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-icon svg {
    stroke: #2563EB;
}

.quick-card h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.quick-card p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
}

.quick-arrow {
    margin-left: auto;
    color: #94A3B8;
    font-size: 18px;
    transition: transform 0.2s;
}

.quick-card:hover .quick-arrow {
    transform: translateX(4px);
    color: #2563EB;
}

/* ═══════════════════════════════════════════
   CONTENT GRID
═══════════════════════════════════════════ */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

/* ═══════════════════════════════════════════
   CARDS
═══════════════════════════════════════════ */
.card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.card-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.card-link {
    font-size: 13px;
    font-weight: 500;
    color: #2563EB;
    text-decoration: none;
}

.card-link:hover {
    color: #1D4ED8;
}

.card-footer {
    padding: 16px 24px;
    border-top: 1px solid #F1F5F9;
    text-align: center;
}

.card-footer a {
    font-size: 13px;
    font-weight: 500;
    color: #2563EB;
    text-decoration: none;
}

/* ═══════════════════════════════════════════
   BIDS LIST
═══════════════════════════════════════════ */
.bids-list {
    display: flex;
    flex-direction: column;
}

.bid-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
}

.bid-item:hover {
    background: #F8FAFC;
}

.bid-avatar {
    position: relative;
    flex-shrink: 0;
}

.bid-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.verified-badge {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    background: #2563EB;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

.verified-badge svg {
    stroke: white;
}

.bid-details {
    flex: 1;
}

.bid-row-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 4px;
}

.bid-row-top h4 {
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.bid-amount {
    font-size: 16px;
    font-weight: 700;
    color: #0F172A;
}

.bid-job {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 8px;
}

.bid-footer {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.bid-time {
    font-size: 12px;
    color: #94A3B8;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.bid-proposal {
    font-size: 12px;
    color: #475569;
}

.bid-actions {
    text-align: right;
    flex-shrink: 0;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}

.status-badge.pending {
    background: #FEF3C7;
    color: #D97706;
}

.status-badge.accepted {
    background: #ECFDF5;
    color: #059669;
}

.status-badge.declined {
    background: #FEF2F2;
    color: #DC2626;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.accept-btn, .decline-btn {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.accept-btn {
    background: #10B981;
    color: white;
}

.accept-btn:hover {
    background: #059669;
}

.decline-btn {
    background: #F1F5F9;
    color: #64748B;
}

.decline-btn:hover {
    background: #E2E8F0;
    color: #DC2626;
}

/* ═══════════════════════════════════════════
   JOBS LIST
═══════════════════════════════════════════ */
.jobs-list {
    display: flex;
    flex-direction: column;
}

.job-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
}

.job-item:hover {
    background: #F8FAFC;
}

.job-status-indicator {
    width: 3px;
    height: 40px;
    border-radius: 3px;
    flex-shrink: 0;
}

.job-status-indicator.open {
    background: #F59E0B;
}

.job-status-indicator.in_progress {
    background: #3B82F6;
}

.job-details {
    flex: 1;
}

.job-title {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

.job-title a {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    text-decoration: none;
}

.job-title a:hover {
    color: #2563EB;
}

.job-badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.job-badge.open {
    background: #FEF3C7;
    color: #D97706;
}

.job-badge.in_progress {
    background: #EFF6FF;
    color: #2563EB;
}

.job-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.job-meta span {
    font-size: 12px;
    color: #64748B;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.job-action {
    flex-shrink: 0;
}

.bids-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: transparent;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #1E293B;
    text-decoration: none;
    transition: all 0.2s;
}

.bids-btn:hover {
    background: #F8FAFC;
    border-color: #2563EB;
}

.bid-count {
    background: #2563EB;
    color: white;
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.complete-btn {
    padding: 8px 16px;
    background: #10B981;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.complete-btn:hover {
    background: #059669;
}

.complete-form {
    margin: 0;
}

/* ═══════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════ */
.empty-state {
    text-align: center;
    padding: 48px 24px;
}

.empty-state svg {
    margin-bottom: 16px;
}

.empty-state h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1E293B;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 20px;
}

/* ═══════════════════════════════════════════
   ACTIVITY CARD
═══════════════════════════════════════════ */
.activity-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

.activity-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.activity-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.activity-timeline {
    padding: 8px 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    border-bottom: 1px solid #F1F5F9;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-icon.bid {
    background: #ECFDF5;
}
.activity-icon.bid svg { stroke: #10B981; }

.activity-icon.job {
    background: #EFF6FF;
}
.activity-icon.job svg { stroke: #2563EB; }

.activity-icon.message {
    background: #FEF3C7;
}
.activity-icon.message svg { stroke: #D97706; }

.activity-content {
    flex: 1;
}

.activity-content p {
    font-size: 14px;
    color: #1E293B;
    margin: 0 0 4px 0;
}

.activity-time {
    font-size: 12px;
    color: #94A3B8;
}

.activity-empty {
    padding: 40px 24px;
    text-align: center;
    color: #94A3B8;
}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 24px 0;
    }
    
    .container {
        padding: 0 16px;
    }
    
    .welcome-section {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-actions {
        width: 100%;
        justify-content: center;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .bid-item, .job-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .bid-actions {
        text-align: left;
        width: 100%;
    }
    
    .action-buttons {
        width: 100%;
    }
    
    .accept-btn, .decline-btn {
        flex: 1;
    }
}

@media (max-width: 480px) {
    .welcome-actions {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        justify-content: center;
        width: 100%;
    }
    
    .job-meta {
        gap: 12px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Helper functions for bid actions
function acceptBid(bidId) {
    if (confirm('Accept this bid?')) {
        fetch(`/client/bids/${bidId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}

function declineBid(bidId) {
    if (confirm('Decline this bid?')) {
        fetch(`/client/bids/${bidId}/decline`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}
</script>
@endpush
@endsection