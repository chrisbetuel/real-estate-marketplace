@extends('layouts.app')

@section('title', 'Professional Dashboard - Oweru')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Manage your bids and track your projects</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Bids</h6>
                            <h2 class="mb-0">{{ $stats['total_bids'] }}</h2>
                        </div>
                        <i class="fas fa-gavel fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Pending Bids</h6>
                            <h2 class="mb-0">{{ $stats['pending_bids'] }}</h2>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Accepted Bids</h6>
                            <h2 class="mb-0">{{ $stats['accepted_bids'] }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Earnings</h6>
                            <h2 class="mb-0">${{ number_format($stats['total_earnings'], 2) }}</h2>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bids -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bids</h5>
                    <a href="{{ route('professional.bids') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($bids->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Bid Amount</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        @foreach($bids->take(5) as $bid)
                                            <tr>
                                                <td>
@if($bid->job?->exists)
                                                        <a href="{{ route('jobs.show', $bid->job) }}" class="text-decoration-none">
                                                            {{ Str::limit($bid->job->title, 30) }}
                                                        </a>
                                                    @else
                                                        {{ Str::limit($bid->job_title ?? 'Job deleted', 30) }}
                                                    @endif
                                                </td>
                                                <td><strong>${{ number_format($bid->bid_amount) }}</strong></td>
                                                <td>{{ $bid->timeline }} days</td>
                                                <td>
                                                    @if($bid->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($bid->status == 'accepted')
                                                        <span class="badge bg-success">Accepted</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($bid->status == 'pending')
                                                        <a href="{{ route('professional.edit-bid', $bid->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $bid->id }}">
                                                            <i class="fas fa-trash me-1"></i> Withdraw
                                                        </button>
                                                    @elseif($bid->status == 'accepted')
@if($bid->job?->exists)
                                                                <a href="{{ route('jobs.show', $bid->job) }}" class="btn btn-sm btn-outline-success">
                                                                    <i class="fas fa-eye me-1"></i>View Job
                                                                </a>
                                                            @else
                                                                <span class="badge bg-secondary">Job unavailable</span>
                                                            @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <!-- Withdraw Modal -->
                                            <div class="modal fade" id="withdrawModal{{ $bid->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Withdraw Bid</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        Are you sure you want to withdraw your bid for "{{ $bid->job?->title ?? 'this job' }}"?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('professional.withdraw-bid', $bid->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Withdraw</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                                <p>You haven't submitted any bids yet.</p>
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Recommended Jobs -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recommended Jobs</h5>
                    </div>
                    <div class="card-body">
                        @if($recommendedJobs->count() > 0)
                            @foreach($recommendedJobs as $job)
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="mb-1">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ Str::limit($job->title, 40) }}
                                        </a>
                                    </h6>
                                    <div class="small text-muted">
                                        <i class="fas fa-tag me-1"></i> ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                                        <br>
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $job->location ?? 'Remote' }}
                                    </div>
                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-outline-primary mt-2">View Details</a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center mb-0">No recommended jobs at the moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection