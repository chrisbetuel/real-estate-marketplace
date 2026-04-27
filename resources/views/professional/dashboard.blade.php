@extends('layouts.app')

@section('title', 'Professional Dashboard - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Welcome back, <span>{{ Auth::user()->name }}</span></h1>
                <p>Manage your bids, track your projects, and grow your business</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('jobs.index') }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Browse Jobs
                </a>
                <a href="{{ route('professional.bids') }}" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 12V8H4v12h12"/>
                        <path d="M12 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                        <path d="M4 12h16"/>
                    </svg>
                    My Bids
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Bids</span>
                    <span class="stat-value">{{ $stats['total_bids'] }}</span>
                </div>
                <div class="stat-icon total">
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
                    <span class="stat-label">Pending</span>
                    <span class="stat-value">{{ $stats['pending_bids'] }}</span>
                    @if(($stats['pending_change'] ?? 0) != 0)
                        <span class="stat-trend {{ ($stats['pending_change'] ?? 0) > 0 ? 'up' : 'down' }}">
                            {{ ($stats['pending_change'] ?? 0) > 0 ? '+' : '' }}{{ $stats['pending_change'] ?? 0 }}%
                        </span>
                    @endif
                </div>
                <div class="stat-icon pending">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Accepted</span>
                    <span class="stat-value">{{ $stats['accepted_bids'] }}</span>
                </div>
                <div class="stat-icon accepted">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Earnings</span>
                    <span class="stat-value">${{ number_format($stats['total_earnings'], 2) }}</span>
                </div>
                <div class="stat-icon earnings">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="quick-stats">
            <div class="quick-stat-card">
                <div class="quick-stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 12h-4l-3 9-4-18-3 9H2"/>
                    </svg>
                </div>
                <div class="quick-stat-info">
                    <span class="quick-stat-value">{{ $stats['win_rate'] ?? 0 }}%</span>
                    <span class="quick-stat-label">Win Rate</span>
                </div>
            </div>
            <div class="quick-stat-card">
                <div class="quick-stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 3v18h18"/>
                        <path d="M18 17V9"/>
                        <path d="M14 17V5"/>
                        <path d="M10 17v-4"/>
                        <path d="M6 17v-8"/>
                    </svg>
                </div>
                <div class="quick-stat-info">
                    <span class="quick-stat-value">{{ $stats['active_projects'] ?? 0 }}</span>
                    <span class="quick-stat-label">Active Projects</span>
                </div>
            </div>
            <div class="quick-stat-card">
                <div class="quick-stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5.5 20c.7-2.5 3-4 6.5-4s5.8 1.5 6.5 4"/>
                    </svg>
                </div>
                <div class="quick-stat-info">
                    <span class="quick-stat-value">{{ $stats['clients_worked'] ?? 0 }}</span>
                    <span class="quick-stat-label">Clients</span>
                </div>
            </div>
            <div class="quick-stat-card">
                <div class="quick-stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                </div>
                <div class="quick-stat-info">
                    <span class="quick-stat-value">{{ $stats['avg_rating'] ?? '4.9' }}</span>
                    <span class="quick-stat-label">Rating</span>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <!-- Recent Bids Section -->
            <div class="card full-width">
                <div class="card-header">
                    <div>
                        <h3>Recent Bids</h3>
                        <p>Track your latest proposals and their status</p>
                    </div>
                    <a href="{{ route('professional.bids') }}" class="card-link">View All →</a>
                </div>
                <div class="card-body">
                    @if($bids->count() > 0)
                        <div class="bids-table-responsive">
                            <table class="bids-table">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Bid Amount</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bids->take(5) as $bid)
                                        <tr>
                                            <td class="job-cell">
                                                @if($bid->job?->exists)
                                                    <a href="{{ route('jobs.show', $bid->job) }}" class="job-link">
                                                        {{ Str::limit($bid->job->title, 35) }}
                                                    </a>
                                                    <span class="job-id">#{{ $bid->job->id }}</span>
                                                @else
                                                    <span class="job-deleted">{{ Str::limit($bid->job_title ?? 'Job deleted', 35) }}</span>
                                                @endif
                                            </td>
                                            <td class="amount-cell">
                                                <span class="bid-amount">${{ number_format($bid->bid_amount) }}</span>
                                            </td>
                                            <td class="timeline-cell">
                                                <span class="timeline-badge">{{ $bid->timeline }} days</span>
                                            </td>
                                            <td class="status-cell">
                                                @if($bid->status == 'pending')
                                                    <span class="status-badge pending">
                                                        <span class="status-dot"></span>
                                                        Pending
                                                    </span>
                                                @elseif($bid->status == 'accepted')
                                                    <span class="status-badge accepted">
                                                        <span class="status-dot"></span>
                                                        Accepted
                                                    </span>
                                                @else
                                                    <span class="status-badge rejected">
                                                        <span class="status-dot"></span>
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="actions-cell">
                                                @if($bid->status == 'pending')
                                                    <div class="action-buttons">
                                                        <a href="{{ route('professional.edit-bid', $bid->id) }}" class="action-btn edit" title="Edit Bid">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                                                <path d="M4 20h16"/>
                                                            </svg>
                                                        </a>
                                                        <button type="button" class="action-btn delete" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $bid->id }}" title="Withdraw Bid">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M3 6h18"/>
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @elseif($bid->status == 'accepted')
                                                    @if($bid->job?->exists)
                                                        <a href="{{ route('jobs.show', $bid->job) }}" class="view-job-btn">
                                                            View Job
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <line x1="5" y1="12" x2="19" y2="12"/>
                                                                <polyline points="12 5 19 12 12 19"/>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <span class="job-unavailable">Job unavailable</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Withdraw Modal -->
                                        <div class="modal fade" id="withdrawModal{{ $bid->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Withdraw Bid</h5>
                                                        <button type="button" class="modal-close" data-bs-dismiss="modal">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="modal-warning">
                                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="1.5">
                                                                <circle cx="12" cy="12" r="10"/>
                                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                                            </svg>
                                                        </div>
                                                        <p>Are you sure you want to withdraw your bid for <strong>"{{ $bid->job?->title ?? 'this job' }}"</strong>?</p>
                                                        <p class="modal-note">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('professional.withdraw-bid', $bid->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-confirm">Yes, Withdraw</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($bids->count() > 5)
                            <div class="card-footer">
                                <a href="{{ route('professional.bids') }}">View all {{ $bids->count() }} bids →</a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                                    <path d="M20 12V8H4v12h12"/>
                                    <path d="M12 2v4"/>
                                    <path d="M8 2v4"/>
                                    <path d="M16 2v4"/>
                                    <path d="M4 12h16"/>
                                </svg>
                            </div>
                            <h4>No Bids Yet</h4>
                            <p>You haven't submitted any bids. Start browsing jobs and submit your first bid!</p>
                            <a href="{{ route('jobs.index') }}" class="btn-primary">Browse Jobs</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recommended Jobs Section -->
        <div class="recommended-section">
            <div class="section-header">
                <div>
                    <h3>Recommended for You</h3>
                    <p>Jobs that match your skills and expertise</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="card-link">View All Jobs →</a>
            </div>

            @if($recommendedJobs->count() > 0)
                <div class="recommended-grid">
                    @foreach($recommendedJobs as $job)
                        <div class="recommended-card">
                            <div class="recommended-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                Featured
                            </div>
                            <h4 class="recommended-title">
                                <a href="{{ route('jobs.show', $job) }}">{{ Str::limit($job->title, 50) }}</a>
                            </h4>
                            <div class="recommended-meta">
                                <span class="meta-item">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 12V8H4v12h12"/>
                                        <path d="M12 2v4"/>
                                    </svg>
                                    ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                                </span>
                                <span class="meta-item">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $job->location ?? 'Remote' }}
                                </span>
                                <span class="meta-item">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $job->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="recommended-footer">
                                <div class="bids-count">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 12V8H4v12h12"/>
                                        <path d="M12 2v4"/>
                                    </svg>
                                    {{ $job->bids_count ?? 0 }} bids
                                </div>
                                <a href="{{ route('jobs.show', $job) }}" class="view-btn">
                                    View Details
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                        <polyline points="12 5 19 12 12 19"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state-small">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                        <path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    <p>No recommended jobs at the moment. Check back soon!</p>
                </div>
            @endif
        </div>

        <!-- Profile Completion Tip -->
        <div class="tips-card">
            <div class="tips-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4M12 8h.01"/>
                </svg>
            </div>
            <div class="tips-content">
                <h4>Complete Your Profile</h4>
                <p>Professionals with complete profiles are 3x more likely to get hired. Add your portfolio, certifications, and work experience.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="tips-btn">
                Update Profile
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════
   PROFESSIONAL DASHBOARD - AMERICAN STYLE
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

/* Typography */
h1, h2, h3, h4 {
    font-weight: 600;
    letter-spacing: -0.02em;
}

/* Welcome Section */
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

.welcome-text h1 span {
    color: #2563EB;
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

/* Buttons */
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

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
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
    font-size: 11px;
    font-weight: 600;
    margin-top: 6px;
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

.stat-icon.total { background: #EFF6FF; }
.stat-icon.total svg { stroke: #2563EB; }
.stat-icon.pending { background: #FEF3C7; }
.stat-icon.pending svg { stroke: #F59E0B; }
.stat-icon.accepted { background: #ECFDF5; }
.stat-icon.accepted svg { stroke: #10B981; }
.stat-icon.earnings { background: #F3E8FF; }
.stat-icon.earnings svg { stroke: #8B5CF6; }

/* Quick Stats */
.quick-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.quick-stat-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #E2E8F0;
    transition: all 0.2s;
}

.quick-stat-card:hover {
    border-color: #CBD5E1;
}

.quick-stat-icon {
    width: 44px;
    height: 44px;
    background: #F8FAFC;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-stat-icon svg {
    stroke: #2563EB;
}

.quick-stat-info {
    display: flex;
    flex-direction: column;
}

.quick-stat-value {
    font-size: 20px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.2;
}

.quick-stat-label {
    font-size: 11px;
    font-weight: 500;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Content Grid */
.content-grid {
    margin-bottom: 32px;
}

/* Card */
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
    align-items: center;
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

/* Bids Table */
.bids-table-responsive {
    overflow-x: auto;
}

.bids-table {
    width: 100%;
    border-collapse: collapse;
}

.bids-table thead th {
    text-align: left;
    padding: 16px 20px;
    background: #F8FAFC;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #E2E8F0;
}

.bids-table tbody tr {
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
}

.bids-table tbody tr:hover {
    background: #F8FAFC;
}

.bids-table tbody td {
    padding: 16px 20px;
    vertical-align: middle;
}

/* Job Cell */
.job-cell {
    min-width: 200px;
}

.job-link {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    text-decoration: none;
    margin-bottom: 4px;
}

.job-link:hover {
    color: #2563EB;
}

.job-id {
    font-size: 11px;
    color: #94A3B8;
}

.job-deleted {
    font-size: 14px;
    color: #94A3B8;
    font-style: italic;
}

/* Amount Cell */
.amount-cell {
    min-width: 100px;
}

.bid-amount {
    font-size: 16px;
    font-weight: 700;
    color: #0F172A;
}

/* Timeline Cell */
.timeline-cell {
    min-width: 90px;
}

.timeline-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #F1F5F9;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #475569;
}

/* Status Cell */
.status-cell {
    min-width: 100px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.pending {
    background: #FEF3C7;
    color: #D97706;
}

.status-badge.accepted {
    background: #ECFDF5;
    color: #059669;
}

.status-badge.rejected {
    background: #FEF2F2;
    color: #DC2626;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* Actions Cell */
.actions-cell {
    min-width: 100px;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
}

.action-btn.edit {
    color: #64748B;
}

.action-btn.edit:hover {
    background: #EFF6FF;
    border-color: #2563EB;
    color: #2563EB;
}

.action-btn.delete {
    color: #64748B;
}

.action-btn.delete:hover {
    background: #FEF2F2;
    border-color: #EF4444;
    color: #EF4444;
}

.view-job-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}

.view-job-btn:hover {
    background: #ECFDF5;
    border-color: #10B981;
    color: #059669;
}

.job-unavailable {
    font-size: 11px;
    color: #94A3B8;
    font-style: italic;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-dialog {
    position: relative;
    width: 400px;
    margin: 100px auto;
}

.modal-content {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
}

.modal-body {
    padding: 24px;
    text-align: center;
}

.modal-warning {
    margin-bottom: 16px;
}

.modal-body p {
    font-size: 14px;
    color: #475569;
    margin-bottom: 8px;
}

.modal-note {
    font-size: 12px;
    color: #94A3B8;
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-cancel {
    padding: 8px 16px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #F1F5F9;
}

.btn-confirm {
    padding: 8px 16px;
    background: #EF4444;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-confirm:hover {
    background: #DC2626;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 64px 24px;
}

.empty-icon {
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

/* Recommended Section */
.recommended-section {
    margin-bottom: 32px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.section-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.section-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.recommended-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.recommended-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 20px;
    transition: all 0.2s;
    position: relative;
}

.recommended-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border-color: #CBD5E1;
}

.recommended-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: #FEF3C7;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    color: #D97706;
    text-transform: uppercase;
}

.recommended-title {
    font-size: 15px;
    font-weight: 600;
    margin: 0 0 12px 0;
    padding-right: 70px;
}

.recommended-title a {
    color: #0F172A;
    text-decoration: none;
}

.recommended-title a:hover {
    color: #2563EB;
}

.recommended-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #64748B;
}

.recommended-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #F1F5F9;
}

.bids-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    color: #64748B;
}

.view-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s;
}

.view-btn:hover {
    background: #EFF6FF;
    border-color: #2563EB;
    color: #2563EB;
}

/* Empty State Small */
.empty-state-small {
    text-align: center;
    padding: 48px 24px;
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.empty-state-small svg {
    margin-bottom: 12px;
}

.empty-state-small p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

/* Tips Card */
.tips-card {
    background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
    border-radius: 12px;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.tips-icon {
    width: 48px;
    height: 48px;
    background: rgba(37,99,235,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tips-icon svg {
    stroke: #60A5FA;
}

.tips-content {
    flex: 1;
}

.tips-content h4 {
    font-size: 14px;
    font-weight: 600;
    color: white;
    margin: 0 0 4px 0;
}

.tips-content p {
    font-size: 13px;
    color: #94A3B8;
    margin: 0;
}

.tips-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #2563EB;
    color: white;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.tips-btn:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-stats {
        grid-template-columns: repeat(2, 1fr);
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
    
    .quick-stats {
        grid-template-columns: 1fr;
    }
    
    .bids-table-responsive {
        overflow-x: auto;
    }
    
    .bids-table {
        min-width: 700px;
    }
    
    .recommended-grid {
        grid-template-columns: 1fr;
    }
    
    .tips-card {
        flex-direction: column;
        text-align: center;
    }
    
    .modal-dialog {
        width: 90%;
        margin: 50px auto;
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
}
</style>
@endpush