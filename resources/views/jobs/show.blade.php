@extends('layouts.app')

@section('title', $job->title . ' - BuildConnect')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($job->title, 40) }}</li>
            </ol>
        </nav>

        <div class="content-grid">
            <!-- Main Content - Job Details -->
            <div class="main-content">
                <!-- Job Header Card -->
                <div class="job-header-card">
                    <div class="job-header-title">
                        <h1>{{ $job->title }}</h1>
                        <div class="job-badges">
                            <span class="badge-category">{{ $job->service_category ?? 'Construction' }}</span>
                            <span class="badge-status {{ $job->status }}">
                                @if($job->status == 'open')
                                    <span class="status-dot open"></span>
                                    Open for Bids
                                @elseif($job->status == 'in_progress')
                                    <span class="status-dot progress"></span>
                                    In Progress
                                @elseif($job->status == 'completed')
                                    <span class="status-dot completed"></span>
                                    Completed
                                @else
                                    {{ ucfirst($job->status) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="job-meta-grid">
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <div>
                                <span class="meta-label">Location</span>
                                <span class="meta-value">{{ $job->location ?? 'Remote' }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <line x1="12" y1="1" x2="12" y2="23"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            <div>
                                <span class="meta-label">Budget Range</span>
                                <span class="meta-value">${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <div>
                                <span class="meta-label">Posted Date</span>
                                <span class="meta-value">{{ $job->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 12V8H4v12h12"/>
                                <path d="M12 2v4"/>
                                <path d="M8 2v4"/>
                                <path d="M16 2v4"/>
                                <path d="M4 12h16"/>
                            </svg>
                            <div>
                                <span class="meta-label">Bids Received</span>
                                <span class="meta-value">{{ $job->bids_count ?? $job->bids->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Description Card -->
                <div class="description-card">
                    <h3>Job Description</h3>
                    <div class="description-content">
                        <p>{{ $job->description }}</p>
                    </div>
                    
                    @if($job->requirements)
                        <div class="requirements-section">
                            <h4>Requirements</h4>
                            <ul class="requirements-list">
                                @foreach(explode("\n", $job->requirements) as $req)
                                    @if(trim($req))
                                        <li>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            {{ trim($req) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if($job->skills && count($job->skills) > 0)
                        <div class="skills-section">
                            <h4>Required Skills</h4>
                            <div class="skills-tags">
                                @foreach($job->skills as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bids Section (for job owners) -->
                @auth
                    @if(Auth::id() == $job->client_id && $job->bids->count() > 0)
                        <div class="bids-section">
                            <div class="section-header">
                                <div>
                                    <h3>Submitted Bids</h3>
                                    <p>{{ $job->bids->count() }} professional{{ $job->bids->count() != 1 ? 's' : '' }} have submitted proposals</p>
                                </div>
                            </div>
                            <div class="bids-list">
                                @foreach($job->bids as $bid)
                                    <div class="bid-card">
                                        <div class="bidder-info">
                                            <div class="bidder-avatar">
                                                <img src="{{ $bid->professional->profile_image ?? 'https://ui-avatars.com/api/?background=2563EB&color=fff&name=' . urlencode($bid->professional->name) }}" 
                                                     alt="{{ $bid->professional->name }}">
                                            </div>
                                            <div class="bidder-details">
                                                <h4>{{ $bid->professional->name }}</h4>
                                                <div class="bidder-rating">
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i <= round($bid->professional->avg_rating ?? 0) ? '#F59E0B' : 'none' }}" stroke="#F59E0B" stroke-width="2">
                                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
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
                                                <form action="{{ route('client.bids.accept', $bid->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-accept" onclick="return confirm('Accept this bid?')">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <polyline points="20 6 9 17 4 12"/>
                                                        </svg>
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="{{ route('client.bids.reject', $bid->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-decline" onclick="return confirm('Decline this bid?')">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <line x1="18" y1="6" x2="6" y2="18"/>
                                                            <line x1="6" y1="6" x2="18" y2="18"/>
                                                        </svg>
                                                        Decline
                                                    </button>
                                                </form>
                                            @elseif($bid->status == 'accepted')
                                                <span class="bid-status accepted">Accepted</span>
                                            @else
                                                <span class="bid-status rejected">Declined</span>
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
            <div class="sidebar">
                <!-- Client Info Card -->
                <div class="client-card">
                    <h3>About the Client</h3>
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ $job->client->profile_image ?? 'https://ui-avatars.com/api/?background=0F172A&color=fff&name=' . urlencode($job->client->name ?? 'U') }}" 
                                 alt="{{ $job->client->name ?? 'Client' }}">
                        </div>
                        <div class="client-details">
                            <h4>{{ $job->client->name ?? 'Anonymous Client' }}</h4>
                            <p class="client-since">Member since {{ $job->client->created_at->format('M Y') ?? 'Unknown' }}</p>
                            @if($job->client->completed_jobs_count ?? 0 > 0)
                                <div class="client-stats">
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        {{ $job->client->completed_jobs_count }} projects completed
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @auth
                        @if(Auth::id() != $job->client_id)
                            @if(Auth::user()->user_type == 'professional')
                                @php
                                    $userBid = $job->bids->where('professional_id', Auth::id())->first();
                                @endphp
                                
                                @if(!$userBid && $job->status == 'open')
                                    <button type="button" class="btn-submit-bid w-100" data-bs-toggle="modal" data-bs-target="#bidModal">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 12V8H4v12h12"/>
                                            <path d="M12 2v4"/>
                                            <path d="M8 2v4"/>
                                            <path d="M16 2v4"/>
                                            <path d="M4 12h16"/>
                                        </svg>
                                        Submit a Bid
                                    </button>
                                @elseif($userBid)
                                    <div class="bid-status-card">
                                        <div class="bid-status-icon {{ $userBid->status }}">
                                            @if($userBid->status == 'pending')
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                            @elseif($userBid->status == 'accepted')
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                            @else
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="bid-status-content">
                                            <h4>Your Bid Status</h4>
                                            <p>You submitted a bid of <strong>${{ number_format($userBid->bid_amount) }}</strong></p>
                                            <span class="status-badge {{ $userBid->status }}">
                                                {{ ucfirst($userBid->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            
                            <a href="{{ route('messages.start-job', $job->id) }}" class="btn-message w-100">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                Message Client
                            </a>
                        @endif
                        
                        @if(Auth::id() == $job->client_id)
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn-edit-job w-100">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                    <path d="M4 20h16"/>
                                </svg>
                                Edit Job
                            </a>
                            
                            @if($job->status == 'open')
                                <button type="button" class="btn-close-job w-100" onclick="closeJob({{ $job->id }})">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                    </svg>
                                    Close Job Listing
                                </button>
                            @endif
                        @endif
                    @endauth
                    
                    @guest
                        <div class="login-prompt">
                            <p>Please <a href="{{ route('login') }}">login</a> to submit a bid or message the client.</p>
                        </div>
                    @endguest
                </div>

                <!-- Job Stats Card -->
                <div class="stats-card-sidebar">
                    <h3>Job Statistics</h3>
                    <div class="stat-item">
                        <span>Posted</span>
                        <strong>{{ $job->created_at->diffForHumans() }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Last Updated</span>
                        <strong>{{ $job->updated_at->diffForHumans() }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Total Bids</span>
                        <strong>{{ $job->bids->count() }}</strong>
                    </div>
                    @if($job->status == 'open')
                        <div class="stat-item highlight">
                            <span>Deadline for Bids</span>
                            <strong>{{ $job->bid_deadline ? $job->bid_deadline->format('M d, Y') : 'Open until filled' }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bid Modal -->
<div class="modal fade" id="bidModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Your Bid</h5>
                <button type="button" class="modal-close" data-bs-dismiss="modal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <form id="bidForm" action="{{ route('bids.store', $job) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Bid Amount ($)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">$</span>
                            <input type="number" name="bid_amount" id="bid_amount" class="form-input" required min="1" step="0.01" placeholder="Enter your proposed price">
                        </div>
                        <small class="form-hint">Suggest a competitive price between ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estimated Timeline</label>
                        <div class="input-with-icon">
                            <input type="number" name="timeline" id="timeline" class="form-input" required min="1" placeholder="Number of days">
                            <span class="input-suffix">days</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Your Proposal</label>
                        <textarea name="proposal" id="proposal" class="form-textarea" rows="5" required placeholder="Explain why you're the best candidate for this job..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit-modal" id="submitBidBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Submit Bid
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════
   JOB DETAILS PAGE - AMERICAN STYLE
   Clean | Modern | Professional | Functional
═══════════════════════════════════════════ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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

/* Breadcrumb */
.breadcrumb-nav {
    margin-bottom: 24px;
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    font-size: 13px;
    font-weight: 500;
}

.breadcrumb-item a {
    color: #2563EB;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item a:hover {
    color: #1D4ED8;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #0F172A;
    font-weight: 600;
}

.breadcrumb-item:not(:first-child)::before {
    content: "›";
    margin-right: 8px;
    color: #94A3B8;
    font-size: 16px;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 32px;
}

/* Job Header Card */
.job-header-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 24px;
    margin-bottom: 24px;
}

.job-header-title h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 12px 0;
}

.job-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}

.badge-category {
    display: inline-block;
    padding: 4px 12px;
    background: #EFF6FF;
    color: #2563EB;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-status.open {
    background: #FEF3C7;
    color: #D97706;
}

.badge-status.in_progress {
    background: #EFF6FF;
    color: #2563EB;
}

.badge-status.completed {
    background: #ECFDF5;
    color: #059669;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-dot.open { background: #D97706; }
.status-dot.progress { background: #2563EB; }
.status-dot.completed { background: #059669; }

/* Job Meta Grid */
.job-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.meta-item svg {
    stroke: #64748B;
    flex-shrink: 0;
}

.meta-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.meta-value {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
}

/* Description Card */
.description-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 24px;
    margin-bottom: 24px;
}

.description-card h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 16px 0;
}

.description-content p {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin: 0 0 20px 0;
}

/* Requirements Section */
.requirements-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #F1F5F9;
}

.requirements-section h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 12px 0;
}

.requirements-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirements-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #475569;
    margin-bottom: 10px;
}

/* Skills Section */
.skills-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #F1F5F9;
}

.skills-section h4 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 12px 0;
}

.skills-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.skill-tag {
    padding: 4px 12px;
    background: #F1F5F9;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #475569;
}

/* Bids Section */
.bids-section {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
}

.section-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
}

.section-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.section-header p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.bids-list {
    padding: 0;
}

.bid-card {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.bid-card:last-child {
    border-bottom: none;
}

.bidder-info {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 16px;
}

.bidder-avatar img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
}

.bidder-details h4 {
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 6px 0;
}

.bidder-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.stars {
    display: flex;
    gap: 2px;
}

.bid-details {
    flex: 2;
}

.bid-amount {
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 6px;
}

.bid-timeline {
    font-size: 12px;
    color: #64748B;
    margin-bottom: 8px;
}

.bid-proposal {
    font-size: 13px;
    color: #475569;
    line-height: 1.5;
}

.bid-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-accept, .btn-decline {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.btn-accept {
    background: #ECFDF5;
    color: #059669;
}

.btn-accept:hover {
    background: #059669;
    color: white;
}

.btn-decline {
    background: #FEF2F2;
    color: #DC2626;
}

.btn-decline:hover {
    background: #DC2626;
    color: white;
}

.bid-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.bid-status.accepted {
    background: #ECFDF5;
    color: #059669;
}

.bid-status.rejected {
    background: #FEF2F2;
    color: #DC2626;
}

/* Sidebar */
.sidebar {
    position: sticky;
    top: 24px;
    height: fit-content;
}

/* Client Card */
.client-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 20px;
    margin-bottom: 24px;
}

.client-card h3 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 16px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.client-info {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
}

.client-avatar img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
}

.client-details h4 {
    font-size: 15px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.client-since {
    font-size: 12px;
    color: #64748B;
    margin: 0 0 8px 0;
}

.client-stats span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 500;
    color: #10B981;
}

/* Buttons */
.btn-submit-bid {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: #2563EB;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-submit-bid:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

.btn-message {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: white;
    color: #2563EB;
    border: 1px solid #2563EB;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    margin-top: 12px;
}

.btn-message:hover {
    background: #EFF6FF;
}

.btn-edit-job, .btn-close-job {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    width: 100%;
    margin-top: 12px;
}

.btn-edit-job {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    color: #475569;
}

.btn-edit-job:hover {
    border-color: #2563EB;
    color: #2563EB;
}

.btn-close-job {
    background: #FEF2F2;
    border: 1px solid #FEE2E2;
    color: #DC2626;
}

.btn-close-job:hover {
    background: #DC2626;
    color: white;
}

/* Bid Status Card */
.bid-status-card {
    background: #F8FAFC;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    display: flex;
    gap: 12px;
}

.bid-status-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bid-status-icon.pending {
    background: #FEF3C7;
}
.bid-status-icon.pending svg { stroke: #D97706; }

.bid-status-icon.accepted {
    background: #ECFDF5;
}
.bid-status-icon.accepted svg { stroke: #059669; }

.bid-status-icon.rejected {
    background: #FEF2F2;
}
.bid-status-icon.rejected svg { stroke: #DC2626; }

.bid-status-content h4 {
    font-size: 13px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 4px 0;
}

.bid-status-content p {
    font-size: 12px;
    color: #475569;
    margin: 0 0 8px 0;
}

.status-badge {
    display: inline-block;
    padding: 2px 10px;
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

/* Stats Card Sidebar */
.stats-card-sidebar {
    background: white;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    padding: 20px;
}

.stats-card-sidebar h3 {
    font-size: 14px;
    font-weight: 600;
    color: #0F172A;
    margin: 0 0 16px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #F1F5F9;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-item span {
    font-size: 13px;
    color: #64748B;
}

.stat-item strong {
    font-size: 13px;
    font-weight: 600;
    color: #0F172A;
}

.stat-item.highlight {
    background: #EFF6FF;
    margin: 0 -20px;
    padding: 12px 20px;
    border-radius: 8px;
    margin-top: 8px;
}

.stat-item.highlight strong {
    color: #2563EB;
}

/* Login Prompt */
.login-prompt {
    text-align: center;
    padding: 16px 0 0;
    border-top: 1px solid #F1F5F9;
    margin-top: 16px;
}

.login-prompt p {
    font-size: 13px;
    color: #64748B;
    margin: 0;
}

.login-prompt a {
    color: #2563EB;
    text-decoration: none;
    font-weight: 600;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-dialog {
    width: 500px;
    max-width: 90%;
}

.modal-content {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    font-size: 16px;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #94A3B8;
    transition: color 0.2s;
}

.modal-close:hover {
    color: #EF4444;
}

.modal-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #0F172A;
    margin-bottom: 8px;
}

.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 600;
    color: #64748B;
}

.input-suffix {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #64748B;
}

.form-input {
    width: 100%;
    padding: 10px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    color: #1E293B;
    transition: all 0.2s;
}

.input-with-icon .form-input {
    padding-left: 28px;
}

.form-input:focus {
    outline: none;
    border-color: #2563EB;
    background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.form-textarea {
    width: 100%;
    padding: 10px 12px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
    color: #1E293B;
    resize: vertical;
    font-family: inherit;
}

.form-textarea:focus {
    outline: none;
    border-color: #2563EB;
    background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.form-hint {
    display: block;
    font-size: 11px;
    color: #64748B;
    margin-top: 6px;
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-cancel-modal {
    padding: 8px 20px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel-modal:hover {
    background: #F1F5F9;
}

.btn-submit-modal {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 24px;
    background: #2563EB;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit-modal:hover {
    background: #1D4ED8;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 900px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 24px 0;
    }
    
    .container {
        padding: 0 16px;
    }
    
    .job-meta-grid {
        grid-template-columns: 1fr;
    }
    
    .bid-card {
        flex-direction: column;
    }
    
    .bid-actions {
        justify-content: flex-start;
    }
}

@media (max-width: 480px) {
    .job-header-title h1 {
        font-size: 20px;
    }
    
    .client-info {
        flex-direction: column;
        text-align: center;
    }
    
    .client-avatar {
        display: flex;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bidForm = document.getElementById('bidForm');
    const submitBtn = document.getElementById('submitBidBtn');
    
    if (bidForm) {
        bidForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validateBidForm()) {
                return;
            }
            
            // Disable submit button to prevent double submission
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<div class="spinner"></div> Submitting...';
            }
            
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showNotification('success', result.message || 'Bid submitted successfully!');
                    
                    // Close modal
                    const modal = document.getElementById('bidModal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                    
                    // Reset form
                    bidForm.reset();
                    
                    // Reload page after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showNotification('error', result.error || 'Failed to submit bid. Please try again.');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Submit Bid';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'An error occurred. Please try again.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Submit Bid';
                }
            }
        });
    }
    
    function validateBidForm() {
        const bidAmount = document.getElementById('bid_amount');
        const timeline = document.getElementById('timeline');
        const proposal = document.getElementById('proposal');
        
        if (!bidAmount.value || parseFloat(bidAmount.value) <= 0) {
            showNotification('error', 'Please enter a valid bid amount.');
            bidAmount.focus();
            return false;
        }
        
        if (!timeline.value || parseInt(timeline.value) <= 0) {
            showNotification('error', 'Please enter a valid timeline.');
            timeline.focus();
            return false;
        }
        
        if (!proposal.value || proposal.value.trim().length < 20) {
            showNotification('error', 'Please provide a detailed proposal (minimum 20 characters).');
            proposal.focus();
            return false;
        }
        
        return true;
    }
    
    function showNotification(type, message) {
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
        
        const notification = document.createElement('div');
        notification.style.background = type === 'success' ? '#10B981' : '#EF4444';
        notification.style.color = 'white';
        notification.style.padding = '12px 20px';
        notification.style.borderRadius = '8px';
        notification.style.marginBottom = '10px';
        notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        notification.style.fontSize = '13px';
        notification.style.fontWeight = '500';
        notification.style.display = 'flex';
        notification.style.alignItems = 'center';
        notification.style.gap = '10px';
        notification.style.minWidth = '280px';
        notification.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                ${type === 'success' ? '<polyline points="20 6 9 17 4 12"/>' : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'}
            </svg>
            ${message}
        `;
        
        container.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
    
    // Close job function
    window.closeJob = function(jobId) {
        if (confirm('Are you sure you want to close this job listing? This will prevent new bids.')) {
            fetch(`/jobs/${jobId}/close`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      showNotification('success', 'Job closed successfully');
                      location.reload();
                  } else {
                      showNotification('error', data.error || 'Failed to close job');
                  }
              });
        }
    };
});
</script>
@endpush