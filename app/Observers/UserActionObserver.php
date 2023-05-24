<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class UserActionObserver
{
    public function created(User $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'User'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
