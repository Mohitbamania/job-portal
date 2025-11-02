<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_types';
    protected $fillable = [

        'name',
        'status'
    ];
    protected $dates = ['deleted_at'];
}
