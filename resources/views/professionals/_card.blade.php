<div class="professional-card position-relative p-4 border rounded-3 shadow-sm h-100 transition-all hover-lift">
    <!-- Lock overlay for guests -->
    @guest
        <div class="card-lock-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center rounded-3" style="background: rgba(0,0,0,0.7); z-index: 2;">
            <i class="fas fa-lock fa-2x text-white mb-2"></i>
            <h5 class="text-white mb-1">Login to unlock</h5>
            <p class="text-white-50 mb-3 text-center px-3">View full profile, contact details and message professionals</p>
            <a href="{{ route('login') }}" class="btn btn-warning">Login / Register</a>
        </div>
    @endguest

    <!-- Avatar -->
    <div class="row align-items-center">
        <div class="col-auto">
            <div class="avatar-lg">
                <img src="{{ $professional->profile_image_url ?? 'https://via.placeholder.com/80x80/6B7280/F3F4F6?text=' . substr($professional->name, 0, 2) }}" 
                     alt="{{ $professional->name }}" 
                     class="rounded-4 object-fit-cover w-100 h-100">
            </div>
        </div>
        <div class="col">
            <!-- Name & Title -->
            <div>
                <a href="{{ route('professionals.show', $professional) }}" 
                   @guest onclick="event.preventDefault(); window.location.href='{{ route('login') }}'; return false;" @endguest
                   class="h5 mb-1 fw-bold text-decoration-none text-dark d-block">{{ $professional->name }}</a>
                
                @if($professional->professionalProfile)
                    <div class="text-muted small">{{ $professional->professionalProfile->profession ?? 'Professional' }} • {{ $professional->professionalProfile->years_experience ?? 0 }} yrs exp.</div>
                @else
                    <div class="text-muted small">Real Estate Professional</div>
                @endif
            </div>

            <!-- Location -->
            <div class="text-muted small mt-1">
                <i class="fas fa-map-marker-alt me-1"></i>
                {{ $professional->professionalProfile->city ?? 'Location not set' }}, {{ $professional->professionalProfile->state ?? '' }}
            </div>

            <!-- Rating -->
            <div class="mt-2">
                <div class="d-flex align-items-center">
                    <div class="d-flex me-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($professional->rating ?? 0) ? 'text-warning' : 'far text-muted' }} fs-6 me-1"></i>
                        @endfor
                    </div>
                    <span class="small fw-medium text-dark">{{ number_format($professional->rating ?? 0, 1) }}</span>
                    @if($professional->reviews_count)
                        <span class="text-muted small">({{ $professional->reviews_count }})</span>
                    @endif
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mt-2">
                @if($professional->is_verified)
                    <span class="badge bg-success fs-6 px-2 py-1">Verified</span>
                @else
                    <span class="badge bg-warning fs-6 px-2 py-1">New</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Action buttons - always visible, locked for guests -->
    <div class="mt-3 pt-3 border-top">
        <div class="d-flex gap-2">
            @auth
                <a href="{{ route('messages.start-professional', $professional) }}" class="btn btn-outline-primary flex-fill">
                    <i class="fas fa-message me-1"></i> Message
                </a>
                <a href="{{ route('professionals.show', $professional) }}" class="btn btn-primary flex-fill">
                    <i class="fas fa-eye me-1"></i> View Profile
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-secondary flex-fill">
                    <i class="fas fa-lock me-1"></i> Unlock Message
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary flex-fill">
                    <i class="fas fa-lock me-1"></i> Unlock Profile
                </a>
            @endauth
        </div>
    </div>

    <!-- Connection status for logged-in clients -->
    @auth('web')
        @if(auth()->user()->user_type === 'client')
            @php
                $hasPaidConnection = \App\Models\Transaction::where('client_id', auth()->id())
                    ->where('professional_id', $professional->id)
                    ->where('type', 'connection_fee')
                    ->where('status', 'completed')
                    ->exists();
            @endphp
            @if(!$hasPaidConnection)
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1 text-info"></i>
                        Pay $5 connection fee to unlock full contact & unlimited messaging
                        <a href="{{ route('payment.professional-unlock', $professional) }}" class="text-decoration-none">Pay now →</a>
                    </small>
                </div>
            @endif
        @endif
    @endauth
</div>

<style>
.professional-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
    cursor: pointer;
}

.professional-card:hover:not(.locked) {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    transform: translateY(-2px);
}

.professional-card .avatar-lg {
    width: 80px;
    height: 80px;
}

.card-lock-overlay {
    backdrop-filter: blur(2px);
}

.hover-lift:hover {
    transform: translateY(-4px);
}

@media (max-width: 768px) {
    .professional-card .btn {
        font-size: 0.8rem;
        padding: 0.5rem;
    }
}
</style>
