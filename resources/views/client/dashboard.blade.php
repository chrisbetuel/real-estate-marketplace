@extends('layouts.app')

@section('title', 'Client Dashboard - BuildConnect')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-card">
        <div class="welcome-content">
                    <div>
                        <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="welcome-subtitle">Here's what's happening with your jobs</p>
                    </div>
                    <a href="{{ route('jobs.create') }}" class="btn-post-job">
                        <i class="fas fa-plus-circle me-2"></i>Post a New Job
                    </a>
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-light btn-sm ms-2" title="Messages">
                        <i class="fas fa-sms me-1"></i>Chats {{ ($unreadCount ?? 0) > 0 ? '(' . $unreadCount . ')' : '' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="quick-stat">
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['total_jobs'] }}</div>
                    <div class="stat-label">Total Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="quick-stat">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['open_jobs'] }}</div>
                    <div class="stat-label">Open Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="quick-stat">
                <div class="stat-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['total_bids_received'] }}</div>
                    <div class="stat-label">Bids Received</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="quick-stat">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['completed_jobs'] }}</div>
                    <div class="stat-label">Completed Jobs</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Main Content - Recent Bids -->
        <div class="col-lg-7 mb-4">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h3 class="section-title">Recent Bids</h3>
                        <p class="section-subtitle">Professionals interested in your jobs</p>
                    </div>
                    <a href="{{ route('client.jobs') }}" class="view-all-link">View All Jobs <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                
                <div class="section-content">
                    @if($recentBids->count() > 0)
                        @foreach($recentBids as $bid)
                            <div class="bid-item">
                                <div class="bid-header">
                                    <div class="professional-avatar">
                                        <img src="{{ $bid->professional->profile_image_url }}" alt="{{ $bid->professional->name }}">
                                    </div>
                                    <div class="bid-info">
                                        <div class="professional-name">{{ $bid->professional->name }}</div>
                                        <div class="job-name">
                                            <a href="{{ route('jobs.show', $bid->job) }}">{{ Str::limit($bid->job->title, 50) }}</a>
                                        </div>
                                    </div>
                                    <div class="bid-status">
                                        @if($bid->status == 'pending')
                                            <span class="status-badge status-pending">Pending Review</span>
                                        @elseif($bid->status == 'accepted')
                                            <span class="status-badge status-accepted">Accepted ✓</span>
                                        @else
                                            <span class="status-badge status-rejected">Rejected ✗</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="bid-details">
                                    <div class="bid-detail">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span class="detail-label">Bid Amount:</span>
                                        <strong class="bid-amount">${{ number_format($bid->amount) }}</strong>
                                    </div>
                                    <div class="bid-detail">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span class="detail-label">Timeline:</span>
                                        <span>{{ $bid->estimated_days }} days</span>
                                    </div>
                                    <div class="bid-detail">
                                        <i class="fas fa-file-alt"></i>
                                        <span class="detail-label">Proposal:</span>
                                        <span class="proposal-text">{{ Str::limit($bid->proposal, 80) }}</span>
                                    </div>
                                </div>
                                
                                @if($bid->status == 'pending')
                                    <div class="bid-actions">
                                        <a href="{{ route('client.job-bids', $bid->job->id) }}" class="btn-review-bid">
                                            <i class="fas fa-eye me-2"></i>Review Bid
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="empty-section">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h4>No bids yet</h4>
                            <p>When professionals submit bids, they'll appear here</p>
                            <a href="{{ route('jobs.create') }}" class="btn-primary">Post a Job to Get Started</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar - Active Jobs -->
        <div class="col-lg-5 mb-4">
            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h3 class="section-title">Your Active Jobs</h3>
                        <p class="section-subtitle">Jobs waiting for your action</p>
                    </div>
                </div>
                
                <div class="section-content">
                    @php
                        $activeJobs = $jobs->whereIn('status', ['open', 'in_progress']);
                    @endphp
                    
                    @if($activeJobs->count() > 0)
                        @foreach($activeJobs as $job)
                            <div class="job-item">
                                <div class="job-header">
                                    <h4 class="job-title">
                                        <a href="{{ route('jobs.show', $job) }}">{{ Str::limit($job->title, 45) }}</a>
                                    </h4>
                                    <div class="job-status">
                                        @if($job->status == 'open')
                                            <span class="status-badge status-open">Open for Bids</span>
                                        @else
                                            <span class="status-badge status-progress">In Progress</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="job-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $job->location ?? 'Remote' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                
                                @if($job->status == 'open')
                                    <div class="job-actions">
                                        <a href="{{ route('client.job-bids', $job->id) }}" class="btn-view-bids">
                                            <i class="fas fa-gavel me-2"></i>View Bids 
                                            @if($job->bids_count > 0)
                                                <span class="bid-badge">{{ $job->bids_count }}</span>
                                            @endif
                                        </a>
                                    </div>
                                @elseif($job->status == 'in_progress')
                                    <div class="job-actions">
                                        <form action="{{ route('client.complete-job', $job->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-complete-job" onclick="return confirm('Mark this job as completed?')">
                                                <i class="fas fa-check-circle me-2"></i>Mark as Completed
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        @if($activeJobs->count() > 3)
                            <div class="view-all-footer">
                                <a href="{{ route('client.jobs') }}" class="view-all-jobs">View All {{ $activeJobs->count() }} Jobs →</a>
                            </div>
                        @endif
                    @else
                        <div class="empty-section-small">
                            <i class="fas fa-briefcase"></i>
                            <p>No active jobs</p>
                            <a href="{{ route('jobs.create') }}" class="btn-primary-small">Post Your First Job</a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Tip Card -->
            <div class="tip-card mt-4">
                <div class="tip-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="tip-content">
                    <h5>Need Help?</h5>
                    <p>Post a detailed job description to attract the best professionals. Include budget, timeline, and specific requirements.</p>
                    <a href="{{ route('jobs.create') }}" class="tip-link">Post a Job →</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .quick-stat-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--white);
        border-radius: 16px;
        border: 1px solid var(--gray-200);
        color: var(--gray-700);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    .quick-stat-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -6px rgba(0,0,0,0.08);
        border-color: var(--brand-gold);
        color: var(--brand-gold);
    }
    .quick-stat-link i {
        font-size: 1.5rem;
        color: var(--brand-gold);
    }
    
    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, var(--brand-dark) 0%, #1e293b 100%);
        border-radius: 24px;
        padding: 2rem;
        color: black;
    }
    
    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: black;
    }
    
    .welcome-subtitle {
        color: rgba(10, 1, 1, 0.8);
        margin-bottom: 0;
    }
    
    .btn-post-job {
        display: inline-flex;
        align-items: center;
        padding: 12px 28px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-post-job:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
        color: var(--brand-dark);
    }
    
    /* Quick Stats */
    .quick-stat {
        background: var(--white);
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid var(--gray-200);
        transition: all 0.2s;
    }
    
    .quick-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -6px rgba(0,0,0,0.08);
        border-color: var(--brand-gold);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-icon i {
        font-size: 1.5rem;
        color: var(--brand-gold);
    }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--brand-dark);
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    /* Section Cards */
    .section-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        overflow: hidden;
        height: 100%;
    }
    
    .section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--brand-dark);
        margin-bottom: 0.25rem;
    }
    
    .section-subtitle {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-bottom: 0;
    }
    
    .view-all-link {
        color: var(--brand-gold);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .view-all-link:hover {
        color: var(--brand-gold-dark);
        transform: translateX(3px);
    }
    
    .section-content {
        padding: 0;
    }
    
    /* Bid Items */
    .bid-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        transition: background 0.2s;
    }
    
    .bid-item:hover {
        background: var(--gray-50);
    }
    
    .bid-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .professional-avatar {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
    }
    
    .professional-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--brand-gold);
    }
    
    .bid-info {
        flex: 1;
    }
    
    .professional-name {
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0.25rem;
    }
    
    .job-name a {
        font-size: 0.85rem;
        color: var(--gray-600);
        text-decoration: none;
    }
    
    .job-name a:hover {
        color: var(--brand-gold);
    }
    
    .bid-status {
        flex-shrink: 0;
    }
    
    .bid-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: 12px;
    }
    
    .bid-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
    }
    
    .bid-detail i {
        color: var(--brand-gold);
        width: 16px;
    }
    
    .detail-label {
        color: var(--gray-600);
    }
    
    .bid-amount {
        color: var(--brand-gold);
        font-size: 1rem;
    }
    
    .proposal-text {
        color: var(--gray-600);
    }
    
    .bid-actions {
        margin-top: 0.75rem;
    }
    
    .btn-review-bid {
        display: inline-flex;
        align-items: center;
        padding: 8px 20px;
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-review-bid:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    /* Job Items */
    .job-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .job-item:last-child {
        border-bottom: none;
    }
    
    .job-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
    }
    
    .job-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .job-title a {
        color: var(--brand-dark);
        text-decoration: none;
    }
    
    .job-title a:hover {
        color: var(--brand-gold);
    }
    
    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--gray-600);
    }
    
    .meta-item i {
        color: var(--brand-gold);
        width: 14px;
    }
    
    .job-actions {
        margin-top: 0.75rem;
    }
    
    .btn-view-bids {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background: transparent;
        border: 1px solid var(--brand-gold);
        color: var(--brand-gold);
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-view-bids:hover {
        background: var(--brand-gold);
        color: var(--brand-dark);
    }
    
    .bid-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 6px;
    }
    
    .btn-complete-job {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background: var(--success);
        border: none;
        color: white;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-complete-job:hover {
        background: #047857;
        transform: translateY(-1px);
    }
    
    .view-all-footer {
        padding: 1rem 1.5rem;
        text-align: center;
        border-top: 1px solid var(--gray-200);
    }
    
    .view-all-jobs {
        color: var(--brand-gold);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .view-all-jobs:hover {
        color: var(--brand-gold-dark);
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .status-pending {
        background: #FFFBEB;
        color: #D97706;
    }
    
    .status-accepted {
        background: #ECFDF5;
        color: #059669;
    }
    
    .status-rejected {
        background: #FEF2F2;
        color: #DC2626;
    }
    
    .status-open {
        background: rgba(201, 165, 59, 0.1);
        color: var(--brand-gold);
    }
    
    .status-progress {
        background: #EFF6FF;
        color: #2563EB;
    }
    
    /* Empty States */
    .empty-section {
        text-align: center;
        padding: 3rem 2rem;
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
    
    .empty-section h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--brand-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-section p {
        color: var(--gray-500);
        margin-bottom: 1.5rem;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        padding: 10px 24px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background: var(--brand-gold-dark);
        transform: translateY(-2px);
    }
    
    .empty-section-small {
        text-align: center;
        padding: 2rem;
    }
    
    .empty-section-small i {
        font-size: 2.5rem;
        color: var(--gray-400);
        margin-bottom: 1rem;
    }
    
    .empty-section-small p {
        font-size: 0.9rem;
        color: var(--gray-500);
        margin-bottom: 1rem;
    }
    
    .btn-primary-small {
        display: inline-block;
        padding: 6px 16px;
        background: var(--brand-gold);
        color: var(--brand-dark);
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary-small:hover {
        background: var(--brand-gold-dark);
    }
    
    /* Tip Card */
    .tip-card {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .tip-icon {
        width: 40px;
        height: 40px;
        background: rgba(0,0,0,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .tip-icon i {
        font-size: 1.2rem;
        color: var(--brand-dark);
    }
    
    .tip-content {
        flex: 1;
    }
    
    .tip-content h5 {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--brand-dark);
        margin-bottom: 0.25rem;
    }
    
    .tip-content p {
        font-size: 0.8rem;
        color: var(--brand-dark);
        opacity: 0.8;
        margin-bottom: 0.5rem;
    }
    
    .tip-link {
        font-size: 0.8rem;
        color: var(--brand-dark);
        font-weight: 600;
        text-decoration: none;
    }
    
    .tip-link:hover {
        text-decoration: underline;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .bid-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .bid-details {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .job-header {
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection