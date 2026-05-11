@extends('layouts.app')

@section('title', 'Post a Job - BuildConnect')

@section('content')
<div class="post-job-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="page-badge">
                        <i class="fas fa-briefcase"></i> Post a Job
                    </div>
                    <h1 class="page-title">Find the <span class="gold-text">Right Professional</span></h1>
                    <p class="page-subtitle">Fill in the details below to get matched with qualified experts</p>
                </div>

                <!-- Form Card -->
                <div class="form-card">
                    <form action="{{ route('jobs.store') }}" method="POST" id="jobForm">
                        @csrf
                        
                        <!-- Job Title -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heading"></i> Job Title
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="e.g., Modern Living Room Renovation">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Be specific and descriptive to attract the right candidates</small>
                        </div>

                        <!-- Service Category -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag"></i> Service Category
                            </label>
                            <select class="form-control @error('service_category') is-invalid @enderror" 
                                    id="service_category" name="service_category">
                                <option value="">Select a category</option>
                                <option value="Engineer" {{ old('service_category') == 'Engineer' ? 'selected' : '' }}>👷 Engineer</option>
                                <option value="Architect" {{ old('service_category') == 'Architect' ? 'selected' : '' }}>🏛️ Architect</option>
                                <option value="Designer" {{ old('service_category') == 'Designer' ? 'selected' : '' }}>🎨 Designer</option>
                                <option value="Electrician" {{ old('service_category') == 'Electrician' ? 'selected' : '' }}>⚡ Electrician</option>
                                <option value="Plumber" {{ old('service_category') == 'Plumber' ? 'selected' : '' }}>🚰 Plumber</option>
                                <option value="Carpenter" {{ old('service_category') == 'Carpenter' ? 'selected' : '' }}>🪚 Carpenter</option>
                                <option value="Painter" {{ old('service_category') == 'Painter' ? 'selected' : '' }}>🎨 Painter</option>
                                <option value="Landscaper" {{ old('service_category') == 'Landscaper' ? 'selected' : '' }}>🌿 Landscaper</option>
                            </select>
                            @error('service_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-file-alt"></i> Project Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6"
                                      placeholder="Describe your project in detail... What needs to be done? Any specific requirements?">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Include project scope, materials, and any special requirements</small>
                        </div>

                        <!-- Budget Range -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-dollar-sign"></i> Minimum Budget
                                    </label>
                                    <div class="input-with-icon">
                                        <span class="currency">$</span>
                                        <input type="number" class="form-control @error('budget_min') is-invalid @enderror" 
                                               id="budget_min" name="budget_min" value="{{ old('budget_min') }}" 
                                               placeholder="1,000">
                                    </div>
                                    @error('budget_min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-dollar-sign"></i> Maximum Budget
                                    </label>
                                    <div class="input-with-icon">
                                        <span class="currency">$</span>
                                        <input type="number" class="form-control @error('budget_max') is-invalid @enderror" 
                                               id="budget_max" name="budget_max" value="{{ old('budget_max') }}" 
                                               placeholder="5,000">
                                    </div>
                                    @error('budget_max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deadline and Location -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Project Deadline
                                    </label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                           id="deadline" name="deadline" value="{{ old('deadline') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i> Location
                                    </label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}" 
                                           placeholder="New York, NY">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Remote? Type 'Remote'</small>
                                </div>
                            </div>
                        </div>

                        <!-- Required Skills -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tools"></i> Required Skills
                            </label>
                            <div id="skills-container">
                                <div class="skill-input-group">
                                    <input type="text" name="required_skills[]" class="form-control skill-input" placeholder="e.g., Plumbing, Electrical, Carpentry">
                                    <button type="button" class="btn-add-skill" onclick="addSkill()">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                            <small class="form-hint">Add all relevant skills required for this job</small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Post Job
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Tips Card -->
                <div class="tips-card">
                    <div class="tips-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="tips-content">
                        <h4>Pro Tips for Better Results</h4>
                        <ul>
                            <li>✓ Be specific about your project requirements</li>
                            <li>✓ Include a realistic budget range</li>
                            <li>✓ Add relevant skills to attract qualified professionals</li>
                            <li>✓ Set a reasonable deadline for quality work</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   POST A JOB PAGE - PROFESSIONAL DESIGN
   Colors: Dark Blue #1E2A3A | Gold #F5A623 | White | Grey
============================================ */

.post-job-page {
    background: #F4F6F9;
    min-height: calc(100vh - 70px);
    padding: 48px 0;
}

/* Header Section */
.page-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245,166,35,0.1);
    color: #F5A623;
    padding: 6px 14px;
    border-radius: 40px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 16px;
}

.page-title {
    font-size: 36px;
    font-weight: 700;
    color: #1E2A3A;
    margin-bottom: 12px;
}

.gold-text {
    color: #F5A623;
}

.page-subtitle {
    font-size: 16px;
    color: #6B7280;
    margin-bottom: 0;
}

/* Form Card */
.form-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    border: 1px solid #E8EDF2;
}

/* Form Groups */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #1E2A3A;
    margin-bottom: 10px;
}

.form-label i {
    color: #F5A623;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    font-size: 14px;
    font-family: inherit;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    background: #FFFFFF;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #F5A623;
    box-shadow: 0 0 0 3px rgba(245,166,35,0.1);
}

select.form-control {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.input-with-icon {
    position: relative;
}

.currency {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-weight: 500;
}

.input-with-icon .form-control {
    padding-left: 28px;
}

.form-hint {
    display: block;
    font-size: 11px;
    color: #9CA3AF;
    margin-top: 6px;
}

.invalid-feedback {
    color: #EF4444;
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

/* Skills Section */
#skills-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.skill-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.skill-input {
    flex: 1;
}

.btn-add-skill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0 18px;
    height: 46px;
    background: #F5A623;
    color: #1E2A3A;
    border: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-add-skill:hover {
    background: #D4891A;
}

.remove-skill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    background: #FEF2F2;
    color: #EF4444;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.remove-skill:hover {
    background: #FEE2E2;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #E8EDF2;
}

.btn-submit {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 24px;
    background: #1E2A3A;
    color: #FFFFFF;
    border: none;
    border-radius: 40px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit:hover {
    background: #2D3A4E;
    transform: translateY(-1px);
}

.btn-cancel {
    flex: 0.5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 24px;
    background: transparent;
    color: #6B7280;
    border: 1.5px solid #E2E8F0;
    border-radius: 40px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #F8FAFC;
    border-color: #CBD5E1;
}

/* Tips Card */
.tips-card {
    background: #FFFFFF;
    border-radius: 20px;
    padding: 24px;
    margin-top: 24px;
    display: flex;
    gap: 20px;
    border: 1px solid #E8EDF2;
}

.tips-icon {
    width: 48px;
    height: 48px;
    background: rgba(245,166,35,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.tips-icon i {
    font-size: 24px;
    color: #F5A623;
}

.tips-content {
    flex: 1;
}

.tips-content h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1E2A3A;
    margin-bottom: 12px;
}

.tips-content ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.tips-content li {
    font-size: 13px;
    color: #6B7280;
    margin-bottom: 8px;
}

.tips-content li:last-child {
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .post-job-page {
        padding: 24px 0;
    }
    
    .page-title {
        font-size: 28px;
    }
    
    .form-card {
        padding: 24px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-cancel {
        flex: 1;
    }
    
    .tips-card {
        flex-direction: column;
        text-align: center;
    }
    
    .tips-icon {
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .form-card {
        padding: 20px;
    }
    
    .skill-input-group {
        flex-wrap: wrap;
    }
    
    .btn-add-skill {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function addSkill() {
    const container = document.getElementById('skills-container');
    const div = document.createElement('div');
    div.className = 'skill-input-group';
    div.innerHTML = `
        <input type="text" name="required_skills[]" class="form-control skill-input" placeholder="Another skill">
        <button type="button" class="remove-skill" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endpush
@endsection