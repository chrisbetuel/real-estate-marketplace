@extends('admin.layouts.app')

@section('title', 'User Details - Oweru Admin')
@section('page-title', 'User Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="mb-4">
                <img src="{{ $user->profileImageUrl }}" 
                     alt="{{ $user->name }}" 
                     style="width: 150px; height: 150px; border-radius: 50%; border: 4px solid var(--gold-accent); object-fit: cover;">
            </div>
            
            <h4 class="mb-2">{{ $user->name }}</h4>
            <p class="text-muted mb-3">
                <span class="badge-gold">{{ ucfirst($user->user_type) }}</span>
            </p>
            
            <div class="mb-3">
                @if($user->is_verified)
                    <span class="badge bg-success px-3 py-2">Verified</span>
                @else
                    <span class="badge bg-warning px-3 py-2">Not Verified</span>
                @endif
                
                @if($user->is_active)
                    <span class="badge bg-success px-3 py-2">Active</span>
                @else
                    <span class="badge bg-danger px-3 py-2">Inactive</span>
                @endif
            </div>
            
            <hr>
            
            <div class="text-start mt-3">
                <p><i class="fas fa-envelope me-2" style="color: var(--gold-accent);"></i> {{ $user->email }}</p>
                <p><i class="fas fa-phone me-2" style="color: var(--gold-accent);"></i> {{ $user->phone ?? 'Not provided' }}</p>
                <p><i class="fas fa-map-marker-alt me-2" style="color: var(--gold-accent);"></i> {{ $user->address ?? 'Not provided' }}</p>
@if($user->user_type === 'professional' && isset($user->professionalProfile))
                    <hr class="my-3">
                    <h6 class="mb-3"><i class="fas fa-user-tie me-2" style="color: var(--gold-accent);"></i>Professional Details</h6>
                    <p><i class="fas fa-briefcase me-2" style="color: var(--gold-accent);"></i><strong>{{ $user->professionalProfile->profession ?? 'N/A' }}</strong></p>
                    <p><i class="fas fa-graduation-cap me-2" style="color: var(--gold-accent);"></i>{{ $user->professionalProfile->years_experience ?? 'N/A' }} years experience</p>
                    <p><i class="fas fa-align-left me-2" style="color: var(--gold-accent);"></i>{{ Str::limit($user->professionalProfile->bio ?? 'No bio', 150) }}</p>
                    @if($user->professionalProfile->qualifications)
                        <p><i class="fas fa-certificate me-2" style="color: var(--gold-accent);"></i>Qualifications: {{ implode(', ', $user->professionalProfile->qualifications) }}</p>
                    @endif
                    @if($user->professionalProfile->languages)
                        <p><i class="fas fa-globe me-2" style="color: var(--gold-accent);"></i>Languages: {{ implode(', ', $user->professionalProfile->languages) }}</p>
                    @endif
                    <p><i class="fas fa-dollar-sign me-2" style="color: var(--gold-accent);"></i>Rate: ${{ number_format($user->professionalProfile->hourly_rate ?? 0, 2) }}/hr</p>
                    <div class="mt-2">
                        Availability: 
                        @if($user->professionalProfile->availability)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-warning">Busy</span>
                        @endif
                    </div>
                @endif
                <p><i class="fas fa-clock me-2" style="color: var(--gold-accent);"></i> Joined: {{ $user->created_at->format('M d, Y') }}</p>
                <p><i class="fas fa-history me-2" style="color: var(--gold-accent);"></i> Last Updated: {{ $user->updated_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- User Statistics -->
        <div class="row">

            
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <div class="stats-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stats-number">{{ $user->jobs_count ?? 0 }}</div>
                    <div class="stats-label">Jobs Posted</div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <div class="stats-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stats-number">{{ $user->conversations_count ?? 0 }}</div>
                    <div class="stats-label">Conversations</div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="stats-card mt-4">
            <h5 class="mb-4">Recent Activity</h5>
            
            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="properties-tab" data-bs-toggle="tab" data-bs-target="#properties" type="button" role="tab">
                        Properties
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab">
                        Jobs
                    </button>
                </li>
            </ul>
            
            <div class="tab-content mt-4" id="userTabsContent">
                <!-- Properties Tab -->
                <div class="tab-pane fade show active" id="properties" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->properties ?? [] as $property)
                                <tr>
                                    <td>{{ Str::limit($property->title, 30) }}</td>
                                    <td>${{ number_format($property->price) }}</td>
                                    <td>{{ $property->city }}</td>
                                    <td>
                                        <span class="badge-gold">{{ ucfirst($property->status) }}</span>
                                    </td>
                                    <td>{{ $property->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No properties found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Jobs Tab -->
                <div class="tab-pane fade" id="jobs" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Budget</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->jobs ?? [] as $job)
                                <tr>
                                    <td>{{ Str::limit($job->title, 30) }}</td>
                                    <td>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</td>
                                    <td>{{ $job->category }}</td>
                                    <td>
                                        <span class="badge-gold">{{ ucfirst($job->status) }}</span>
                                    </td>
                                    <td>{{ $job->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-info" title="View Job">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No jobs found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="stats-card mt-4">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-gold">
                    <i class="fas fa-edit me-2"></i>Edit User
                </a>
                
                @if(!$user->is_verified)
                <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Verify User
                    </button>
                </form>
                @endif
                
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }} me-2"></i>
                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </form>
                
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection