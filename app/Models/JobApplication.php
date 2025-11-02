<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_applications';
    protected $fillable = [

        'job_id',
        'user_id',
        'employer_id',
        'applied_date',
        'status'
    ];

    protected $hidden = [
        'job_id',
        'user_id',
        'employer_id',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    public function jobDetail()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function employe()
    {
        return $this->belongsTo(User::class, 'employer_id', 'id');

    }


}
