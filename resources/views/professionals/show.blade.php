@extends('layouts.app')

@section('title', 'Professional Profile - {{ $professional->name }}')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $professional->name }}</h4>
                    <span class="badge bg-primary">Professional</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <img src="{{ $professional->profile_image_url }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                <h5>{{ $professional->name }}</h5>
                                <p class="text-muted">{{ $professional->email }}</p>
@if($professional->professionalProfile)
                                    <p class="text-primary">{{ $professional->professionalProfile->profession ?? 'N/A' }}</p>
                                    <p class="mt-2">{{ $professional->professionalProfile->bio ?? 'No bio available.' }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="mb-3">Contact Information</h6>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Email:</strong></div>
{{ $hasPaidUnlock ? $professional->email : $professional->masked_email ?? $professional->email }}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Phone:</strong></div>
{{ $hasPaidUnlock ? ($professional->phone ?? 'N/A') : ($professional->masked_phone ?? 'N/A') }}
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Address:</strong></div>
                                <div class="col-sm-9">{{ $professional->address ?? 'N/A' }}</div>
                            </div>
                            @if($professional->professionalProfile)
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Profession:</strong></div>
                                        <div class="col-sm-9">{{ $professional->professionalProfile->profession ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Years of Experience:</strong></div>
                                        <div class="col-sm-9">{{ $professional->professionalProfile->years_experience ?? 'N/A' }} years</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Bio:</strong></div>
                                        <div class="col-sm-9">{{ $professional->professionalProfile->bio ?? 'No bio available.' }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Qualifications:</strong></div>
                                        <div class="col-sm-9">{{ implode(', ', $professional->professionalProfile->qualifications ?? []) }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Languages:</strong></div>
                                        <div class="col-sm-9">{{ implode(', ', $professional->professionalProfile->languages ?? []) }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Hourly Rate:</strong></div>
                                        <div class="col-sm-9">${{ number_format($professional->professionalProfile->hourly_rate ?? 0, 2) }}/hr</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Availability:</strong></div>
                                        <div class="col-sm-9">
                                            @if($professional->professionalProfile->availability)
                                                <span class="badge bg-success">Available</span>
                                            @else
                                                <span class="badge bg-warning">Busy</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Rating:</strong></div>
                                <div class="col-sm-9">{{ number_format($professional->rating, 1) }} ({{ $professional->reviews_count }} reviews)</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Verified:</strong></div>
                                <div class="col-sm-9">
                                    @if($professional->is_verified)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Pending Verification</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Status:</strong></div>
                                <div class="col-sm-9">
                                    @if($professional->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @auth
                        @if(auth()->user()->isClient() && !$hasPaidUnlock)
                            <div class="alert alert-warning mt-4">
                                <h6><i class="fas fa-lock me-2"></i>Contact details are locked</h6>
                                <p class="mb-3">Pay $10 to unlock full email, phone and address details for this professional.</p>
                                <a href="{{ route('payment.professional-unlock', $professional) }}" class="btn btn-warning btn-lg w-100">
                                    <i class="fas fa-unlock me-2"></i> Unlock Full Details - $10
                                </a>
                            </div>
                        @endif
                    @endauth
                    <div class="mt-4">
                        <a href="{{ route('professionals.index') }}" class="btn btn-secondary">Back to Professionals</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
