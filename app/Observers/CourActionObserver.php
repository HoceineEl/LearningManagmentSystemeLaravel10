<?php

namespace App\Observers;

use App\Models\Cour;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class CourActionObserver
{
    public function created(Cour $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Cour'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
