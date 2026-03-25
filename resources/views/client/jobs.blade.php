@extends('layouts.app')

@section('title', 'My Jobs - Oweru')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 mb-2">My Jobs</h1>
                    <p class="text-muted">All jobs you've posted</p>
                </div>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Post New Job
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#all">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#open">Open</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#in-progress">In Progress</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach(['all', 'open', 'in_progress', 'completed'] as $status)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $status == 'all' ? 'all' : $status }}">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            32
                                                <th>Job Title</th>
                                                <th>Category</th>
                                                <th>Budget</th>
                                                <th>Location</th>
                                                <th>Bids</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $filteredJobs = $status == 'all' ? $jobs : $jobs->where('status', $status);
                                                @endphp
                                                
                                                @forelse($filteredJobs as $job)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                                                {{ Str::limit($job->title, 40) }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $job->service_category }}</td>
                                                        <td>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</td>
                                                        <td>{{ $job->location ?? 'Remote' }}</td>
                                                        <td>
                                                            <span class="badge bg-info">
                                                                {{ $job->bids->count() }} bids
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($job->status == 'open')
                                                                <span class="badge bg-success">Open</span>
                                                            @elseif($job->status == 'in_progress')
                                                                <span class="badge bg-warning">In Progress</span>
                                                            @else
                                                                <span class="badge bg-secondary">Completed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($job->status == 'open')
                                                                <a href="{{ route('client.job-bids', $job->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-gavel me-1"></i>View Bids ({{ $job->bids->where('status', 'pending')->count() }})
                                                                </a>
                                                            @elseif($job->status == 'in_progress')
                                                                <form action="{{ route('client.complete-job', $job->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this job as completed?')">
                                                                        <i class="fas fa-check-circle me-1"></i>Complete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-eye me-1"></i>View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                                            <p>No jobs found.</p>
                                                            <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post a Job</a>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection