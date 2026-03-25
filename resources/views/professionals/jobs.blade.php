@extends('layouts.app')

@section('title', 'My Jobs - Oweru')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 mb-2">My Jobs</h1>
            <p class="text-muted">Jobs that have been assigned to you</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#in-progress">In Progress</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="in-progress">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Job Title</th>
                                            <th>Client</th>
                                            <th>Budget</th>
                                            <th>Location</th>
                                            <th>Assigned</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @forelse($jobs->where('status', 'in_progress') as $job)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                                            {{ Str::limit($job->title, 40) }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $job->client->name }}</td>
                                                    <td>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</td>
                                                    <td>{{ $job->location ?? 'Remote' }}</td>
                                                    <td>{{ $job->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        <form action="{{ route('professional.update-job-status', $job->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this job as completed?')">
                                                                <i class="fas fa-check-circle me-1"></i>Complete
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i>View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                                        <p>No jobs in progress.</p>
                                                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="completed">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            32
                                                <th>Job Title</th>
                                                <th>Client</th>
                                                <th>Budget</th>
                                                <th>Completed</th>
                                                <th>Actions</th>
                                            </thead>
                                            <tbody>
                                                @forelse($jobs->where('status', 'completed') as $job)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                                                {{ Str::limit($job->title, 40) }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $job->client->name }}</td>
                                                        <td>${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</td>
                                                        <td>{{ $job->updated_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye me-1"></i>View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                                            <p>No completed jobs yet.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection