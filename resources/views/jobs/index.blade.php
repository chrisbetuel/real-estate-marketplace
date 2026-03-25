@extends('layouts.app')

@section('title', 'Browse Jobs - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-dark);">Browse <span style="color: var(--gold-accent);">Jobs</span></h1>
            <p class="lead" style="color: var(--primary-dark); opacity: 0.8;">Find the perfect opportunity for your skills</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-4">
                    <form action="{{ route('jobs.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Search Keywords</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Job title or keywords..." value="{{ request('keyword') }}" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Category</label>
                            <select name="category" class="form-select" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                <option value="">All Categories</option>
                                <option value="Engineer" {{ request('category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="Architect" {{ request('category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                <option value="Designer" {{ request('category') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                <option value="Electrician" {{ request('category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                <option value="Plumber" {{ request('category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                <option value="Carpenter" {{ request('category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="City or region..." value="{{ request('location') }}" style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn w-100" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 12px; font-weight: 600;">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="row">
        @forelse($jobs as $job)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px; overflow: hidden;">
                <div class="card-body p-4">
                    <!-- Job Category Badge -->
                    <span class="badge mb-3" style="background: rgba(201, 165, 59, 0.1); color: var(--gold-accent); padding: 8px 15px; border-radius: 50px; font-weight: 600;">
                        {{ $job->service_category }}
                    </span>
                    
                    <!-- Job Title -->
                    <h3 class="h5 fw-bold mb-2" style="color: var(--primary-dark);">{{ $job->title }}</h3>
                    
                    <!-- Client Name -->
                    <p class="small mb-3" style="color: var(--primary-dark); opacity: 0.7;">
                        <i class="fas fa-user me-2" style="color: var(--gold-accent);"></i>{{ $job->client->name }}
                    </p>
                    
                    <!-- Location -->
                    <p class="small mb-3" style="color: var(--primary-dark); opacity: 0.7;">
                        <i class="fas fa-map-marker-alt me-2" style="color: var(--gold-accent);"></i>{{ $job->location }}
                    </p>
                    
                    <!-- Description -->
                    <p class="small mb-3" style="color: var(--primary-dark); opacity: 0.6;">{{ Str::limit($job->description, 100) }}</p>
                    
                    <!-- Budget -->
                    <div class="mb-3">
                        <span class="fw-bold" style="color: var(--gold-accent); font-size: 1.1rem;">
                            ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                        </span>
                    </div>
                    
                    <!-- Deadline -->
                    <p class="small mb-3" style="color: var(--primary-dark); opacity: 0.6;">
                        <i class="far fa-calendar-alt me-2" style="color: var(--gold-accent);"></i>Deadline: {{ $job->deadline->format('M d, Y') }}
                    </p>
                    
                    <!-- Skills -->
                    @if($job->required_skills)
                    <div class="mb-3">
                        @foreach($job->required_skills as $skill)
                        <span class="badge me-1 mb-1" style="background: var(--primary-dark); color: var(--soft-white); padding: 5px 10px; border-radius: 50px; font-size: 0.75rem;">{{ $skill }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- View Details Button -->
                    <a href="{{ route('jobs.show', $job) }}" class="btn w-100 mt-2" style="background: var(--primary-dark); color: var(--soft-white); border-radius: 15px; padding: 10px; font-weight: 600;">
                        View Details <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="card-footer bg-transparent border-0 p-3 pt-0">
                    <small class="text-muted"><i class="far fa-clock me-1"></i>Posted {{ $job->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-4x mb-3" style="color: var(--gold-accent); opacity: 0.5;"></i>
                <h3 style="color: var(--primary-dark);">No Jobs Found</h3>
                <p style="color: var(--primary-dark); opacity: 0.7;">Try adjusting your search filters or check back later.</p>
                @auth
                    @if(Auth::user()->user_type == 'client')
                    <a href="{{ route('jobs.create') }}" class="btn btn-lg mt-3" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 50px; padding: 12px 40px; font-weight: 600;">
                        Post a Job <i class="fas fa-plus-circle ms-2"></i>
                    </a>
                    @endif
                @endauth
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection