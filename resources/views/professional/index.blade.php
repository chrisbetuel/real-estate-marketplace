@extends('layouts.app')

@section('title', 'Professionals')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Professionals</h4>
                    <a href="{{ route('professionals.create') }}" class="btn btn-primary">
                        Add New Professional
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Search professionals..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Services</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($professionals as $professional)
                                    <tr>
                                        <td>
                                            <a href="{{ route('professionals.show', $professional) }}">
                                                {{ $professional->name }}
                                            </a>
                                        </td>
                                        <td>{{ $professional->email }}</td>
                                        <td>{{ $professional->professionalProfile?->phone ?? 'N/A' }}</td>
                                    <td>
                                            @if($professional->professionalProfile)
                                                {{ $professional->professionalProfile->profession ?? 'N/A' }}
                                            @endif
                                            <br><small class="text-muted">{{ $professional->professionalProfile->years_experience ?? 'N/A' }} years exp.</small>
                                        </td>
                                        <td>{{ number_format($professional->rating, 1) }} ({{ $professional->reviews_count }})
                                        </td>
                                        <td>
                                            @if($professional->is_verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('professionals.show', $professional) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No professionals found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $professionals->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
