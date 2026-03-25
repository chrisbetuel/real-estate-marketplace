@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Search Results</h1>
    
    <div class="mb-8">
        <form action="{{ route('search.jobs') }}" method="GET" class="bg-gray-100 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <input type="text" name="category" value="{{ request('category') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Keyword</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                    Search
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties ?? [] as $property)
            <div class="border rounded-lg overflow-hidden shadow-lg">
                @if($property->getFirstMediaUrl('property_images'))
                    <img src="{{ $property->getFirstMediaUrl('property_images') }}" 
                         alt="{{ $property->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="text-xl font-semibold">{{ $property->title }}</h3>
                    <p class="text-gray-600 mt-1">{{ $property->city }}, {{ $property->state }}</p>
                    <p class="text-lg font-bold text-blue-600 mt-2">${{ number_format($property->price) }}</p>
                    <div class="flex justify-between mt-3 text-sm text-gray-500">
                        <span>{{ $property->bedrooms }} beds</span>
                        <span>{{ $property->bathrooms }} baths</span>
                        <span>{{ $property->square_feet }} sqft</span>
                    </div>
                    <a href="{{ route('properties.show', $property) }}" 
                       class="block text-center mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8">
                <p class="text-gray-500">No properties found matching your criteria.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection