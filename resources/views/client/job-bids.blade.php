@extends('layouts.app')

@section('title', 'Bids for ' . $job->title)

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 mb-2">{{ $job->title }}</h1>
                    <p class="text-muted">Review and manage bids for this job</p>
                </div>
                <a href="{{ route('client.jobs') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Jobs
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5>Job Details</h5>
                    <hr>
                    <p><strong>Budget:</strong> ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</p>
                    <p><strong>Location:</strong> {{ $job->location ?? 'Remote' }}</p>
                    <p><strong>Category:</strong> {{ $job->service_category }}</p>
                    <p><strong>Posted:</strong> {{ $job->created_at->diffForHumans() }}</p>
                    @if($job->deadline)
                        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</p>
                    @endif
                    <div class="mt-3">
                        <span class="badge {{ $job->status == 'open' ? 'bg-success' : ($job->status == 'in_progress' ? 'bg-info' : 'bg-secondary') }} fs-6">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary w-100 mt-3">
                        View Full Job Details
                    </a>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Bids Summary</h5>
                    <hr>
                    <div class="text-center">
                        <h2 class="mb-0">{{ $bids->count() }}</h2>
                        <p class="text-muted">Total Bids Received</p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 text-center">
                            <h5 class="text-warning mb-0">{{ $bids->where('status', 'pending')->count() }}</h5>
                            <small class="text-muted">Pending</small>
                        </div>
                        <div class="col-6 text-center">
                            <h5 class="text-success mb-0">{{ $bids->where('status', 'accepted')->count() }}</h5>
                            <small class="text-muted">Accepted</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Bids ({{ $bids->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($bids->count() > 0)
                        @foreach($bids as $bid)
                            <div class="card mb-3 {{ $bid->status == 'accepted' ? 'border-success' : ($bid->status == 'rejected' ? 'border-danger' : 'border-warning') }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-3">
                                                @if($bid->professional)
                                                    <img src="{{ $bid->professional->profile_image ?? 'https://via.placeholder.com/50x50/0F172A/F8F8F9?text=' . substr($bid->professional->name, 0, 1) }}" 
                                                         alt="{{ $bid->professional->name }}" 
                                                         class="rounded-circle me-3" width="50" height="50">
                                                    <div>
                                                        <h6 class="mb-0">{{ $bid->professional->name }}</h6>
                                                        <small class="text-muted">Member since {{ $bid->professional->created_at->format('M Y') }}</small>
                                                        <br>
<small class="text-muted">
                                                            <i class="fas fa-envelope me-1"></i> {{ $hasPaidConnection ? $bid->professional->email : $bid->professional->masked_email ?? '***@***' }}
                                                        </small>
                                                        @if($bid->escrowHold)
                                                            <br><small class="text-info">
                                                                <i class="fas fa-lock me-1"></i> Escrow: {{ ucfirst($bid->escrowHold->status) }} ${{ number_format($bid->escrowHold->amount) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="rounded-circle bg-secondary me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Professional (ID: {{ $bid->professional_id }})</h6>
                                                        <small class="text-muted">User account may be deleted</small>
                                                    </div>
                                                @endif
                                            </div>
                                            <p><strong>Bid Amount:</strong> 
                                                <span class="text-success fs-5">${{ number_format($bid->amount) }}</span>
                                            </p>
                                            <p><strong>Timeline:</strong> {{ $bid->estimated_days }} days</p>
                                            <p><strong>Proposal:</strong></p>
                                            <p class="text-muted">{{ $bid->proposal }}</p>
                                            <p class="text-muted small">
                                                <i class="fas fa-clock me-1"></i> Submitted: {{ $bid->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            @if($bid->status == 'pending')
                                                <div class="d-grid gap-2">
                                                    <form action="{{ route('client.accept-bid', $bid->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Accept this bid? This will assign the job to this professional.')">
                                                            <i class="fas fa-check-circle me-2"></i>Accept Bid
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('client.reject-bid', $bid->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Reject this bid?')">
                                                            <i class="fas fa-times-circle me-2"></i>Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($bid->status == 'accepted')
                                                <div class="alert alert-success mb-0">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    <strong>Accepted</strong><br>
                                                    <small>This professional has been assigned to this job.</small>
                                                </div>
                                                <a href="{{ route('messages.start-job', $job->id) }}" class="btn btn-outline-primary w-100 mt-2">
                                                    <i class="fas fa-envelope me-2"></i>Message Professional
                                                </a>
                                            @else
                                                <div class="alert alert-secondary mb-0">
                                                    <i class="fas fa-times-circle me-2"></i>
                                                    <strong>Rejected</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-gavel fa-3x text-muted mb-3"></i>
                            <h5>No bids yet</h5>
                            <p class="text-muted">Professionals haven't submitted any bids for this job yet.</p>
                            <p class="text-muted">Share this job to attract more professionals.</p>
                            <button class="btn btn-outline-primary" onclick="navigator.clipboard.writeText(window.location.href)">
                                <i class="fas fa-share me-2"></i>Copy Job Link
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection