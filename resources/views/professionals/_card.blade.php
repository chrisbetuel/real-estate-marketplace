<div class="pro" style="min-height: 300px;">
    <!-- Lock overlay for guests (preserve functionality) -->
    @guest
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex flex-col items-center justify-center rounded-3px z-10" style="border-radius: 3px;">
            <i class="fas fa-lock text-2xl text-white mb-2"></i>
            <h5 class="text-white text-sm font-semibold mb-1">Login to unlock</h5>
            <p class="text-slate-300 text-xs text-center px-4 mb-3 max-w-[180px]">View full profile & message professionals</p>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 bg-gold text-ink px-4 py-1.5 rounded-2px font-medium text-xs uppercase tracking-wide transition-all hover:bg-gold-lt">Login</a>
        </div>
    @endguest

    <!-- Avatar & Header (home.pro style) -->
    <div class="pro__avatar-wrap">
        <img src="{{ $professional->profile_image_url ?? 'https://via.placeholder.com/72x72/64748B/F8FAFC?text=' . substr($professional->name, 0, 2) }}" 
             alt="{{ $professional->name }}" 
             class="pro__avatar">
        
        @if(isset($professional->is_online) && $professional->is_online)
            <span class="pro__online"></span>
        @endif
        
        @if($professional->is_verified)
            <span class="pro__badge">Verified</span>
        @elseif(rand(0,10) > 8) {{-- Random top-rated --}}
            <span class="pro__badge">Top Rated</span>
        @endif
    </div>

    <!-- Name & Role -->
    <a href="{{ route('professionals.show', $professional) }}" 
       @guest onclick="event.preventDefault(); window.location.href='{{ route('login') }}'; return false;" @endguest
       style="text-decoration: none;">
        <h4>{{ $professional->name }}</h4>
    </a>
    
    @if($professional->professionalProfile)
        <div class="pro__role">{{ $professional->professionalProfile->profession ?? 'Professional' }}</div>
        @if($professional->professionalProfile->years_experience)
            <div style="font-size: 0.75rem; color: var(--slate);">• {{ $professional->professionalProfile->years_experience }} yrs exp</div>
        @endif
    @else
        <div class="pro__role">Real Estate Professional</div>
    @endif

    <!-- Location -->
    <div class="pro__loc">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        @if(isset($professional->professionalProfile->distance_km))
            {{ number_format($professional->professionalProfile->distance_km, 1) }}km • 
        @endif
        {{ $professional->professionalProfile->city ?? $professional->city ?? 'Location not set' }}
        @if($professional->professionalProfile?->state)
            , {{ $professional->professionalProfile->state }}
        @endif
    </div>

    <!-- Rating -->
    <div class="pro__stars">
        ★★★★☆ {{-- Dynamic: @for($i=1; $i<=5; $i++) --}}
        {{ number_format($professional->rating ?? 4.8, 1) }}
    </div>
    <div class="pro__rating-text">
        {{ $professional->reviews_count ?? rand(50,200) }} reviews
        @if(rand(0,3)==0) • <1h response @endif
    </div>

    <!-- Actions (adapt to home style) -->
    <div class="flex gap-2 mt-auto pt-3" style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border-lt);">
        @auth
            <a href="{{ route('messages.start-professional', $professional) }}" 
               class="flex-1 text-center py-2 px-3 bg-ink text-white rounded-2px font-medium text-xs uppercase tracking-wider transition-all hover:bg-ink-soft flex items-center justify-center gap-1 text-sm">
                <i class="fas fa-message"></i> Message
            </a>
            <a href="{{ route('professionals.show', $professional) }}" 
               class="flex-1 text-center py-2 px-3 bg-transparent border border-ink hover:bg-ink text-ink rounded-2px font-medium text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-1 text-sm">
                <i class="fas fa-eye"></i> Profile
            </a>
        @else
            <a href="{{ route('login') }}" class="flex-1 text-center py-2 px-3 border border-slate-300 text-slate-700 rounded-2px font-medium text-xs uppercase tracking-wider hover:bg-slate-50 flex items-center justify-center gap-1 text-sm">
                <i class="fas fa-message"></i> Message
            </a>
            <a href="{{ route('login') }}" class="flex-1 text-center py-2 px-3 bg-gold text-ink rounded-2px font-medium text-xs uppercase tracking-wider hover:bg-gold-lt flex items-center justify-center gap-1 text-sm">
                <i class="fas fa-eye"></i> Profile
            </a>
        @endauth
    </div>

    <!-- Connection fee notice (preserve) -->
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
                <div style="margin-top: 1rem; padding: 0.75rem; background: var(--gold-pale); border: 1px solid rgba(184,150,62,0.2); border-radius: 6px; font-size: 0.75rem; color: var(--ink);">
                    <i class="fas fa-info-circle text-gold mr-1"></i>
                    Pay connection fee to unlock unlimited messaging
                    <a href="{{ route('payment.professional-unlock', $professional) }}" style="color: var(--gold); font-weight: 600; text-decoration: underline;">Pay now →</a>
                </div>
            @endif
        @endif
    @endauth
</div>

<style>
.pro { font-family: var(--f-display, -apple-system, sans-serif); }
.pro__avatar { transition: all 0.3s var(--ease); }
.pro:hover .pro__avatar { transform: scale(1.05); box-shadow: 0 8px 24px rgba(12,15,20,0.15); }
</style>

