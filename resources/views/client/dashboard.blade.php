@extends('layouts.app')

@section('title', 'Client Dashboard - Oweru')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-semibold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Manage your jobs and review bids from professionals</p>
        </div>
    </div>

    <!-- Statistics Cards - Oweru Style -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_jobs'] }}</div>
                        <div class="stat-label">Total Jobs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['open_jobs'] }}</div>
                        <div class="stat-label">Open Jobs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_bids_received'] }}</div>
                        <div class="stat-label">Total Bids Received</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['completed_jobs'] }}</div>
                        <div class="stat-label">Completed Jobs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bids Section -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bids Received</h5>
                    <a href="{{ route('client.jobs') }}" class="btn btn-sm btn-outline-custom">View All Jobs</a>
                </div>
                <div class="card-body">
                    @if($recentBids->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    32
                                        <th>Job Title</th>
                                        <th>Professional</th>
                                        <th>Bid Amount</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBids as $bid)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('jobs.show', $bid->job) }}" class="text-decoration-none fw-medium">
                                                        {{ Str::limit($bid->job->title, 30) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $bid->professional->profile_image_url }}" 
                                                             alt="{{ $bid->professional->name }}" 
                                                             class="rounded-circle me-2" 
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                        <span>{{ $bid->professional->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold text-oweru-gold">${{ number_format($bid->amount) }}</td>
                                                <td>{{ $bid->estimated_days }} days</td>
                                                <td>
                                                    @if($bid->status == 'pending')
                                                        <span class="badge badge-pending">Pending</span>
                                                    @elseif($bid->status == 'accepted')
                                                        <span class="badge badge-accepted">Accepted</span>
                                                    @else
                                                        <span class="badge badge-rejected">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($bid->status == 'pending')
                                                        <a href="{{ route('client.job-bids', $bid->job->id) }}" class="btn btn-sm btn-outline-custom">
                                                            Review
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-3">No bids received yet.</p>
                                <a href="{{ route('jobs.create') }}" class="btn btn-primary-custom">Post a Job</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Active Jobs Section -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Active Jobs</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $activeJobs = $jobs->whereIn('status', ['open', 'in_progress']);
                        @endphp
                        
                        @if($activeJobs->count() > 0)
                            @foreach($activeJobs->take(5) as $job)
                                <div class="active-job-item">
                                    <h6 class="mb-1">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ Str::limit($job->title, 35) }}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @if($job->status == 'open')
                                            <span class="badge badge-open">Open</span>
                                        @else
                                            <span class="badge badge-progress">In Progress</span>
                                        @endif
                                        <span class="text-muted small">${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</span>
                                    </div>
                                    @if($job->status == 'open')
                                        <a href="{{ route('client.job-bids', $job->id) }}" class="btn btn-sm btn-outline-custom w-100">
                                            View Bids 
                                            @if($job->bids_count > 0)
                                                <span class="badge badge-count">{{ $job->bids_count }}</span>
                                            @endif
                                        </a>
                                    @elseif($job->status == 'in_progress')
                                        <form action="{{ route('client.complete-job', $job->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success w-100" onclick="return confirm('Mark this job as completed?')">
                                                <i class="fas fa-check me-1"></i>Mark Completed
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                            
                            @if($activeJobs->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route('client.jobs') }}" class="btn btn-outline-custom btn-sm">View All Jobs</a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-briefcase fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-3">No active jobs.</p>
                                <a href="{{ route('jobs.create') }}" class="btn btn-primary-custom">Post a Job</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Stats Cards */
    .stat-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -6px rgba(0,0,0,0.08);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--oweru-gold);
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--gray-600);
        font-weight: 500;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        background: rgba(201, 165, 59, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--oweru-gold);
        font-size: 1.2rem;
    }
    
    /* Card */
    .card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        overflow: hidden;
    }
    
    .card-header {
        background: var(--white);
        border-bottom: 1px solid var(--gray-200);
        padding: 1rem 1.25rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    /* Buttons */
    .btn-outline-custom {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        padding: 6px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--oweru-gold);
        color: var(--oweru-gold);
        background: transparent;
    }
    
    .btn-primary-custom {
        background: var(--oweru-gold);
        border: none;
        color: var(--oweru-dark);
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: var(--oweru-gold-dark);
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: var(--success);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    /* Badges */
    .badge {
        padding: 4px 10px;
        font-weight: 500;
        font-size: 0.7rem;
        border-radius: 20px;
    }
    
    .badge-pending {
        background: #FFFBEB;
        color: #D97706;
    }
    
    .badge-accepted {
        background: #ECFDF5;
        color: #059669;
    }
    
    .badge-rejected {
        background: #FEF2F2;
        color: #DC2626;
    }
    
    .badge-open {
        background: rgba(201, 165, 59, 0.1);
        color: var(--oweru-gold);
    }
    
    .badge-progress {
        background: #EFF6FF;
        color: #2563EB;
    }
    
    .badge-count {
        background: var(--oweru-gold);
        color: var(--oweru-dark);
        padding: 2px 6px;
        margin-left: 6px;
    }
    
    /* Table */
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--gray-600);
        border-bottom: 1px solid var(--gray-200);
        padding: 1rem;
        background: var(--white);
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-700);
    }
    
    .table tr:hover td {
        background: var(--gray-50);
    }
    
    /* Active Job Items */
    .active-job-item {
        padding: 1rem 0;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .active-job-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .active-job-item:first-child {
        padding-top: 0;
    }
    
    .text-oweru-gold {
        color: var(--oweru-gold);
    }
</style>
@endpush