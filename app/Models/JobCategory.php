<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_categories';
    protected $fillable = [

        'name',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }

    //
}
