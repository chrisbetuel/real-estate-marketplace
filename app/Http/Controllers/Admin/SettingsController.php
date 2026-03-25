<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Show settings page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        // This would typically update site settings in a settings table
        // For now, just a placeholder

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect()->route('admin.settings')
            ->with('success', 'Application cache cleared successfully.');
    }
}