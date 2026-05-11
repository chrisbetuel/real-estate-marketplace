@extends('layouts.app')

@section('title', 'Bids for ' . $job->title . ' - BuildConnect')

@section('content')
<div class="bids-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <a href="{{ route('client.jobs') }}" class="back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
                Back to jobs
            </a>
            <div class="job-badge">
                <span class="job-status {{ $job->status }}">{{ ucfirst($job->status) }}</span>
                <span class="job-budget">${{ number_format($job->budget_min) }} – ${{ number_format($job->budget_max) }}</span>
            </div>
        </div>

        <!-- Job Title -->
        <div class="job-title">
            <h1>{{ $job->title }}</h1>
            <p class="job-desc">{{ Str::limit($job->description, 150) }}</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="flash success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flash error">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="stats-bar">
            <span class="stats-total">{{ $bids->count() }} {{ Str::plural('proposal', $bids->count()) }}</span>
            <span class="stats-pending">{{ $bids->where('status', 'pending')->count() }} pending</span>
        </div>

        <!-- Bids List -->
        <div class="bids-list">
            @forelse($bids as $bid)
                <div class="bid-card {{ $bid->status }}">
                    <div class="bid-card-inner">
                        <!-- Professional Info -->
                        <div class="bid-professional">
                            <div class="professional-avatar">
                                <img src="{{ $bid->professional->profile_image ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=C6A43B&name=' . urlencode(substr($bid->professional->name ?? 'P', 0, 1)) }}" 
                                     alt="{{ $bid->professional->name ?? 'Professional' }}">
                            </div>
                            <div class="professional-details">
                                <h3>{{ $bid->professional->name ?? 'Professional' }}</h3>
                                <div class="professional-rating">
                                    <span class="star">★</span> {{ number_format($bid->professional->rating ?? 4.5, 1) }}
                                    <span class="separator">•</span>
                                    <span class="reviews">{{ $bid->professional->reviews_count ?? 0 }} reviews</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bid Amount -->
                        <div class="bid-amount">
                            ${{ number_format($bid->amount) }}
                        </div>

                        <!-- Bid Details -->
                        <div class="bid-details">
                            <div class="detail-item">
                                <span class="detail-label">Timeline</span>
                                <span class="detail-value">{{ $bid->estimated_days ?? 'N/A' }} days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Submitted</span>
                                <span class="detail-value">{{ $bid->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="detail-item full">
                                <span class="detail-label">Proposal</span>
                                <p class="detail-text">{{ $bid->proposal ?? 'No proposal provided.' }}</p>
                            </div>
                            @if($bid->cover_letter)
                                <div class="detail-item full">
                                    <span class="detail-label">Cover letter</span>
                                    <p class="detail-text cover">{{ $bid->cover_letter }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="bid-actions">
                            <div class="bid-status">
                                <span class="status {{ $bid->status }}">
                                    @if($bid->status == 'pending')
                                        ⏳ Pending
                                    @elseif($bid->status == 'accepted')
                                        ✓ Accepted
                                    @else
                                        ✗ Declined
                                    @endif
                                </span>
                            </div>

                            @if($bid->status == 'pending')
                                <div class="action-buttons">
                                    <form method="POST" action="{{ route('client.accept-bid', $bid->id) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn-accept" onclick="return confirm('Accept this proposal?')">
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('client.reject-bid', $bid->id) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn-decline" onclick="return confirm('Decline this proposal?')">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            @elseif($bid->status == 'accepted')
                                <div class="message-accepted">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 16v-4M12 8h.01"/>
                                    </svg>
                                    Proposal accepted
                                </div>
                            @else
                                <div class="message-declined">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                    </svg>
                                    Proposal declined
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1">
                        <path d="M20 12V8H4v12h12"/>
                        <path d="M12 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                        <path d="M4 12h16"/>
                    </svg>
                    <h3>No proposals yet</h3>
                    <p>Professionals will submit proposals here</p>
                    <a href="{{ route('jobs.show', $job) }}" class="empty-link">View job details →</a>
                </div>
            @endforelse
        </div>

        <!-- Back to Top -->
        @if($bids->count() > 5)
            <button class="back-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="18 15 12 9 6 15"/>
                </svg>
                Back to top
            </button>
        @endif
    </div>
</div>

@push('styles')
<style>
/* ============================================
   BIDS PAGE - CLEAN PROFESSIONAL DESIGN
   Colors: Dark #1A2C3E | Gold #C6A43B
============================================ */

.bids-page {
    background: #F5F7FA;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #6B7A8F;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s;
}

.back-link:hover {
    color: #C6A43B;
}

.job-badge {
    display: flex;
    gap: 10px;
}

.job-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.job-status.open {
    background: rgba(198,164,59,0.1);
    color: #C6A43B;
}

.job-status.in_progress {
    background: rgba(37,99,235,0.1);
    color: #2563EB;
}

.job-status.completed {
    background: rgba(16,185,129,0.1);
    color: #10B981;
}

.job-budget {
    padding: 4px 12px;
    background: #F0F2F5;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #5A6E85;
}

/* Job Title */
.job-title {
    margin-bottom: 28px;
}

.job-title h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 8px 0;
}

.job-desc {
    font-size: 14px;
    color: #6B7A8F;
    margin: 0;
    line-height: 1.5;
}

/* Flash Messages */
.flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 24px;
    font-size: 14px;
}

.flash.success {
    background: #ECFDF5;
    color: #059669;
    border: 1px solid #A7F3D0;
}

.flash.error {
    background: #FEF2F2;
    color: #DC2626;
    border: 1px solid #FECACA;
}

/* Stats Bar */
.stats-bar {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #E2E8F0;
}

.stats-total {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
}

.stats-pending {
    font-size: 12px;
    background: rgba(198,164,59,0.1);
    color: #C6A43B;
    padding: 4px 12px;
    border-radius: 20px;
}

/* Bids List */
.bids-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Bid Card */
.bid-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    transition: all 0.2s;
}

