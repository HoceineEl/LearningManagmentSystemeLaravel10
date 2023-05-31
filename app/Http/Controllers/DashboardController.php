<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use App\Models\Enroll;

class DashboardController
{
    public function index()
    {
        $cours = Cour::all()->toArray();
        $users = User::all();
        foreach ($users as  $user) {
            $user->role = $user->roles[0]->title;
        }
        return view('dashboard', compact('cours', 'users'));
    }
}
