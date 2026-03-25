<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Oweru Real Estate</title>
</head>
<body>
    <div class="container">
        <h1>Properties for Sale/Rent</h1>
        @forelse($properties as $property)
            <div>
                <h3>{{ $property->title }}</h3>
                <p>{{ $property->price }}</p>
                <a href="{{ route('properties.show', $property) }}">View</a>
            </div>
        @empty
            <p>No properties available</p>
        @endforelse
    </div>
</body>
</html>

