<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use App\Models\Enroll;

class DashboardController
{
    public function index()
    {
        $users = User::all()->toArray();
        $cours = Cour::all()->toArray();
        return view('dashboard', compact('cours', 'users'));
    }
}
