@extends('layouts.app')

@section('title', 'My Bids - Oweru')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 mb-2">My Bids</h1>
            <p class="text-muted">Track all your submitted bids</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#all">All Bids</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pending">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#accepted">Accepted</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach(['all', 'pending', 'accepted', 'rejected'] as $status)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $status }}">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Bid Amount</th>
                                                <th>Timeline</th>
                                                <th>Status</th>
                                                <th>Submitted</th>
                                                <th>Actions</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $filteredBids = $status == 'all' ? $bids : $bids->where('status', $status);
                                                @endphp
                                                
                                                @forelse($filteredBids as $bid)
                                                    <tr>
                                                        <td>
@if($bid->job?->exists)
                                                                <a href="{{ route('jobs.show', $bid->job) }}" class="text-decoration-none">
                                                                    {{ Str::limit($bid->job->title, 50) }}
                                                                </a>
                                                            @else
                                                                {{ Str::limit($bid->job_title ?? 'Job deleted', 50) }}
                                                            @endif
                                                        </td>
                                                        <td><strong>${{ number_format($bid->bid_amount) }}</strong></td>
                                                        <td>{{ $bid->timeline }} days</td>
                                                        <td>
                                                            @if($bid->status == 'pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif($bid->status == 'accepted')
                                                                <span class="badge bg-success">Accepted</span>
                                                            @else
                                                                <span class="badge bg-danger">Rejected</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $bid->created_at->diffForHumans() }}</td>
                                                        <td>
                                                            @if($bid->status == 'pending')
                                                                <a href="{{ route('professional.edit-bid', $bid->id) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal{{ $bid->id }}">
                                                                    <i class="fas fa-trash"></i> Withdraw
                                                                </button>
                                                            @elseif($bid->status == 'accepted')
                                                                <a href="{{ route('professional.jobs') }}" class="btn btn-sm btn-outline-success">
                                                                    <i class="fas fa-briefcase"></i> View Job
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <!-- Withdraw Modal -->
                                                    <div class="modal fade" id="withdrawModal{{ $bid->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Withdraw Bid</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to withdraw your bid for "{{ $bid->job?->title ?? 'this job' }}"?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('professional.withdraw-bid', $bid->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Withdraw</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                            <p>No {{ $status != 'all' ? $status : '' }} bids found.</p>
                                                            @if($status == 'all')
                                                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
                                                            @endif
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