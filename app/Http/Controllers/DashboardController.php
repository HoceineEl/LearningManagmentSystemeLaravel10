<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Enroll;

class DashboardController
{
    public function index()
    {
        $cours = Cour::all()->toArray();
        return view('dashboard', compact('cours'));
    }
}
