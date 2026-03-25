@extends('admin.layouts.app')

@section('title', 'Jobs Management - Oweru Admin')
@section('page-title', 'Jobs Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="stats-card">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                        <tr>
                            <td>#{{ $listing->id }}</td>
                            <td>
                                <strong>{{ Str::limit($listing->title, 40) }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $listing->user->profile_image ?? 'https://via.placeholder.com/30x30/0F172A/F8F8F9?text=' . substr($listing->user->name, 0, 1) }}" 
                                         alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px; object-fit: cover;">
                                    <div>
                                        <strong>{{ Str::limit($listing->user->name, 15) }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($listing->budget_min && $listing->budget_max)
                                    <strong>${{ number_format($listing->budget_min) }} - ${{ number_format($listing->budget_max) }}</strong>
                                @else
                                    <span class="text-muted">Negotiable</span>
                                @endif
                            </td>
                            <td>
                                @if($listing->status == 'open')
                                    <span class="badge bg-success">Open</span>
                                @elseif($listing->status == 'in_progress')
                                    <span class="badge bg-warning">In Progress</span>
                                @elseif($listing->status == 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @else
                                    <span class="badge bg-secondary">Cancelled</span>
                                @endif
                            </td>
                            <td>{{ $listing->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.jobs.show', $listing) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $listing) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.jobs.destroy', $listing) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                <p>No jobs found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $listings->links() ?? '' }}
            </div>
        </div>
    </div>
</div>
@endsection