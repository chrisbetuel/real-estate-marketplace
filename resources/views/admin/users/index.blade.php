@extends('admin.layouts.app')

@section('title', 'Users Management - Oweru Admin')
@section('page-title', 'Users Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="stats-card">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="professional" {{ request('type') == 'professional' ? 'selected' : '' }}>Professional</option>
                        <option value="store_owner" {{ request('type') == 'store_owner' ? 'selected' : '' }}>Store Owner</option>
                        <option value="agent" {{ request('type') == 'agent' ? 'selected' : '' }}>Agent</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="verified" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Verified</option>
                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Add User
                    </a>
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
                            <th>User</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->profileImageUrl }}" 
                                         alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; object-fit: cover;">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <div><small class="text-muted">ID: {{ $user->id }}</small></div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge-gold">{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}</span>
                            </td>
                            <td>
                                @if($user->is_verified)
                                    <span class="badge bg-success mb-1">Verified</span>
                                @else
                                    <span class="badge bg-warning mb-1">Unverified</span>
                                @endif
                                <br>
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$user->is_verified)
                                    <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Verify">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}" 
                                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p>No users found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection