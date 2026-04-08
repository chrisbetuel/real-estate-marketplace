<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Job;

return new class extends Migration
{
    public function up()
    {
        // Fix existing invalid required_skills data
        $jobs = Job::whereNotNull('required_skills')->get();
        
        foreach ($jobs as $job) {
            $rawValue = $job->getRawOriginal('required_skills');
            
            if (is_string($rawValue) && !empty($rawValue)) {
                // Try JSON decode
                $decoded = json_decode($rawValue, true);
                
                if ($decoded !== null && is_array($decoded)) {
                    // Valid JSON, no change needed
                    continue;
                }
                
                // Convert string to array (split by common delimiters)
                $skills = preg_split('/[,;|]/', $rawValue);
                $cleanSkills = array_map('trim', array_filter($skills));
                
                // Update as JSON
                $job->update(['required_skills' => $cleanSkills]);
            }
        }
        
        DB::statement('ALTER TABLE project_jobs MODIFY required_skills JSON NULL');
    }

    public function down()
    {
        // No destructive changes
        Schema::table('project_jobs', function (Blueprint $table) {
            // Revert if needed, but data is safer as JSON
        });
    }
};

