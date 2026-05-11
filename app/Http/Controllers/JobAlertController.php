<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobAlertController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $jobAlerts = $user->jobAlerts()->latest()->get();

        return view('client.job-alerts', compact('jobAlerts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keyword' => ['nullable', 'string', 'max:255'],
            'enabled' => ['sometimes', 'boolean'],
        ]);

        $user = $request->user();

        $keyword = trim((string)($validated['keyword'] ?? ''));
        $enabled = (bool)($validated['enabled'] ?? true);

        $alert = $user->jobAlerts()->updateOrCreate(
            [
                'keyword' => $keyword,
            ],
            [
                'enabled' => $enabled,
            ]
        );

        return redirect()->route('client.job-alerts')->with('success', 'Job alert saved.');
    }

    public function destroy(Request $request, JobAlert $jobAlert)
    {
        $this->authorize('delete', $jobAlert);

        $jobAlert->delete();

        return redirect()->route('client.job-alerts')->with('success', 'Job alert removed.');
    }
}

