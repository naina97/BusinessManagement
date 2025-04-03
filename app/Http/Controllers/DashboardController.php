<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,Booking};
class DashboardController extends Controller
{
    public function dashboard()
    {
        $user  = User::all();
        return view('dashboard',compact('user'));
    }
}
