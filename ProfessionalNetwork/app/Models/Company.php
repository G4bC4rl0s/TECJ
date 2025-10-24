<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'logo', 'description', 'website', 
        'industry', 'size', 'location', 'founded_year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobListing::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class);
    }

    public function isFollowedBy($userId)
    {
        return $this->followers()->where('user_id', $userId)->exists();
    }
}
