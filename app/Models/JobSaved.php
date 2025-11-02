<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobSaved extends Model
{

    use HasFactory;

    protected $table = 'job_saved';
    protected $fillable = [

        'user_id',
        'job_id'
    ];

    protected $hidden = [
        'job_id',
        'user_id',
    ];


    public function job()
    {

        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }
}