.bid-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.bid-card.accepted {
    border-left: 3px solid #10B981;
}

.bid-card.rejected {
    border-left: 3px solid #EF4444;
}

.bid-card-inner {
    padding: 20px;
}

/* Professional Info */
.bid-professional {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
}

.professional-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.professional-details h3 {
    font-size: 15px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.professional-rating {
    font-size: 12px;
    color: #6B7A8F;
    display: flex;
    align-items: center;
    gap: 6px;
}

.professional-rating .star {
    color: #C6A43B;
}

.separator {
    color: #CBD5E1;
}

/* Bid Amount */
.bid-amount {
    font-size: 22px;
    font-weight: 700;
    color: #C6A43B;
    margin-bottom: 16px;
}

/* Bid Details */
.bid-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.detail-item.full {
    grid-column: span 2;
}

.detail-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #8A99B0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-value {
    font-size: 14px;
    font-weight: 500;
    color: #1A2C3E;
}

.detail-text {
    font-size: 13px;
    color: #5A6E85;
    line-height: 1.5;
    margin: 0;
}

.detail-text.cover {
    background: #F8FAFC;
    padding: 12px;
    border-radius: 8px;
    margin-top: 4px;
}

/* Bid Actions */
.bid-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid #F0F2F5;
}

.status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status.pending {
    background: rgba(198,164,59,0.1);
    color: #C6A43B;
}

.status.accepted {
    background: rgba(16,185,129,0.1);
    color: #10B981;
}

.status.rejected {
    background: rgba(239,68,68,0.1);
    color: #EF4444;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.btn-accept, .btn-decline {
    padding: 6px 18px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.btn-accept {
    background: #C6A43B;
    color: white;
}

.btn-accept:hover {
    background: #AD8E32;
}

.btn-decline {
    background: transparent;
    border: 1px solid #E2E8F0;
    color: #8A99B0;
}

.btn-decline:hover {
    background: #FEF2F2;
    border-color: #FECACA;
    color: #EF4444;
}

.message-accepted, .message-declined {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
}

.message-accepted {
    color: #10B981;
}

.message-declined {
    color: #8A99B0;
}

.inline-form {
    display: inline;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 24px;
    background: white;
    border-radius: 14px;
    border: 1px solid #E2E8F0;
}

.empty-state svg {
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 16px;
    font-weight: 500;
    color: #1A2C3E;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 13px;
    color: #8A99B0;
    margin-bottom: 20px;
}

.empty-link {
    display: inline-block;
    color: #C6A43B;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.empty-link:hover {
    text-decoration: underline;
}

/* Back to Top */
.back-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 40px;
    font-size: 12px;
    color: #6B7A8F;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    z-index: 90;
}

.back-top:hover {
    background: #C6A43B;
    color: white;
    border-color: #C6A43B;
}

/* Responsive */
@media (max-width: 600px) {
    .bids-page {
        padding: 20px 0;
    }
    
    .job-title h1 {
        font-size: 20px;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .bid-details {
        grid-template-columns: 1fr;
    }
    
    .detail-item.full {
        grid-column: span 1;
    }
    
    .bid-actions {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons {
        width: 100%;
    }
    
    .btn-accept, .btn-decline {
        flex: 1;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide flash messages
    const flashes = document.querySelectorAll('.flash');
    flashes.forEach(flash => {
        setTimeout(() => {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 300);
        }, 4000);
    });
});
</script>
@endpush
@endsection