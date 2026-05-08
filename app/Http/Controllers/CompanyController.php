<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validate;
use App\Models\User;
use App\Models\Company;
use DB;
class CompanyController extends Controller
{
    //
    public function index(){
        $companies = Company::withCount('users')->latest()->paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create(){
        return view('companies.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'company_website_url' => 'nullable|url|max:255'
        ]);

        $company = Company::create([
            'name' => $request->name,
            'company_website_url' => $request->company_website_url,
        ]);
        return redirect()->route('companies.create')->with('success','Company created successfully');
    }


    public function edit(Company $company)
        {
            return view('companies.edit', compact('company'));
        }

        public function update(Request $request, Company $company)
        {
            $request->validate([
                'name' => 'required|max:255',
                'company_website_url' => 'nullable|url|max:255',
            ]);
        
            $company->update([
                'name' => $request->name,
                'company_website_url' => $request->company_website_url,
            ]);
        
            return redirect()
                ->route('companies.index')
                ->with('success', 'Company updated successfully');
        }
}
