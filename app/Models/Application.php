<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'name',
        'surname',
        'email',
        'cv_path',
        'motivational_letter',
    ];

   
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

