<?php

namespace App\Observers;

use App\Models\UserAlert;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class UserAlertActionObserver
{
    public function created(UserAlert $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'UserAlert'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(UserAlert $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'UserAlert'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function deleting(UserAlert $model)
    {
        $data  = ['action' => 'deleted', 'model_name' => 'UserAlert'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
