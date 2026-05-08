<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialMail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $authUser = auth()->user();

        // getting all list only for superadmin role
        if ($authUser->hasRole('SuperAdmin')) {
            $companies = Company::all();

            $roles = ['Admin'];
        }else{
            $companies = Company::where(
                'id',
                $authUser->company_id
            )->get();

            $roles = ['Admin', 'Member'];
        }
        return view('users.create',compact('companies', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $authUser = auth()->user();

                if ($authUser->hasRole('SuperAdmin')) {
                    $request->validate([
                        'name' => 'required|max:255',
                        'email' => 'required|email|unique:users,email',
                        'company_id' => 'required|exists:companies,id',
                        'role' => 'required|in:Admin',
                    ]);
                    $companyId = $request->company_id;
                }
                else{
                    $request->validate([
                        'name' => 'required|max:255',
                        'email' => 'required|email|unique:users,email',
                        'role' => 'required|in:Admin,Member',
                    ]);
                    $companyId = $authUser->company_id;
                }
        
                $plainPassword = Str::random(10);
        
                $user = User::create([
        
                    'company_id' => $companyId,
        
                    'name' => $request->name,
        
                    'email' => $request->email,
        
                    'password' => Hash::make($plainPassword),
        
                    'email_verified_at' => now(),
                ]);
                $user->assignRole($request->role);
                
                Mail::to($user->email)->send(new UserCredentialMail($user,$plainPassword));
        
                return redirect()->route('users.create')->with('success','User created successfully');      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
  

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
