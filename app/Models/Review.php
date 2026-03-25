<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_job_id', 'product_id', 'reviewer_id', 'reviewee_id',
        'rating', 'comment', 'criteria_ratings', 'response', 'response_at'
    ];

    protected $casts = [
        'criteria_ratings' => 'array',
        'response_at' => 'datetime',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function projectJob()
    {
        return $this->belongsTo(Job::class, 'project_job_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}