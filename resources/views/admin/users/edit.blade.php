@extends('admin.layouts.app')

@section('title', 'Edit User - Oweru Admin')
@section('page-title', 'Edit User: ' . $user->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">User Type <span class="text-danger">*</span></label>
                        <select name="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                            <option value="user" {{ old('user_type', $user->user_type) == 'user' ? 'selected' : '' }}>Regular User</option>
                            <option value="professional" {{ old('user_type', $user->user_type) == 'professional' ? 'selected' : '' }}>Professional</option>
                            <option value="store_owner" {{ old('user_type', $user->user_type) == 'store_owner' ? 'selected' : '' }}>Store Owner</option>
                            <option value="agent" {{ old('user_type', $user->user_type) == 'agent' ? 'selected' : '' }}>Agent</option>
                        </select>
                        @error('user_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_verified" class="form-check-input" value="1" {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
                            <label class="form-check-label">Verified User</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label">Active User</label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <hr>
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">
                            <i class="fas fa-eye me-2"></i>View
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection