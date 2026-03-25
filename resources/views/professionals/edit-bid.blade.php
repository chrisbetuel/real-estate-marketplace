@extends('layouts.app')

@section('title', 'Edit Bid - ' . $bid->job->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit Your Bid</h4>
                    <p class="text-muted mb-0">Update your bid for "{{ $bid->job->title }}"</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('professional.update-bid', $bid->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Bid Amount ($)</label>
                            <input type="number" name="bid_amount" class="form-control @error('bid_amount') is-invalid @enderror" 
                                   value="{{ old('bid_amount', $bid->bid_amount) }}" required min="1" step="0.01">
                            @error('bid_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Estimated Timeline (days)</label>
                            <input type="number" name="timeline" class="form-control @error('timeline') is-invalid @enderror" 
                                   value="{{ old('timeline', $bid->timeline) }}" required min="1">
                            @error('timeline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Your Proposal</label>
                            <textarea name="proposal" class="form-control @error('proposal') is-invalid @enderror" 
                                      rows="6" required>{{ old('proposal', $bid->proposal) }}</textarea>
                            @error('proposal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Describe how you'll complete the job and why you're the best candidate.</small>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> You can only edit pending bids. Once accepted or rejected, bids cannot be modified.
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('professional.bids') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Bid
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Job Details Summary -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Job Details</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $bid->job->title }}</h6>
                    <p class="text-muted">{{ Str::limit($bid->job->description, 200) }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <small><strong>Budget:</strong> ${{ number_format($bid->job->budget_min) }} - ${{ number_format($bid->job->budget_max) }}</small>
                        </div>
                        <div class="col-md-6">
                            <small><strong>Location:</strong> {{ $bid->job->location ?? 'Remote' }}</small>
                        </div>
                        <div class="col-md-6">
                            <small><strong>Category:</strong> {{ $bid->job->service_category }}</small>
                        </div>
                        <div class="col-md-6">
                            <small><strong>Posted:</strong> {{ $bid->job->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <a href="{{ route('jobs.show', $bid->job) }}" class="btn btn-sm btn-outline-primary mt-3" target="_blank">
                        View Full Job Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection