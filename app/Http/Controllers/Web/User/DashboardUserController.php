<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;

class DashboardUserController extends Controller
{
    public function index()
    {
        return view('role.user.DashboardUser');
    }
}