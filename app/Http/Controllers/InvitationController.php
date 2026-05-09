<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\{Company,User};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendUserInvitationMail;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            $auth = auth()->user();
            $authId = $auth->id;
            if ($auth->hasRole('SuperAdmin')) {
                $invitation_list = Invitation::select('name','email','role','token','accept_status')->get();
            }else{
                $invitation_list = Invitation::select('name','email','role','token','accept_status')->where('invited_by',$authId)->get();
            }

            return DataTables::of($invitation_list)
            ->addIndexColumn()
            ->editColumn('name',function($row){
                return $row->name;
            })
            ->editColumn('email',function($row){
                return $row->email;
            })
            ->editColumn('role',function($row){
                return $row->role;
            })
            ->addColumn('status',function($row){
                $html = '';
                if($row->accept_status != 0){
                    $html = '<span class="badge bg-success">Accepted</span>';
                }else{
                    $html = '<span class="badge bg-warning text-dark">Pending</span>';
                }
                return $html;
            })
            ->addColumn('invitee_url',function($row){
                return url('/accept-invitation/'.$row->token);
            })
            ->addColumn('action',function($row){
                $shareBtn = '';

                        $shareBtn = '<a href="'.url('/accept-invitation/'.$row->token).'" class="btn btn-primary btn-sm" target="_blank">
                                                <i class="bi bi-share fs-5"></i>
                                            </a>';


                return $shareBtn;
            })
            ->rawColumns([
                'name','email','role','status','invitee_url','action'
            ])
            ->make();
        }


        return view('invitation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $auth = auth()->user();

        // getting all list only for superadmin role
        if ($auth->hasRole('SuperAdmin')) {
            $companies = Company::all();

            $roles = ['Admin'];
        }else{
            $companies = Company::where(
                'id',
                $auth->company_id
            )->get();

            $roles = ['Admin', 'Member'];
        }
        return view('invitation.create',compact('companies', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            try {
                    $auth = auth()->user();

                    if ($auth->hasRole('SuperAdmin')) {
                        $request->validate([
                            'name' => 'required|max:255',
                            'email' => 'required|email|unique:users,email',
                            'company_id' => 'required|exists:companies,id',
                            'role' => 'required|in:Admin',
                        ]);
                        $companyId = $request->company_id;
                    } else {
                        $request->validate([
                            'name' => 'required|max:255',
                            'email' => 'required|email|unique:users,email',
                            'company_id' => 'required|exists:companies,id',
                            'role' => 'required|in:Admin,Member',
                        ]);
                        $companyId = $auth->company_id;
                    }
                    $invitee = Invitation::create([
                        'company_id' => $companyId,
                        'name'       => $request->name,
                        'email'      => $request->email,
                        'role'       => $request->role,
                        'token'      => Str::random(10),
                        'invited_by' => $auth->id
                    ]);

                    // send invitation email
                    SendUserInvitationMail::dispatch($invitee);

                    return response()->json([
                        'status' => true,
                        'message' => 'Invitation sent successfully to '. $invitee->email.'<br>'.'<small><b>Note:</b> If you have not received the email, please contact the admin or use the invitation link manually.</small>'
                    ]);

            }catch (\Exception $e) {
                Log::error('Invitation Error: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);

        }
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

    public function accept($token){
        $invitation = Invitation::where('token', $token)
        ->where('accept_status',0)
        ->firstOrFail();

        return view('invitation.accept-invitation', compact('invitation'));
    }

    public function complete(Request $request){
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $invitation = Invitation::where('token', $request->token)
            ->where('accept_status',0)
            ->firstOrFail();

        $user = User::create([
            'company_id' => $invitation->company_id,
            'name' => $invitation->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'invitation_id' => $invitation->id,
            'email_verified_at' => now(),
        ]);


        $user->assignRole($invitation->role);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $invitation->update([
            'accept_status' => 1
        ]);

        return redirect('/login')->with('success', 'Account created successfully');
    }
}
