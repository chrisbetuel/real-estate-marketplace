@extends('admin.layouts.app')

@section('title', 'Location Details')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $location->name }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.locations.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                Back to List
            </a>
            <a href="{{ route('admin.locations.edit', $location) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $location->type == 'store' ? 'bg-blue-100 text-blue-800' : ($location->type == 'professional' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ ucfirst($location->type) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->category ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">City</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $location->city }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Verified</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $location->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $location->is_verified ? 'Yes' : 'No' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">State</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->state }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Zip Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->zip_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->phone ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700">Website</dt>
                            <dd class="mt-1">
                                @if($location->website)
                                    <a href="{{ $location->website }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Visit Website →
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm">N/A</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Location Coordinates</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Latitude</dt>
                            <dd class="mt-1 text-sm font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $location->latitude }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Longitude</dt>
                            <dd class="mt-1 text-sm font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $location->longitude }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->created_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $location->updated_at->format('M d, Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $location->description ?? 'No description available.' }}</p>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.locations.index') }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium">
                    Back to List
                </a>
                <a href="{{ route('admin.locations.edit', $location) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    Edit Location
                </a>
                <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="inline ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium" onclick="return confirm('Are you sure you want to delete this location?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
