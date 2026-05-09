<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Company,Invitation,ShortUrl};
class DashboardController extends Controller
{
    //

    public function index(){
        //
        $auth = auth()->user();
        $authId = auth()->user()->id;

        $companyCount = Company::count();

        if($auth->hasRole('SuperAdmin')){
             $totalInvitedUsrs = Invitation::count();
             $totalShortUrls = ShortUrl::count();
        }elseif($auth->hasRole('Admin')) {

             $authId = auth()->user()->id;
             $totalInvitedUsrs = Invitation::where('invited_by',$authId)->count();

             $companyId = auth()->user()->company_id;
             $totalShortUrls = ShortUrl::where('company_id',$companyId)->count();

        }else{
            $totalInvitedUsrs = 0;
            $companyId = auth()->user()->company_id;
            $totalShortUrls = ShortUrl::where('company_id',$companyId)->where('user_id',$authId)->count();
        }



        return view('dashboard',compact('companyCount','totalInvitedUsrs','totalShortUrls'));

    }

    public function dashboard(){
          }
}
