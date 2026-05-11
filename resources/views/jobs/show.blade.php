@extends('layouts.app')

@section('title', $job->title . ' - BuildConnect')

@section('content')
<div class="job-details-page">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('jobs.index') }}">Jobs</a>
            <span>/</span>
            <span class="current">{{ Str::limit($job->title, 40) }}</span>
        </div>

        <div class="details-layout">
            <!-- Main Content -->
            <div class="details-main">
                <!-- Job Header -->
                <div class="job-header">
                    <h1 class="job-title">{{ $job->title }}</h1>
                    <div class="job-tags">
                        <span class="tag-category">{{ $job->service_category ?? 'Construction' }}</span>
                        <span class="tag-status {{ $job->status }}">
                            @if($job->status == 'open')
                                ● Open for bids
                            @elseif($job->status == 'in_progress')
                                ● In progress
                            @elseif($job->status == 'completed')
                                ● Completed
                            @else
                                {{ ucfirst($job->status) }}
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Job Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <div>
                            <span class="info-label">Location</span>
                            <span class="info-value">{{ $job->location ?? 'Remote' }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        <div>
                            <span class="info-label">Budget</span>
                            <span class="info-value">${{ number_format($job->budget_min) }} – ${{ number_format($job->budget_max) }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <div>
                            <span class="info-label">Posted</span>
                            <span class="info-value">{{ $job->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20 12V8H4v12h12"/>
                            <path d="M12 2v4"/>
                            <path d="M8 2v4"/>
                            <path d="M16 2v4"/>
                            <path d="M4 12h16"/>
                        </svg>
                        <div>
                            <span class="info-label">Bids</span>
                            <span class="info-value">{{ $job->bids_count ?? $job->bids->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="section-card">
                    <h3>Description</h3>
                    <div class="section-content">
                        <p>{{ $job->description }}</p>
                    </div>
                </div>

                @if($job->requirements)
                    <div class="section-card">
                        <h3>Requirements</h3>
                        <div class="section-content">
                            <ul class="requirements-list">
                                @foreach(explode("\n", $job->requirements) as $req)
                                    @if(trim($req))
                                        <li>{{ trim($req) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if($job->skills && count($job->skills) > 0)
                    <div class="section-card">
                        <h3>Skills required</h3>
                        <div class="section-content">
                            <div class="skills-list">
                                @foreach($job->skills as $skill)
                                    <span class="skill-badge">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Bids Section (for job owner) -->
                @auth
                    @if(Auth::id() == $job->client_id && $job->bids->count() > 0)
                        <div class="section-card">
                            <h3>Proposals ({{ $job->bids->count() }})</h3>
                            <div class="bids-container">
                                @foreach($job->bids as $bid)
                                    <div class="bid-card">
                                        <div class="bid-professional">
                                            <div class="prof-avatar">
                                                <img src="{{ $bid->professional->profile_image ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=C6A43B&name=' . urlencode($bid->professional->name) }}" alt="{{ $bid->professional->name }}">
                                            </div>
                                            <div class="prof-info">
                                                <h4>{{ $bid->professional->name }}</h4>
                                                <div class="prof-rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i <= round($bid->professional->avg_rating ?? 0) ? '#C6A43B' : 'none' }}" stroke="#C6A43B">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                        </svg>
                                                    @endfor
                                                    <span>({{ $bid->professional->reviews_count ?? 0 }} reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bid-details">
                                            <div class="bid-amount">${{ number_format($bid->bid_amount) }}</div>
                                            <div class="bid-timeline">{{ $bid->timeline }} days</div>
                                            <div class="bid-proposal">{{ Str::limit($bid->proposal, 100) }}</div>
                                        </div>
                                        <div class="bid-actions">
                                            @if($bid->status == 'pending')
                                                <form action="{{ route('client.bids.accept', $bid->id) }}" method="POST" class="inline-form">
                                                    @csrf
                                                    <button type="submit" class="btn-accept" onclick="return confirm('Accept this proposal?')">Accept</button>
                                                </form>
                                                <form action="{{ route('client.bids.reject', $bid->id) }}" method="POST" class="inline-form">
                                                    @csrf
                                                    <button type="submit" class="btn-decline" onclick="return confirm('Decline this proposal?')">Decline</button>
                                                </form>
                                            @elseif($bid->status == 'accepted')
                                                <span class="status-accepted">✓ Accepted</span>
                                            @else
                                                <span class="status-declined">✗ Declined</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Sidebar -->
            <div class="details-sidebar">
                <!-- Client Card -->
                <div class="sidebar-card">
                    <h3>Client</h3>
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ $job->client->profile_image ?? 'https://ui-avatars.com/api/?background=1A2C3E&color=C6A43B&name=' . urlencode(substr($job->client->name ?? 'C', 0, 1)) }}" alt="Client">
                        </div>
                        <div class="client-details">
                            <h4>{{ $job->client->name ?? 'Anonymous Client' }}</h4>
                            <p>Member since {{ $job->client->created_at->format('M Y') ?? 'Unknown' }}</p>
                        </div>
                    </div>
                    
                    @auth
                        @if(Auth::id() != $job->client_id)
                            @if(Auth::user()->user_type == 'professional')
                                @php $userBid = $job->bids->where('professional_id', Auth::id())->first(); @endphp
                                
                                @if(!$userBid && $job->status == 'open')
                                    <button class="btn-bid" onclick="openBidModal()">Submit proposal</button>
                                @elseif($userBid)
                                    <div class="bid-info-card">
                                        <div class="bid-info-header {{ $userBid->status }}">
                                            @if($userBid->status == 'pending')
                                                Proposal pending
                                            @elseif($userBid->status == 'accepted')
                                                Proposal accepted
                                            @else
                                                Proposal declined
                                            @endif
                                        </div>
                                        <div class="bid-info-amount">${{ number_format($userBid->bid_amount) }}</div>
                                        <div class="bid-info-timeline">{{ $userBid->timeline }} days</div>
                                    </div>
                                @endif
                            @endif
                            
                            <a href="{{ route('messages.start-job', $job->id) }}" class="btn-message">Message client</a>
                        @endif
                        
                        @if(Auth::id() == $job->client_id)
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn-edit">Edit job</a>
                            @if($job->status == 'open')
                                <button class="btn-close" onclick="closeJob({{ $job->id }})">Close listing</button>
                            @endif
                        @endif
                    @endauth
                    
                    @guest
                        <div class="guest-prompt">
                            <a href="{{ route('login') }}">Sign in</a> to submit a proposal
                        </div>
                    @endguest
                </div>

                <!-- Stats Card -->
                <div class="sidebar-card">
                    <h3>Details</h3>
                    <div class="stats-list">
                        <div class="stats-row">
                            <span>Posted</span>
                            <strong>{{ $job->created_at->diffForHumans() }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Last active</span>
                            <strong>{{ $job->updated_at->diffForHumans() }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Total proposals</span>
                            <strong>{{ $job->bids->count() }}</strong>
                        </div>
                        @if($job->status == 'open')
                            <div class="stats-row highlight">
                                <span>Deadline</span>
                                <strong>{{ $job->bid_deadline ? $job->bid_deadline->format('M d, Y') : 'Open until filled' }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bid Modal -->
<div id="bidModal" class="bid-modal">
    <div class="bid-modal-overlay"></div>
    <div class="bid-modal-container">
        <div class="bid-modal-header">
            <h3>Submit proposal</h3>
            <button class="bid-modal-close" onclick="closeBidModal()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form id="bidForm" action="{{ route('bids.store', $job) }}" method="POST">
            @csrf
            <div class="bid-modal-body">
                <div class="field">
                    <label>Your price ($)</label>
                    <input type="number" name="bid_amount" id="bid_amount" class="field-input" placeholder="e.g., 1500" required min="1">
                    <small class="field-hint">Suggested range: ${{ number_format($job->budget_min) }} – ${{ number_format($job->budget_max) }}</small>
                </div>
                <div class="field">
                    <label>Timeline (days)</label>
                    <input type="number" name="timeline" id="timeline" class="field-input" placeholder="e.g., 14" required min="1">
                </div>
                <div class="field">
                    <label>Proposal</label>
                    <textarea name="proposal" id="proposal" class="field-textarea" rows="5" placeholder="Explain why you're the right person for this job..." required></textarea>
                </div>
            </div>
            <div class="bid-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeBidModal()">Cancel</button>
                <button type="submit" class="btn-submit" id="submitBidBtn">Submit proposal</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   JOB DETAILS - CLEAN PROFESSIONAL DESIGN
============================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.job-details-page {
    background: #F4F6F9;
    min-height: calc(100vh - 64px);
    padding: 32px 0;
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Breadcrumb */
.breadcrumb-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
    font-size: 13px;
}

.breadcrumb-wrapper a {
    color: #6B7A8F;
    text-decoration: none;
}

.breadcrumb-wrapper a:hover {
    color: #C6A43B;
}

.breadcrumb-wrapper span {
    color: #9CA3AF;
}

.breadcrumb-wrapper .current {
    color: #1A2C3E;
    font-weight: 500;
}

/* Layout */
.details-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 28px;
}

/* Job Header */
.job-header {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid #E2E8F0;
}

.job-title {
    font-size: 24px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 12px 0;
}

.job-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag-category {
    padding: 4px 10px;
    background: #F0F2F5;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #5A6E85;
}

.tag-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.tag-status.open {
    background: rgba(198,164,59,0.1);
    color: #C6A43B;
}

.tag-status.in_progress {
    background: rgba(37,99,235,0.1);
    color: #2563EB;
}

.tag-status.completed {
    background: rgba(16,185,129,0.1);
    color: #10B981;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.info-item {
    background: white;
    border-radius: 10px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #E2E8F0;
}

.info-item svg {
    stroke: #C6A43B;
    flex-shrink: 0;
}

.info-label {
    display: block;
    font-size: 11px;
    color: #8A99B0;
    margin-bottom: 2px;
}

.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
}

/* Section Cards */
.section-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid #E2E8F0;
}

.section-card h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 16px 0;
}

.section-content p {
    font-size: 14px;
    color: #5A6E85;
    line-height: 1.6;
    margin: 0;
}

.requirements-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirements-list li {
    padding: 6px 0;
    font-size: 14px;
    color: #5A6E85;
    border-bottom: 1px solid #F0F2F5;
}

.requirements-list li:last-child {
    border-bottom: none;
}

.skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.skill-badge {
    padding: 4px 12px;
    background: #F0F2F5;
    border-radius: 20px;
    font-size: 12px;
    color: #5A6E85;
}

/* Bids Section */
.bids-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.bid-card {
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.bid-professional {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 180px;
}

.prof-avatar img {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
}

.prof-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 4px 0;
}

.prof-rating {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #8A99B0;
}

.bid-details {
    flex: 1;
}

.bid-amount {
    font-size: 18px;
    font-weight: 700;
    color: #C6A43B;
    margin-bottom: 4px;
}

.bid-timeline {
    font-size: 12px;
    color: #8A99B0;
    margin-bottom: 6px;
}

.bid-proposal {
    font-size: 13px;
    color: #5A6E85;
    line-height: 1.5;
}

.bid-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-accept, .btn-decline {
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.btn-accept {
    background: #ECFDF5;
    color: #10B981;
}

.btn-accept:hover {
    background: #10B981;
    color: white;
}

.btn-decline {
    background: #FEF2F2;
    color: #EF4444;
}

.btn-decline:hover {
    background: #EF4444;
    color: white;
}

.status-accepted {
    font-size: 12px;
    font-weight: 500;
    color: #10B981;
    background: #ECFDF5;
    padding: 6px 14px;
    border-radius: 6px;
}

.status-declined {
    font-size: 12px;
    font-weight: 500;
    color: #EF4444;
    background: #FEF2F2;
    padding: 6px 14px;
    border-radius: 6px;
}

/* Sidebar */
.details-sidebar {
    position: sticky;
    top: 24px;
    height: fit-content;
}

.sidebar-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #E2E8F0;
}

.sidebar-card h3 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 16px 0;
}

/* Client Info */
.client-info {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
}

.client-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.client-details h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0 0 2px 0;
}

.client-details p {
    font-size: 11px;
    color: #8A99B0;
    margin: 0;
}

/* Buttons */
.btn-bid, .btn-message, .btn-edit, .btn-close {
    display: block;
    width: 100%;
    padding: 12px;
    text-align: center;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    margin-bottom: 10px;
}

.btn-bid {
    background: #C6A43B;
    color: white;
    border: none;
}

.btn-bid:hover {
    background: #AD8E32;
}

.btn-message {
    background: transparent;
    border: 1px solid #C6A43B;
    color: #C6A43B;
}

.btn-message:hover {
    background: #FDF8ED;
}

.btn-edit {
    background: #F0F2F5;
    border: none;
    color: #5A6E85;
}

.btn-edit:hover {
    background: #E2E8F0;
}

.btn-close {
    background: #FEF2F2;
    border: none;
    color: #EF4444;
}

.btn-close:hover {
    background: #FEE2E2;
}

/* Bid Info Card */
.bid-info-card {
    background: #F8FAFC;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 16px;
    text-align: center;
}

.bid-info-header {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 8px;
}

.bid-info-header.pending { color: #C6A43B; }
.bid-info-header.accepted { color: #10B981; }
.bid-info-header.rejected { color: #EF4444; }

.bid-info-amount {
    font-size: 18px;
    font-weight: 700;
    color: #1A2C3E;
    margin-bottom: 4px;
}

.bid-info-timeline {
    font-size: 12px;
    color: #8A99B0;
}

/* Stats List */
.stats-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    padding: 8px 0;
    border-bottom: 1px solid #F0F2F5;
}

.stats-row:last-child {
    border-bottom: none;
}

.stats-row span {
    color: #8A99B0;
}

.stats-row strong {
    color: #1A2C3E;
    font-weight: 600;
}

.stats-row.highlight {
    background: #FDF8ED;
    margin: -8px -20px;
    padding: 12px 20px;
    border-radius: 8px;
}

.stats-row.highlight strong {
    color: #C6A43B;
}

.guest-prompt {
    text-align: center;
    padding-top: 12px;
    border-top: 1px solid #F0F2F5;
    font-size: 13px;
    color: #8A99B0;
}

.guest-prompt a {
    color: #C6A43B;
    text-decoration: none;
    font-weight: 500;
}

/* Custom Modal - No Bootstrap dependency */
.bid-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2000;
}

.bid-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.bid-modal-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    width: 480px;
    max-width: 90%;
    border-radius: 12px;
    overflow: hidden;
    z-index: 2001;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.bid-modal-header {
    padding: 20px;
    border-bottom: 1px solid #E2E8F0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bid-modal-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1A2C3E;
    margin: 0;
}

.bid-modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #8A99B0;
}

.bid-modal-close:hover {
    color: #EF4444;
}

.bid-modal-body {
    padding: 20px;
}

.field {
    margin-bottom: 20px;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #1A2C3E;
    margin-bottom: 6px;
}

.field-input, .field-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    transition: all 0.2s;
    background: white;
    color: #1A2C3E;
}

.field-input:focus, .field-textarea:focus {
    outline: none;
    border-color: #C6A43B;
    box-shadow: 0 0 0 2px rgba(198,164,59,0.1);
}

.field-textarea {
    resize: vertical;
    min-height: 100px;
}

.field-hint {
    display: block;
    font-size: 11px;
    color: #8A99B0;
    margin-top: 6px;
}

.bid-modal-footer {
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
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    color: #5A6E85;
}

.btn-cancel:hover {
    background: #F0F2F5;
}

.btn-submit {
    padding: 8px 24px;
    background: #C6A43B;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: white;
    cursor: pointer;
}

.btn-submit:hover {
    background: #AD8E32;
}

.btn-submit:disabled {
    background: #A0AEC0;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 900px) {
    .details-layout {
        grid-template-columns: 1fr;
    }
    
    .details-sidebar {
        position: static;
    }
    
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .bid-card {
        flex-direction: column;
    }
    
    .bid-actions {
        justify-content: flex-start;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Modal functions
function openBidModal() {
    document.getElementById('bidModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeBidModal() {
    document.getElementById('bidModal').style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('bidModal');
    const overlay = document.querySelector('.bid-modal-overlay');
    
    if (overlay) {
        overlay.addEventListener('click', closeBidModal);
    }
    
    // Form submission
    const bidForm = document.getElementById('bidForm');
    const submitBtn = document.getElementById('submitBidBtn');
    
    if (bidForm) {
        bidForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const bidAmount = document.getElementById('bid_amount');
            const timeline = document.getElementById('timeline');
            const proposal = document.getElementById('proposal');
            
            if (!bidAmount.value || parseFloat(bidAmount.value) <= 0) {
                alert('Please enter a valid amount');
                bidAmount.focus();
                return;
            }
            
            if (!timeline.value || parseInt(timeline.value) <= 0) {
                alert('Please enter a valid timeline');
                timeline.focus();
                return;
            }
            
            if (!proposal.value || proposal.value.trim().length < 20) {
                alert('Please provide a detailed proposal (minimum 20 characters)');
                proposal.focus();
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        bid_amount: bidAmount.value,
                        timeline: timeline.value,
                        proposal: proposal.value
                    })
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    alert('Proposal submitted successfully!');
                    closeBidModal();
                    location.reload();
                } else {
                    alert(result.error || 'Failed to submit proposal');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit proposal';
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit proposal';
            }
        });
    }
});

window.closeJob = function(jobId) {
    if (confirm('Close this job listing? No new proposals will be accepted.')) {
        fetch(`/jobs/${jobId}/close`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              } else {
                  alert('Failed to close job');
              }
          });
    }
};
</script>
@endpush
@endsection