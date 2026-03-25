{{-- resources/views/partials/search-results.blade.php --}}
@foreach($localResults as $location)
    <div class="search-result-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
        <div class="p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($location->type === 'store') bg-green-100 text-green-800
                    @elseif($location->type === 'professional') bg-blue-100 text-blue-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    {{ ucfirst($location->type) }}
                </span>
                @if($location->is_verified)
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $location->name }}</h3>
            
            <p class="text-gray-600 text-sm mb-3">{{ $location->address }}</p>
            
            @if($location->distance)
                <p class="text-sm text-gray-500 mb-3">
                    <span class="font-medium">{{ number_format($location->distance, 1) }} miles away</span>
                </p>
            @endif
            
            @if($location->phone)
                <p class="text-sm text-gray-600 mb-2">
                    <svg class="h-4 w-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ $location->phone }}
                </p>
            @endif
            
            <div class="mt-4 flex space-x-3">
                <a href="{{ route('location.show', $location) }}" class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
                    View Details
                </a>
                @if($location->website)
                    <a href="{{ $location->website }}" target="_blank" class="text-gray-600 hover:text-gray-900 px-3 py-2 border border-gray-300 rounded-md text-sm">
                        Website
                    </a>
                @endif
            </div>
        </div>
    </div>
@endforeach

@if(isset($googleResults) && !empty($googleResults['results']))
    @foreach($googleResults['results'] as $place)
        <div class="search-result-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow border-2 border-green-100">
            <div class="p-6">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mb-2 inline-block">
                    Google Places
                </span>
                
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $place['name'] }}</h3>
                
                <p class="text-gray-600 text-sm mb-3">{{ $place['vicinity'] ?? 'Address not available' }}</p>
                
                @if(isset($place['rating']))
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-4 w-4 {{ $i <= $place['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">({{ $place['user_ratings_total'] ?? 0 }} reviews)</span>
                    </div>
                @endif
                
                <button onclick="getPlaceDetails('{{ $place['place_id'] }}')" class="mt-4 w-full text-center bg-white text-green-600 px-4 py-2 rounded-md text-sm border border-green-300 hover:bg-green-50">
                    View on Google
                </button>
            </div>
        </div>
    @endforeach
@endif

@if($localResults->isEmpty() && empty($googleResults['results']))
    <div class="col-span-full text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search radius or location.</p>
    </div>
@endif