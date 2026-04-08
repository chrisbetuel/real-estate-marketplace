<?php
// app/Http/Controllers/ServiceEcosystemController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalProfile;
use App\Helpers\ServiceEcosystem;

class ServiceEcosystemController extends Controller
{
public function getProfessionalsByStage($stage, Request $request)
    {
        // If only count is requested
        if ($request->has('count_only')) {
            $count = ProfessionalProfile::whereHas('user')->where('stage', $stage)->count();
            return response()->json(['count' => $count]);
        }

        // Get stage professions or substage if provided
        $substages = ServiceEcosystem::getStages()[$stage]['substages'] ?? [];
        $professions = ServiceEcosystem::getProfessionsByStage($stage);
        
        if ($request->substage && isset($substages[$request->substage])) {
            $professions = $substages[$request->substage]['professions'];
            $substage_name = $substages[$request->substage]['name'];
        }

        // Get professionals matching stage and profession
        $professionals = ProfessionalProfile::query()
            ->whereHas('user')
            ->where('stage', $stage)
            ->whereIn('profession', $professions)
            ->with('user')
            ->limit(20)
            ->get()
            ->map(function($profile) {
                if (!$profile->user) {
                    return null;
                }
                return [
                    'id' => $profile->user_id ?? null,
                    'name' => $profile->user->name ?? 'Unknown Professional',
                    'profession' => $profile->profession,
                    'avatar' => $profile->user->profile_image_url ?? asset('images/default-avatar.png'),
                    'years_experience' => $profile->years_experience,
                    'hourly_rate' => $profile->hourly_rate,
                    'rating' => $profile->user->rating ?? 0,
                    'reviews_count' => $profile->user->reviews_count ?? 0,
                    'verified' => $profile->user->is_verified ?? false,
                    'skills' => is_array($profile->skills) ? array_slice($profile->skills, 0, 3) : []
                ];
            })
            ->filter()
            ->values();

        if ($request->ajax()) {
            return response()->json([
                'professionals' => $professionals,
                'stage_name' => ServiceEcosystem::getStageName($stage),
                'professions_list' => ServiceEcosystem::getProfessionsByStage($stage)
            ]);
        }

        return view('professionals.stage', [
            'professionals' => $professionals,
            'stage' => $stage,
            'stage_name' => ServiceEcosystem::getStageName($stage),
            'stage_info' => ServiceEcosystem::getStages()[$stage],
            'professions_list' => ServiceEcosystem::getProfessionsByStage($stage)
        ]);
    }
}

