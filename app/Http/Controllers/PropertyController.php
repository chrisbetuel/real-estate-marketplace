<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('location')
            ->latest()
            ->paginate(12);
            
        return view('properties.index', compact('properties'));
    }
    
    public function show(Property $property)
    {
        $property->load(['location', 'media']);
        
        return view('properties.show', compact('property'));
    }
    
    // Add more methods as needed (create, store, edit, etc.)
}

