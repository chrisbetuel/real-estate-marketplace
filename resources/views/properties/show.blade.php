<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }} - Oweru Real Estate</title>
</head>
<body>
    <div class="container">
        <h1>{{ $property->title }}</h1>
        <p>{{ $property->description }}</p>
        <p>Price: ${{ $property->price }}</p>
        <a href="{{ route('properties.index') }}">Back to list</a>
    </div>
</body>
</html>

