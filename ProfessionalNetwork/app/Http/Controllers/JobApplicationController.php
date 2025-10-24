<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function apply(JobListing $job)
    {
        $user = Auth::user();
        
        if ($job->hasAppliedBy($user->id)) {
            return redirect()->back()->with('error', 'Você já se candidatou para esta vaga.');
        }

        JobApplication::create([
            'user_id' => $user->id,
            'job_listing_id' => $job->id,
            'status' => 'pending'
        ]);

        // Criar post de atividade
        Post::create([
            'user_id' => $user->id,
            'content' => 'se candidatou para a vaga de ' . $job->title . ' na empresa ' . $job->company->name,
            'type' => 'job_application',
            'related_id' => $job->id,
            'related_type' => 'App\\Models\\JobListing'
        ]);

        return redirect()->back()->with('success', 'Candidatura enviada com sucesso!');
    }

    public function myApplications()
    {
        $applications = Auth::user()->jobApplications()
            ->with(['jobListing.company'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.index', compact('applications'));
    }
}
