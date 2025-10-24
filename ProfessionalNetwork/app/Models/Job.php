<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'title', 'description', 'requirements', 
        'benefits', 'salary_min', 'salary_max', 'location', 
        'type', 'level', 'is_remote', 'is_active'
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
