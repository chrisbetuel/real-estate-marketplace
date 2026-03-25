@extends('layouts.app')

@section('title', 'Post a Job - Oweru Real Estate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="background: var(--soft-white); border: none; border-radius: 20px;">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">Post a <span style="color: var(--gold-accent);">New Job</span></h1>
                        <p class="text-muted">Fill in the details below to find the perfect professional for your project</p>
                    </div>
                    
                    <!-- Form -->
                    <form action="{{ route('jobs.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold" style="color: var(--primary-dark);">Job Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="e.g., Need Architect for Home Renovation"
                                   style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-4">
                            <label for="service_category" class="form-label fw-semibold" style="color: var(--primary-dark);">Service Category</label>
                            <select class="form-select @error('service_category') is-invalid @enderror" 
                                    id="service_category" name="service_category"
                                    style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                <option value="">Select a category</option>
                                <option value="Engineer" {{ old('service_category') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                                <option value="Architect" {{ old('service_category') == 'Architect' ? 'selected' : '' }}>Architect</option>
                                <option value="Designer" {{ old('service_category') == 'Designer' ? 'selected' : '' }}>Designer</option>
                                <option value="Electrician" {{ old('service_category') == 'Electrician' ? 'selected' : '' }}>Electrician</option>
                                <option value="Plumber" {{ old('service_category') == 'Plumber' ? 'selected' : '' }}>Plumber</option>
                                <option value="Carpenter" {{ old('service_category') == 'Carpenter' ? 'selected' : '' }}>Carpenter</option>
                                <option value="Painter" {{ old('service_category') == 'Painter' ? 'selected' : '' }}>Painter</option>
                                <option value="Landscaper" {{ old('service_category') == 'Landscaper' ? 'selected' : '' }}>Landscaper</option>
                            </select>
                            @error('service_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold" style="color: var(--primary-dark);">Project Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5"
                                      placeholder="Describe your project in detail...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Budget Range -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="budget_min" class="form-label fw-semibold" style="color: var(--primary-dark);">Minimum Budget ($)</label>
                                <input type="number" class="form-control @error('budget_min') is-invalid @enderror" 
                                       id="budget_min" name="budget_min" value="{{ old('budget_min') }}" 
                                       placeholder="1000"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('budget_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="budget_max" class="form-label fw-semibold" style="color: var(--primary-dark);">Maximum Budget ($)</label>
                                <input type="number" class="form-control @error('budget_max') is-invalid @enderror" 
                                       id="budget_max" name="budget_max" value="{{ old('budget_max') }}" 
                                       placeholder="5000"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('budget_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Deadline and Location -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="deadline" class="form-label fw-semibold" style="color: var(--primary-dark);">Project Deadline</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                       id="deadline" name="deadline" value="{{ old('deadline') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold" style="color: var(--primary-dark);">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location') }}" 
                                       placeholder="City, State"
                                       style="border: 2px solid var(--light-grey); border-radius: 15px; padding: 12px;">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Required Skills -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--primary-dark);">Required Skills</label>
                            <div id="skills-container">
                                <div class="input-group mb-2">
                                    <input type="text" name="required_skills[]" class="form-control" placeholder="e.g., Plumbing" style="border: 2px solid var(--light-grey); border-radius: 15px 0 0 15px; padding: 12px;">
                                    <button type="button" class="btn" onclick="addSkill()" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 0 15px 15px 0; padding: 12px 20px;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">Add relevant skills required for this job</small>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-lg" style="background: var(--gold-accent); color: var(--primary-dark); border-radius: 15px; padding: 15px; font-weight: 600;">
                                <i class="fas fa-paper-plane me-2"></i>Post Job
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-lg" style="background: transparent; color: var(--primary-dark); border: 2px solid var(--light-grey); border-radius: 15px; padding: 15px; font-weight: 600;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addSkill() {
    const container = document.getElementById('skills-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="required_skills[]" class="form-control" placeholder="Another skill" style="border: 2px solid var(--light-grey); border-radius: 15px 0 0 15px; padding: 12px;">
        <button type="button" class="btn" onclick="this.parentElement.remove()" style="background: #dc3545; color: white; border-radius: 0 15px 15px 0; padding: 12px 20px;">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection