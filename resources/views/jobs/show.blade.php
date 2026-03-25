@extends('layouts.app')

@section('title', $job->title . ' - Oweru')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <!-- Job Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="card-title h2 mb-3">{{ $job->title }}</h1>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $job->service_category ?? 'General' }}</span>
                        <span class="badge bg-secondary">{{ ucfirst($job->status) }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                        <strong>Location:</strong> {{ $job->location ?? 'Remote' }}
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-tag me-2 text-muted"></i>
                        <strong>Budget:</strong> ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-user me-2 text-muted"></i>
                        <strong>Posted by:</strong> {{ $job->client->name ?? 'Unknown' }}
                    </div>
                    
                    <div class="mb-3">
                        <i class="fas fa-calendar me-2 text-muted"></i>
                        <strong>Posted:</strong> {{ $job->created_at->format('F d, Y') }}
                    </div>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $job->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>About the Client</h5>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $job->client->profile_image ?? 'https://via.placeholder.com/50x50/0F172A/F8F8F9?text=' . substr($job->client->name ?? 'U', 0, 1) }}" 
                             alt="{{ $job->client->name ?? 'User' }}" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0">{{ $job->client->name ?? 'Unknown' }}</h6>
                            <small class="text-muted">Member since {{ $job->client->created_at->format('M Y') ?? 'Unknown' }}</small>
                        </div>
                    </div>
                    
                    @auth
                        @if(Auth::id() != $job->client_id)
                            @if(Auth::user()->user_type == 'professional')
                                @php
                                    $userBid = $job->bids->where('professional_id', Auth::id())->first();
                                @endphp
                                
                                @if(!$userBid && $job->status == 'open')
                                    <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#bidModal">
                                        <i class="fas fa-gavel me-2"></i>Submit Bid
                                    </button>
                                @elseif($userBid)
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        You have already submitted a bid for this job.
                                        <br>
                                        <small>Status: <strong>{{ ucfirst($userBid->status) }}</strong></small>
                                    </div>
                                @endif
                            @endif
                            
                            <a href="{{ route('messages.start-job', $job->id) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-envelope me-2"></i>Message Client
                            </a>
                        @endif
                        
                        @if(Auth::id() == $job->client_id)
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-secondary w-100">
                                <i class="fas fa-edit me-2"></i>Edit Job
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bid Modal -->
<div class="modal fade" id="bidModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Your Bid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bidForm" action="{{ route('bids.store', $job) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bid Amount ($)</label>
                        <input type="number" name="bid_amount" id="bid_amount" class="form-control" required min="1" step="0.01">
                        <small class="text-muted">Enter your proposed price for this job</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimated Timeline (days)</label>
                        <input type="number" name="timeline" id="timeline" class="form-control" required min="1">
                        <small class="text-muted">How many days will it take to complete?</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Proposal</label>
                        <textarea name="proposal" id="proposal" class="form-control" rows="5" required></textarea>
                        <small class="text-muted">Explain why you're the best candidate for this job</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBidBtn">
                        <i class="fas fa-paper-plane me-2"></i>Submit Bid
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bidForm = document.getElementById('bidForm');
    const submitBtn = document.getElementById('submitBidBtn');
    
    if (bidForm) {
        bidForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success message
                    showNotification('success', result.message || 'Bid submitted successfully!');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('bidModal'));
                    modal.hide();
                    
                    // Reset form
                    bidForm.reset();
                    
                    // Reload page after 2 seconds to show updated bid status
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    showNotification('error', result.error || 'Failed to submit bid. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Bid';
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Bid';
            }
        });
    }
    
    function showNotification(type, message) {
        // Create notification container if it doesn't exist
        let container = document.getElementById('notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notification-container';
            container.style.position = 'fixed';
            container.style.top = '20px';
            container.style.right = '20px';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        notification.style.minWidth = '300px';
        notification.style.marginBottom = '10px';
        notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        container.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endpush
@endsection