<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('role.admin.DashboardAdmin');
    }
}
