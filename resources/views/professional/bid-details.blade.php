@extends('layouts.app')

@section('title', 'Bid Details - ' . $bid->job->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Bid Details</h4>
                        <a href="{{ route('professional.bids') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Bids
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Job Information</h5>
                            <h3 class="mb-3">{{ $bid->job->title }}</h3>
                            <p class="text-muted">{{ $bid->job->description }}</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <strong>Budget Range:</strong>
                                    <p>${{ number_format($bid->job->budget_min) }} - ${{ number_format($bid->job->budget_max) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Location:</strong>
                                    <p>{{ $bid->job->location ?? 'Remote' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Category:</strong>
                                    <p>{{ $bid->job->service_category }}</p>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <h5>Your Bid</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Bid Amount:</strong>
                                    <p class="text-success fs-4">${{ number_format($bid->bid_amount) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Timeline:</strong>
                                    <p>{{ $bid->timeline }} days</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Status:</strong>
                                    <p>
                                        @if($bid->status == 'pending')
                                            <span class="badge bg-warning">Pending Review</span>
                                        @elseif($bid->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <strong>Proposal:</strong>
                            <p class="mt-2">{{ $bid->proposal }}</p>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>Client Information</h5>
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $bid->job->client->profile_image ?? 'https://via.placeholder.com/50x50/0F172A/F8F8F9?text=' . substr($bid->job->client->name, 0, 1) }}" 
                                             alt="{{ $bid->job->client->name }}" 
                                             class="rounded-circle me-3" width="50" height="50">
                                        <div>
                                            <h6 class="mb-0">{{ $bid->job->client->name }}</h6>
                                            <small class="text-muted">Member since {{ $bid->job->client->created_at->format('M Y') }}</small>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('messages.start-job', $bid->job->id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-envelope me-2"></i>Message Client
                                        </a>
                                        <a href="{{ route('jobs.show', $bid->job) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-eye me-2"></i>View Full Job
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection