@extends('layouts.app')

@section('title', 'Review Bids - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Page Header -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Review Bids</h1>
                <p>Manage all proposals from professionals on your jobs.</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('client.dashboard') }}" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>
                <a href="{{ route('jobs.create') }}" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Post a Job
                </a>
            </div>
        </div>

        <!-- Stats Row -->
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
                    <span class="stat-label">Pending Review</span>
                    <span class="stat-value">{{ $stats['pending_bids'] }}</span>
                </div>
                <div class="stat-icon open">
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
                <div class="stat-icon bids">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Declined</span>
                    <span class="stat-value">{{ $stats['rejected_bids'] }}</span>
                </div>
                <div class="stat-icon completed">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bids List -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>All Bids</h3>
                    <p>Proposals across all your job postings</p>
                </div>
            </div>
            <div class="card-body">
                @if($bids->count() > 0)
                    <div class="bids-list">
                        @foreach($bids as $bid)
                            <div class="bid-item">
                                <div class="bid-avatar">
                                    <img src="{{ $bid->professional->profile_image_url ?? 'https://ui-avatars.com/api/?background=2563EB&color=fff&name=' . urlencode($bid->professional->name) }}" alt="{{ $bid->professional->name }}">
                                    @if($bid->professional->is_verified ?? false)
                                        <span class="verified-badge">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                <div class="bid-details">
                                    <div class="bid-row-top">
                                        <h4>{{ $bid->professional->name }}</h4>
                                        <span class="bid-amount">${{ number_format($bid->amount) }}</span>
                                    </div>
                                    <div class="bid-job">
                                        <a href="{{ route('jobs.show', $bid->job) }}">{{ Str::limit($bid->job->title, 70) }}</a>
                                    </div>
                                    <div class="bid-footer">
                                        <span class="bid-time">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            {{ $bid->estimated_days }} days
                                        </span>
                                        <span class="bid-proposal">{{ Str::limit($bid->proposal, 80) }}</span>
                                        <span class="bid-posted">{{ $bid->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="bid-actions">
                                    <span class="status-badge {{ $bid->status }}">
                                        @if($bid->status == 'pending') Pending
                                        @elseif($bid->status == 'accepted') Accepted
                                        @else Declined
                                        @endif
                                    </span>
                                    @if($bid->status == 'pending')
                                        <div class="action-buttons">
                                            <button class="accept-btn" onclick="acceptBid({{ $bid->id }})">Accept</button>
                                            <button class="decline-btn" onclick="declineBid({{ $bid->id }})">Decline</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper">
                        {{ $bids->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1">
                            <path d="M20 12V8H4v12h12"/>
                            <path d="M12 2v4"/>
                            <path d="M8 2v4"/>
                            <path d="M16 2v4"/>
                            <path d="M4 12h16"/>
                        </svg>
                        <h4>No bids yet</h4>
                        <p>When professionals submit bids, they'll appear here</p>
                        <a href="{{ route('jobs.create') }}" class="btn-outline">Post a Job</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ═══════════════════════════════════════════
   REVIEW BIDS PAGE - AMERICAN STYLE
═══════════════════════════════════════════ */

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

h1, h2, h3, h4 {
    font-weight: 600;
    letter-spacing: -0.02em;
}

/* ═══════════════════════════════════════════
   WELCOME SECTION
═══════════════════════════════════════════ */
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

.welcome-text p {
    font-size: 15px;
    color: #475569;
    margin: 0;
}

.welcome-actions {
    display: flex;
    gap: 12px;
}

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
    cursor: pointer;
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

.btn-outline {
    display: inline-block;
    padding: 10px 20px;
    background: transparent;
    color: #2563EB;
    border: 1px solid #2563EB;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-outline:hover {
    background: #2563EB;
    color: white;
}

/* ═══════════════════════════════════════════
   STATS CARDS
═══════════════════════════════════════════ */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
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

.stat-icon.open { background: #FEF3C7; }
.stat-icon.open svg { stroke: #D97706; }

.stat-icon.bids { background: #ECFDF5; }
.stat-icon.bids svg { stroke: #10B981; }

.stat-icon.completed { background: #FEF2F2; }
.stat-icon.completed svg { stroke: #DC2626; }

/* ═══════════════════════════════════════════
   CARD
═══════════════════════════════════════════ */
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
    align-items: flex-start;
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

/* ═══════════════════════════════════════════
   BIDS LIST
═══════════════════════════════════════════ */
.bids-list {
    display: flex;
    flex-direction: column;
}

.bid-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    transition: background 0.2s;
}

.bid-item:hover {
    background: #F8FAFC;
}

.bid-avatar {
    position: relative;
    flex-shrink: 0;
}

.bid-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.verified-badge {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    background: #2563EB;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

.verified-badge svg {
    stroke: white;
}

.bid-details {
    flex: 1;
}

.bid-row-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 4px;
}

.bid-row-top h4 {
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.bid-amount {
    font-size: 16px;
    font-weight: 700;
    color: #0F172A;
}

.bid-job {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 8px;
}

.bid-job a {
    color: #2563EB;
    text-decoration: none;
    font-weight: 500;
}

.bid-job a:hover {
    text-decoration: underline;
}

.bid-footer {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.bid-time, .bid-posted {
    font-size: 12px;
    color: #94A3B8;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.bid-proposal {
    font-size: 12px;
    color: #475569;
}

.bid-actions {
    text-align: right;
    flex-shrink: 0;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}

.status-badge.pending {
    background: #FEF3C7;
    color: #D97706;
}

.status-badge.accepted {
    background: #ECFDF5;
    color: #059669;
}

.status-badge.declined, .status-badge.rejected {
    background: #FEF2F2;
    color: #DC2626;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.accept-btn, .decline-btn {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.accept-btn {
    background: #10B981;
    color: white;
}

.accept-btn:hover {
    background: #059669;
}

.decline-btn {
    background: #F1F5F9;
    color: #64748B;
}

.decline-btn:hover {
    background: #E2E8F0;
    color: #DC2626;
}

/* ═══════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════ */
.pagination-wrapper {
    padding: 16px 24px;
    border-top: 1px solid #F1F5F9;
}

.pagination-wrapper nav {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-wrapper .pagination li a,
.pagination-wrapper .pagination li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    background: white;
    border: 1px solid #E2E8F0;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-wrapper .pagination li.active span {
    background: #2563EB;
    color: white;
    border-color: #2563EB;
}

.pagination-wrapper .pagination li a:hover {
    background: #F8FAFC;
    border-color: #CBD5E1;
}

.pagination-wrapper .pagination li.disabled span {
    color: #CBD5E1;
    cursor: not-allowed;
}

/* ═══════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════ */
.empty-state {
    text-align: center;
    padding: 48px 24px;
}

.empty-state svg {
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

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .stats-row {
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

    .bid-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .bid-actions {
        text-align: left;
        width: 100%;
    }

    .action-buttons {
        width: 100%;
    }

    .accept-btn, .decline-btn {
        flex: 1;
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

@push('scripts')
<script>
function acceptBid(bidId) {
    if (confirm('Accept this bid?')) {
        fetch(`/client/bids/${bidId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}

function declineBid(bidId) {
    if (confirm('Decline this bid?')) {
        fetch(`/client/bids/${bidId}/decline`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}
</script>
@endpush
@endsection

