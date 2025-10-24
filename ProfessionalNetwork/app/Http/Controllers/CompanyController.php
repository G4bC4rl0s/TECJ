<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(12);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function show(Company $company)
    {
        $company->load('jobs');
        $isFollowing = auth()->check() ? $company->isFollowedBy(auth()->id()) : false;
        return view('companies.show', compact('company', 'isFollowing'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y')
        ]);

        $validated['user_id'] = auth()->id();
        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Empresa criada com sucesso!');
    }

    public function follow(Company $company)
    {
        $follow = auth()->user()->follows()->where('company_id', $company->id)->first();
        
        if ($follow) {
            $follow->delete();
            $message = 'Você parou de seguir ' . $company->name;
        } else {
            auth()->user()->follows()->create(['company_id' => $company->id]);
            $message = 'Você agora segue ' . $company->name;
            
            // Criar post de atividade
            Post::create([
                'user_id' => auth()->id(),
                'content' => 'começou a seguir a empresa ' . $company->name,
                'type' => 'company_follow',
                'related_id' => $company->id,
                'related_type' => 'App\\Models\\Company'
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function followed()
    {
        $companies = auth()->user()->followedCompanies()->paginate(12);
        return view('companies.followed', compact('companies'));
    }
}