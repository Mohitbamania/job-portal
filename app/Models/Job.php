<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_jobs';

    protected $fillable = [
        'user_id',
        'job_category_id',
        'job_type_id',
        'title',
        'vacancy',
        'salary',
        'location',
        'description',
        'benefits',
        'responsibility',
        'qualification',
        'keywords',
        'experience',
        'company_name',
        'company_location',
        'company_website',
        'status',
        'isFeatured'
    ];

    protected $hidden = [
        'user_id',
        'job_category_id',
        'job_type_id',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }
}

