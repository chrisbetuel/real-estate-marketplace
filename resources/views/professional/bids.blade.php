@extends('layouts.app')

@section('title', 'My Bids - BuildConnect')

@section('content')
<div class="bids-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>My Bids</h1>
            <p>Track all your submitted bids</p>
        </div>

        <!-- Stats Summary -->
        <div class="stats-summary">
            <div class="stat-box">
                <span class="stat-number">{{ $bids->count() ?? 0 }}</span>
                <span class="stat-label">Total Bids</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $bids->where('status', 'pending')->count() ?? 0 }}</span>
                <span class="stat-label">Pending</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $bids->where('status', 'accepted')->count() ?? 0 }}</span>
                <span class="stat-label">Accepted</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $bids->where('status', 'rejected')->count() ?? 0 }}</span>
                <span class="stat-label">Rejected</span>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bids-tabs">
            <button class="tab-btn active" data-status="all">All Bids</button>
            <button class="tab-btn" data-status="pending">Pending</button>
            <button class="tab-btn" data-status="accepted">Accepted</button>
            <button class="tab-btn" data-status="rejected">Rejected</button>
        </div>

        <!-- Bids List -->
        <div class="bids-list">
            @forelse($bids as $bid)
                <div class="bid-card" data-status="{{ $bid->status }}">
                    <div class="bid-status-indicator {{ $bid->status }}"></div>
                    <div class="bid-content">
                        <div class="bid-header">
                            <h3 class="bid-title">
                                <a href="{{ route('jobs.show', $bid->job_id) }}">
                                    {{ $bid->job ? $bid->job->title : 'Job Not Available' }}
                                </a>
                            </h3>
                            <div class="bid-amount">${{ number_format($bid->amount, 2) }}</div>
                        </div>
                        <div class="bid-meta">
                            <span class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $bid->estimated_days ?? $bid->timeline ?? 'N/A' }} days
                            </span>
                            <span class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 12V8H4v12h12"/>
                                    <path d="M12 2v4"/>
                                    <path d="M8 2v4"/>
                                    <path d="M16 2v4"/>
                                </svg>
                                Submitted {{ $bid->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="bid-proposal">
                            <p>{{ Str::limit($bid->proposal ?? 'No proposal provided', 150) }}</p>
                        </div>
                        <div class="bid-footer">
                            <div class="bid-status">
                                @if($bid->status == 'pending')
                                    <span class="status-badge pending">Pending Review</span>
                                @elseif($bid->status == 'accepted')
                                    <span class="status-badge accepted">Accepted ✓</span>
                                @else
                                    <span class="status-badge rejected">Declined ✗</span>
                                @endif
                            </div>
                            <div class="bid-actions">
                                @if($bid->status == 'pending')
                                    <button class="btn-withdraw" onclick="withdrawBid({{ $bid->id }}, '{{ addslashes($bid->job->title ?? 'this job') }}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        </svg>
                                        Withdraw
                                    </button>
                                @elseif($bid->status == 'accepted')
                                    <a href="{{ route('professional.jobs') }}" class="btn-view-job">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <rect x="2" y="7" width="20" height="14" rx="2"/>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                        </svg>
                                        View Job
                                    </a>
                                @endif
                            </div>
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
                    <h3>No bids yet</h3>
                    <p>You haven't submitted any bids yet</p>
                    <a href="{{ route('jobs.index') }}" class="btn-primary">Browse Jobs →</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Withdraw Confirmation Modal -->
<div class="modal-overlay" id="withdrawModal" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Withdraw Bid</h3>
            <button class="modal-close" onclick="closeModal()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p id="withdrawMessage">Are you sure you want to withdraw your bid?</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <form id="withdrawForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm">Yes, Withdraw</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   MY BIDS PAGE - CLEAN PROFESSIONAL DESIGN
============================================ */

.bids-page {
    background: #F5F7FA;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.page-header {
    margin-bottom: 28px;
}

.page-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 6px 0;
}

.page-header p {
    font-size: 14px;
    color: #6B7A8F;
    margin: 0;
}

/* Stats Summary */
.stats-summary {
    display: flex;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.stat-box {
    background: white;
    border-radius: 12px;
    padding: 16px 24px;
    text-align: center;
    flex: 1;
    min-width: 100px;
    border: 1px solid #E2E8F0;
}

.stat-number {
    display: block;
    font-size: 28px;
    font-weight: 700;
    color: #1A2C3E;
}

.stat-label {
    font-size: 12px;
    color: #8A99B0;
}

/* Tabs */
.bids-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 1px solid #E2E8F0;
    padding-bottom: 8px;
}

.tab-btn {
    padding: 8px 20px;
    background: transparent;
    border: none;
    font-size: 14px;
    font-weight: 500;
    color: #8A99B0;
    cursor: pointer;
    transition: all 0.2s;
    border-radius: 20px;
}

.tab-btn:hover {
    color: #C6A43B;
}

.tab-btn.active {
    background: #C6A43B;
    color: #1A2C3E;
}

/* Bids List */
.bids-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Bid Card */
.bid-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    display: flex;
    overflow: hidden;
    transition: all 0.2s;
}

.bid-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.bid-status-indicator {
    width: 4px;
    background: #8A99B0;
}

.bid-status-indicator.pending {
    background: #F59E0B;
}

.bid-status-indicator.accepted {
    background: #10B981;
}

.bid-status-indicator.rejected {
    background: #EF4444;
}

.bid-content {
    flex: 1;
    padding: 20px;
}

.bid-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 12px;
}

.bid-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.bid-title a {
    color: #1A2C3E;
    text-decoration: none;
}

.bid-title a:hover {
    color: #C6A43B;
}

.bid-amount {
    font-size: 18px;
    font-weight: 700;
    color: #C6A43B;
}

/* Bid Meta */
.bid-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 14px;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #8A99B0;
}

.meta-item svg {
    stroke: #C6A43B;
}

/* Bid Proposal */
.bid-proposal p {
    font-size: 13px;
    color: #5A6E85;
    line-height: 1.5;
    margin: 0 0 16px 0;
}

/* Bid Footer */
.bid-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
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

.bid-actions {
    display: flex;
    gap: 10px;
}

.btn-withdraw {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: transparent;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #EF4444;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-withdraw:hover {
    background: #FEF2F2;
    border-color: #EF4444;
}

.btn-view-job {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: transparent;
    border: 1px solid #C6A43B;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #C6A43B;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view-job:hover {
    background: rgba(198,164,59,0.1);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 24px;
    background: white;
    border-radius: 12px;
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

.btn-primary {
    display: inline-block;
    padding: 10px 24px;
    background: #C6A43B;
    color: #1A2C3E;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #AD8E32;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background: white;
    width: 400px;
    max-width: 90%;
    border-radius: 12px;
    overflow: hidden;
}

.modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #8A99B0;
}

.modal-body {
    padding: 20px;
}

.modal-body p {
    font-size: 14px;
    color: #1A2C3E;
    margin: 0;
}

.modal-footer {
    padding: 16px 20px;
    border-top: 1px solid #E2E8F0;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-cancel {
    padding: 8px 20px;
    background: transparent;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}

.btn-confirm {
    padding: 8px 20px;
    background: #EF4444;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}

/* Filter hide/show */
.bid-card.hide {
    display: none;
}

/* Responsive */
@media (max-width: 600px) {
    .stats-summary {
        gap: 10px;
    }
    
    .stat-box {
        padding: 12px 16px;
    }
    
    .stat-number {
        font-size: 22px;
    }
    
    .bid-header {
        flex-direction: column;
    }
    
    .bid-footer {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .bids-tabs {
        overflow-x: auto;
    }
    
    .tab-btn {
        white-space: nowrap;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Tab filtering
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const status = this.dataset.status;
        
        // Update active tab
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Filter bids
        document.querySelectorAll('.bid-card').forEach(card => {
            if (status === 'all') {
                card.classList.remove('hide');
            } else {
                const cardStatus = card.querySelector('.bid-status-indicator').classList;
                if (cardStatus.contains(status)) {
                    card.classList.remove('hide');
                } else {
                    card.classList.add('hide');
                }
            }
        });
    });
});

// Withdraw bid
let currentBidId = null;

function withdrawBid(bidId, jobTitle) {
    currentBidId = bidId;
    const modal = document.getElementById('withdrawModal');
    const message = document.getElementById('withdrawMessage');
    const form = document.getElementById('withdrawForm');
    
    message.innerHTML = `Are you sure you want to withdraw your bid for "${jobTitle}"?`;
    form.action = `/professional/bids/${bidId}/withdraw`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('withdrawModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal on outside click
document.getElementById('withdrawModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endpush
@endsection