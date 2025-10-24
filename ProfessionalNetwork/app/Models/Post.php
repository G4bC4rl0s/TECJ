<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image', 'type', 'related_id', 'related_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
