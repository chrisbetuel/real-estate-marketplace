<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of property categories.
     */
    public function index(Request $request)
    {
        $query = PropertyCategory::orderBy('sort_order')->orderBy('name');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(15);

        return view('admin.property-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new property category.
     */
    public function create()
    {
        return view('admin.property-categories.create');
    }

    /**
     * Store a newly created property category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:property_categories',
            'slug' => 'nullable|string|max:255|unique:property_categories',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['name']);
        }

        PropertyCategory::create($validated);

        return redirect()->route('admin.property-categories.index')
            ->with('success', 'Property category created successfully.');
    }

    /**
     * Display the specified property category.
     */
    public function show(PropertyCategory $propertyCategory)
    {
        return view('admin.property-categories.show', compact('propertyCategory'));
    }

    /**
     * Show the form for editing the specified property category.
     */
    public function edit(PropertyCategory $propertyCategory)
    {
        return view('admin.property-categories.edit', compact('propertyCategory'));
    }

    /**
     * Update the specified property category in storage.
     */
    public function update(Request $request, PropertyCategory $propertyCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:property_categories,name,' . $propertyCategory->id,
            'slug' => 'nullable|string|max:255|unique:property_categories,slug,' . $propertyCategory->id,
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Str::slug($validated['name']);
        }

        $propertyCategory->update($validated);

        return redirect()->route('admin.property-categories.index')
            ->with('success', 'Property category updated successfully.');
    }

    /**
     * Remove the specified property category from storage.
     */
    public function destroy(PropertyCategory $propertyCategory)
    {
        $propertyCategory->delete();

        return redirect()->route('admin.property-categories.index')
            ->with('success', 'Property category deleted successfully.');
    }
}

