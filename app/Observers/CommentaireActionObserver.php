<?php

namespace App\Observers;

use App\Models\Commentaire;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class CommentaireActionObserver
{
    public function created(Commentaire $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Commentaire'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Commentaire $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Commentaire'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function deleting(Commentaire $model)
    {
        $data  = ['action' => 'deleted', 'model_name' => 'Commentaire'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
