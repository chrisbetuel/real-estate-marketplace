@extends('admin.layouts.app')

@section('title', 'Edit Job - Oweru Admin')
@section('page-title', 'Edit Job')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="stats-card">
            <h2>Edit Job: {{ $job->title }}</h2>
            
            <form method="POST" action="{{ route('admin.jobs.update', $job) }}">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="open" {{ old('status', $job->status) == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="assigned" {{ old('status', $job->status) == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                <option value="completed" {{ old('status', $job->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $job->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Min Budget *</label>
                            <input type="number" name="budget_min" class="form-control @error('budget_min') is-invalid @enderror" value="{{ old('budget_min', $job->budget_min) }}" min="0" step="0.01" required>
                            @error('budget_min')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Max Budget *</label>
                            <input type="number" name="budget_max" class="form-control @error('budget_max') is-invalid @enderror" value="{{ old('budget_max', $job->budget_max) }}" min="0" step="0.01" required>
                            @error('budget_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="service_category" class="form-control @error('service_category') is-invalid @enderror" value="{{ old('service_category', $job->service_category) }}">
                            @error('service_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
                                <option value="">Select Client</option>
                                @foreach(\App\Models\User::where('user_type', 'client')->get() as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', $job->client_id) == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Assigned Professional</label>
                            <select name="assigned_professional_id" class="form-select">
                                <option value="">None</option>
                                @foreach(\App\Models\User::where('user_type', 'professional')->get() as $pro)
                                    <option value="{{ $pro->id }}" {{ old('assigned_professional_id', $job->assigned_professional_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $job->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $job->location) }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Update Job
                    </button>
                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-secondary">
                        <i class="fas fa-eye me-2"></i>View Job
                    </a>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary">
                        Back to Jobs
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
