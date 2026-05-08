<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
class DashboardController extends Controller
{
    //

    public function index(){
        return 1;
    }

    public function dashboard(){
        $companyCount = Company::count();
        return view('dashboard',compact('companyCount'));
    }
}
