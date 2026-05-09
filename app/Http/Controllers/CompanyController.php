<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validate;
use App\Models\User;
use App\Models\Company;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
class CompanyController extends Controller
{
    //
    public function index(Request $request){
        if($request->ajax()){
            $companies = Company::withCount('users')->latest();
            return DataTables::of($companies)
            ->addIndexColumn()
            ->editColumn('name',function($row){
                return $row->name;
            })
            ->editColumn('company_website_url',function($row){
                return '<a href="'.$row->company_website_url.'" target="_blank">'.$row->company_website_url .'</a>';
            })
            ->addColumn('users_count',function($row){
                return $row->users_count;
            })
            ->addColumn('action',function($row){
                return '<div class="btn-group">  <a class="btn btn-primary" href="'.route('companies.edit', $row->id).'"><i class="bi bi-pencil-square fs-5"></i></a></div>';
            })
            ->rawColumns([
                'name','company_website_url','users_count','action'
            ])
            ->make(true);
        }


        return view('companies.index');
    }

    public function create(){
        return view('companies.create');
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name' => 'required|max:255',
                'company_website_url' => 'nullable|url|max:255'
            ]);

            $company = Company::create([
                'name' => $request->name,
                'company_website_url' => $request->company_website_url,
            ]);

             return response()->json([
                        'status' => true,
                        'message' => 'Company created successfully'
                    ]);
        }catch(\Exception $e){
                Log::error('Error: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
        }
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
