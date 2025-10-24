<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\JobListing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->take(10)->get();
        $recentJobs = JobListing::with('company')->where('is_active', true)->latest()->take(5)->get();

        return view('home', compact('posts', 'recentJobs'));
    }
}