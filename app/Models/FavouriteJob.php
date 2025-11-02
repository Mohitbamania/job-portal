<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavouriteJob extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'favourite_jobs';
    protected $fillable = [

        'user_id',
        'job_id',
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function job()
    {

        return $this->belongsTo(Job::class, 'job_id', 'id');
    }


}
