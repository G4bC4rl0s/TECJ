<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobListing::with('company')->where('is_active', true)->latest()->paginate(12);
        return view('jobs.index', compact('jobs'));
    }

    public function show(JobListing $job)
    {
        $job->load('company');
        return view('jobs.show', compact('job'));
    }

    public function followed()
    {
        $followedCompanies = auth()->user()->followedCompanies()->pluck('companies.id');
        $jobs = JobListing::with('company')
            ->whereIn('company_id', $followedCompanies)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
        
        return view('jobs.followed', compact('jobs'));
    }
}