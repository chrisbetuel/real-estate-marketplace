@extends('layouts.app')

@section('title', 'Dashboard - BuildConnect')

@section('content')
<div class="dashboard-wrapper">
    <!-- SIDEBAR NAVIGATION -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="company-badge">
                <span class="company-initial">{{ substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="company-info">
                <h4>{{ Auth::user()->first_name ?? Auth::user()->name }}</h4>
                <p>{{ Auth::user()->company_name ?? 'Contractor' }}</p>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('client.dashboard') }}" class="nav-item active" data-section="overview">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-5v-7H9v7H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span>Overview</span>
            </a>
            <a href="{{ route('client.jobs') }}" class="nav-item" data-section="jobs">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <span>My Jobs</span>
                @if(($stats['active_jobs'] ?? 0) > 0)
                    <span class="nav-badge">{{ $stats['active_jobs'] }}</span>
                @endif
            </a>
            <a href="{{ route('client.bids') }}" class="nav-item" data-section="bids">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 12V8H4v12h12"/>
                    <path d="M12 2v4"/>
                    <path d="M8 2v4"/>
                    <path d="M16 2v4"/>
                    <path d="M4 12h16"/>
                </svg>
                <span>Bids Received</span>
                @if(($stats['pending_bids'] ?? 0) > 0)
                    <span class="nav-badge warning">{{ $stats['pending_bids'] }}</span>
                @endif
            </a>
            <a href="{{ route('messages.index') }}" class="nav-item" data-section="messages">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span>Messages</span>
                @if(($unreadCount ?? 0) > 0)
                    <span class="nav-badge danger">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('profile.show') }}" class="nav-item" data-section="profile">

                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Profile</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="{{ route('jobs.create') }}" class="post-job-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Post a Job
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="dashboard-main">
        <div class="dashboard-content">
            
            <!-- SECTION 1: OVERVIEW -->
            <div id="section-overview" class="dashboard-section active">
                <div class="welcome-section">
                    <h1>Welcome back, {{ Auth::user()->first_name ?? Auth::user()->name }}</h1>
                    <p>Here's what's happening with your projects today.</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <span class="stat-label">Total Jobs</span>
                            <span class="stat-value">{{ $stats['total_jobs'] }}</span>
                        </div>
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <span class="stat-label">Open Jobs</span>
                            <span class="stat-value">{{ $stats['open_jobs'] }}</span>
                        </div>
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                                <polyline points="12 6 12 12 16 14" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <span class="stat-label">Bids Received</span>
                            <span class="stat-value">{{ $stats['total_bids_received'] }}</span>
                        </div>
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 12V8H4v12h12" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 2v4M8 2v4M16 2v4M4 12h16" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <span class="stat-label">Completion Rate</span>
                            <span class="stat-value">{{ $stats['completion_rate'] ?? 0 }}%</span>
                        </div>
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="1.5"/>
                                <polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="two-columns">
                    <!-- Recent Bids -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Recent Bids</h3>
                            <a href="{{ route('client.bids') }}" class="card-link" data-section="bids">View all →</a>

                        </div>
                        <div class="card-body">
                            @if($recentBids->count() > 0)
                                @foreach($recentBids->take(4) as $bid)
                                    <div class="bid-item">
                                        <div class="bid-avatar">
                                            <img src="{{ $bid->professional->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($bid->professional->name) }}" alt="{{ $bid->professional->name }}">
                                        </div>
                                        <div class="bid-info">
                                            <div class="bid-name">{{ $bid->professional->name }}</div>
                                            <div class="bid-job">{{ Str::limit($bid->job->title, 40) }}</div>
                                        </div>
                                        <div class="bid-amount">${{ number_format($bid->amount) }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">No bids yet</div>
                            @endif
                        </div>
                    </div>

                    <!-- Active Jobs -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Active Jobs</h3>
                            <a href="#" class="card-link" data-section="jobs">View all →</a>
                        </div>
                        <div class="card-body">
                            @php $activeJobs = $jobs->whereIn('status', ['open', 'in_progress']); @endphp
                            @if($activeJobs->count() > 0)
                                @foreach($activeJobs->take(4) as $job)
                                    <div class="job-item">
                                        <div class="job-status {{ $job->status }}"></div>
                                        <div class="job-info">
                                            <div class="job-name">{{ Str::limit($job->title, 45) }}</div>
                                            <div class="job-meta">
                                                <span>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</span>
                                                <span>{{ $job->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">No active jobs</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: MY JOBS -->
            <div id="section-jobs" class="dashboard-section">
                <div class="section-header">
                    <h2>My Jobs</h2>
                    <a href="{{ route('jobs.create') }}" class="btn-primary">+ Post New Job</a>
                </div>
                
                <div class="jobs-table">
                    @if($jobs->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th>Bids</th>
                                    <th>Posted</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td><a href="{{ route('jobs.show', $job) }}" class="job-link">{{ Str::limit($job->title, 40) }}</a></td>
                                        <td>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</td>
                                        <td><span class="status-badge {{ $job->status }}">{{ ucfirst($job->status) }}</span></td>
                                        <td>{{ $job->bids_count ?? 0 }}</td>
                                        <td>{{ $job->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('client.job-bids', $job->id) }}" class="btn-sm">View Bids</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-large">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                            <h3>No jobs yet</h3>
                            <p>Post your first job to start receiving bids</p>
                            <a href="{{ route('jobs.create') }}" class="btn-primary">Post a Job</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECTION 3: BIDS RECEIVED -->
            <div id="section-bids" class="dashboard-section">
                <div class="section-header">
                    <h2>Bids Received</h2>
                    <span class="total-bids">{{ $stats['total_bids_received'] }} total bids</span>
                </div>
                
                <div class="bids-table">
                    @if($recentBids->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Professional</th>
                                    <th>Job</th>
                                    <th>Bid Amount</th>
                                    <th>Timeline</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBids as $bid)
                                    <tr>
                                        <td>
                                            <div class="professional-cell">
                                                <img src="{{ $bid->professional->profile_image_url ?? 'https://ui-avatars.com/api/?background=1E2A3A&color=F5A623&name=' . urlencode($bid->professional->name) }}" class="professional-avatar-small" alt="">
                                                <span>{{ $bid->professional->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($bid->job->title, 35) }}</td>
                                        <td class="bid-amount-cell">${{ number_format($bid->amount) }}</td>
                                        <td>{{ $bid->estimated_days }} days</td>
                                        <td><span class="status-badge {{ $bid->status }}">{{ ucfirst($bid->status) }}</span></td>
                                        <td>
                                            @if($bid->status == 'pending')
                                                <div class="action-buttons">
                                                    <button class="btn-accept" onclick="acceptBid({{ $bid->id }})">Accept</button>
                                                    <button class="btn-decline" onclick="declineBid({{ $bid->id }})">Decline</button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-large">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                                <path d="M20 12V8H4v12h12"/>
                                <path d="M12 2v4"/>
                            </svg>
                            <h3>No bids yet</h3>
                            <p>When professionals submit bids, they'll appear here</p>
                            <a href="{{ route('jobs.create') }}" class="btn-primary">Post a Job</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECTION 4: MESSAGES -->
            <div id="section-messages" class="dashboard-section">
                <div class="section-header">
                    <h2>Messages</h2>
                    @if(($unreadCount ?? 0) > 0)
                        <span class="unread-badge">{{ $unreadCount }} unread</span>
                    @endif
                </div>
                <div class="messages-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <h3>Your messages</h3>
                    <p>View and respond to messages from professionals</p>
                    <a href="{{ route('messages.index') }}" class="btn-primary">Go to Messages</a>
                </div>
            </div>

            <!-- SECTION 5: PROFILE -->
            <div id="section-profile" class="dashboard-section">
                <div class="section-header">
                    <h2>Profile</h2>
                    <a href="{{ route('profile.edit') }}" class="btn-secondary">Edit Profile</a>
                </div>
                
                <div class="profile-grid">
                    <div class="info-card">
                        <div class="info-row">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email Address</span>
                            <span class="info-value">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">{{ Auth::user()->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Location</span>
                            <span class="info-value">{{ Auth::user()->address ?? 'Not provided' }}</span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-row">
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ Auth::user()->created_at->format('F j, Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Jobs</span>
                            <span class="info-value">{{ $stats['total_jobs'] }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Completion Rate</span>
                            <span class="info-value">{{ $stats['completion_rate'] ?? 0 }}%</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Account Status</span>
                            <span class="status-active">Active</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

@push('styles')
<style>
/* ============================================
   DASHBOARD - CLEAN & MINIMAL
   Colors: Dark Blue #1E2A3A | Gold #F5A623 | White | Grey #F1F5F9
============================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-wrapper {
    display: flex;
    min-height: calc(100vh - 64px);
    background: #F1F5F9;
}

/* ========== SIDEBAR ========== */
.dashboard-sidebar {
    width: 260px;
    background: #1E2A3A;
    position: sticky;
    top: 64px;
    height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.sidebar-header {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.company-badge {
    width: 44px;
    height: 44px;
    background: #F5A623;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-initial {
    font-size: 18px;
    font-weight: 700;
    color: #1E2A3A;
}

.company-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #FFFFFF;
    margin: 0 0 2px 0;
}

.company-info p {
    font-size: 11px;
    color: #94A3B8;
    margin: 0;
}

.sidebar-nav {
    flex: 1;
    padding: 20px 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #94A3B8;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.nav-item svg {
    width: 18px;
    height: 18px;
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
    stroke: #F5A623;
}

.nav-item.active {
    background: rgba(245,166,35,0.12);
    color: #F5A623;
}

.nav-item.active svg {
    stroke: #F5A623;
}

.nav-badge {
    background: #334155;
    color: #94A3B8;
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 10px;
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

.post-job-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px;
    background: #F5A623;
    color: #1E2A3A;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}

.post-job-btn:hover {
    background: #D4891A;
    transform: translateY(-1px);
}

/* ========== MAIN CONTENT ========== */
.dashboard-main {
    flex: 1;
    overflow-x: auto;
}

.dashboard-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 32px 32px;
}

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

/* Welcome Section */
.welcome-section {
    margin-bottom: 28px;
}

.welcome-section h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1E2A3A;
    margin: 0 0 4px 0;
}

.welcome-section p {
    font-size: 14px;
    color: #64748B;
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}

.stat-card {
    background: #FFFFFF;
    border-radius: 14px;
    padding: 18px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #E2E8F0;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 12px;
    font-weight: 500;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1E2A3A;
}

.stat-icon {
    width: 44px;
    height: 44px;
    background: rgba(30,42,58,0.06);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon svg {
    width: 22px;
    height: 22px;
    stroke: #1E2A3A;
}

/* Two Columns Layout */
.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Cards */
.card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 15px;
    font-weight: 600;
    color: #1E2A3A;
    margin: 0;
}

.card-link {
    font-size: 12px;
    color: #64748B;
    text-decoration: none;
    transition: color 0.2s;
}

.card-link:hover {
    color: #F5A623;
}

.card-body {
    padding: 0;
}

/* Bid Items */
.bid-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid #F8FAFC;
}

.bid-item:last-child {
    border-bottom: none;
}

.bid-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.bid-info {
    flex: 1;
}

.bid-name {
    font-size: 13px;
    font-weight: 600;
    color: #1E2A3A;
    margin-bottom: 2px;
}

.bid-job {
    font-size: 11px;
    color: #64748B;
}

.bid-amount {
    font-size: 14px;
    font-weight: 700;
    color: #F5A623;
}

/* Job Items */
.job-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid #F8FAFC;
}

.job-item:last-child {
    border-bottom: none;
}

.job-status {
    width: 3px;
    height: 36px;
    border-radius: 3px;
}

.job-status.open {
    background: #F5A623;
}

.job-status.in_progress {
    background: #1E2A3A;
}

.job-info {
    flex: 1;
}

.job-name {
    font-size: 13px;
    font-weight: 500;
    color: #1E2A3A;
    margin-bottom: 4px;
}

.job-meta {
    display: flex;
    gap: 16px;
    font-size: 11px;
    color: #94A3B8;
}

/* Section Headers */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.section-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: #1E2A3A;
    margin: 0;
}

.total-bids {
    font-size: 13px;
    color: #64748B;
    background: #FFFFFF;
    padding: 5px 12px;
    border-radius: 20px;
    border: 1px solid #E2E8F0;
}

.unread-badge {
    background: #F5A623;
    color: #1E2A3A;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* Buttons */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: #F5A623;
    color: #1E2A3A;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #D4891A;
    transform: translateY(-1px);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: #FFFFFF;
    color: #1E2A3A;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #F8FAFC;
}

.btn-sm {
    padding: 5px 12px;
    background: #F1F5F9;
    color: #1E2A3A;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-sm:hover {
    background: #F5A623;
    color: #1E2A3A;
}

/* Tables */
.data-table {
    width: 100%;
    background: #FFFFFF;
    border-radius: 14px;
    border-collapse: collapse;
    overflow: hidden;
}

.data-table th {
    text-align: left;
    padding: 14px 16px;
    background: #F8FAFC;
    font-size: 12px;
    font-weight: 600;
    color: #64748B;
    border-bottom: 1px solid #E2E8F0;
}

.data-table td {
    padding: 14px 16px;
    font-size: 13px;
    color: #1E2A3A;
    border-bottom: 1px solid #F1F5F9;
}

.data-table tr:last-child td {
    border-bottom: none;
}

.job-link {
    color: #1E2A3A;
    text-decoration: none;
    font-weight: 500;
}

.job-link:hover {
    color: #F5A623;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}

.status-badge.open {
    background: rgba(245,166,35,0.1);
    color: #F5A623;
}

.status-badge.in_progress {
    background: rgba(30,42,58,0.08);
    color: #1E2A3A;
}

.status-badge.pending {
    background: rgba(245,166,35,0.1);
    color: #F5A623;
}

.status-badge.accepted {
    background: rgba(16,185,129,0.1);
    color: #059669;
}

.bid-amount-cell {
    font-weight: 600;
    color: #F5A623;
}

.professional-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.professional-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-accept {
    padding: 4px 12px;
    background: #F5A623;
    border: none;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    color: #1E2A3A;
    cursor: pointer;
}

.btn-decline {
    padding: 4px 12px;
    background: #F1F5F9;
    border: none;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 500;
    color: #64748B;
    cursor: pointer;
}

.btn-accept:hover {
    background: #D4891A;
}

.btn-decline:hover {
    background: #E2E8F0;
}

/* Profile Grid */
.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-card {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    padding: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #F1F5F9;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 12px;
    font-weight: 500;
    color: #64748B;
}

.info-value {
    font-size: 13px;
    font-weight: 500;
    color: #1E2A3A;
}

.status-active {
    display: inline-block;
    padding: 3px 10px;
    background: rgba(16,185,129,0.1);
    color: #059669;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 36px 20px;
    color: #94A3B8;
    font-size: 13px;
}

.empty-large {
    text-align: center;
    padding: 60px 24px;
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
}

.empty-large svg {
    margin-bottom: 16px;
}

.empty-large h3 {
    font-size: 18px;
    font-weight: 500;
    color: #1E2A3A;
    margin-bottom: 8px;
}

.empty-large p {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 20px;
}

.messages-placeholder {
    text-align: center;
    padding: 60px 24px;
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
}

.messages-placeholder svg {
    margin-bottom: 16px;
}

.messages-placeholder h3 {
    font-size: 18px;
    font-weight: 500;
    color: #1E2A3A;
    margin-bottom: 8px;
}

.messages-placeholder p {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 20px;
}

/* Tables Container */
.jobs-table, .bids-table {
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

/* Responsive */
@media (max-width: 900px) {
    .dashboard-sidebar {
        width: 220px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .two-columns {
        grid-template-columns: 1fr;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-wrapper {
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
    
    .dashboard-content {
        padding: 20px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    const sections = {
        overview: document.getElementById('section-overview'),
        jobs: document.getElementById('section-jobs'),
        bids: document.getElementById('section-bids'),
        messages: document.getElementById('section-messages'),
        profile: document.getElementById('section-profile')
    };
    
    function showSection(sectionId) {
        Object.values(sections).forEach(section => {
            if (section) section.classList.remove('active');
        });
        
        if (sections[sectionId]) {
            sections[sectionId].classList.add('active');
        }
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-section') === sectionId) {
                item.classList.add('active');
            }
        });
        
        localStorage.setItem('activeSection', sectionId);
    }
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const sectionId = this.getAttribute('data-section');

            // Only toggle sections for in-page links (href="#").
            if (sectionId && href === '#') {
                e.preventDefault();
                showSection(sectionId);
                return;
            }

            // For real navigation links, do nothing (browser will navigate).
        });
    });


    
    const lastSection = localStorage.getItem('activeSection');
    if (lastSection && sections[lastSection]) {
        showSection(lastSection);
    }
});

function acceptBid(bidId) {
    if (confirm('Accept this bid?')) {
        fetch(`/client/bids/${bidId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => { if (data.success) location.reload(); });
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
          .then(data => { if (data.success) location.reload(); });
    }
}
</script>
@endpush
@endsection