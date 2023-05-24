<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalFields extends Migration
{
    public function up()
    {
        App\Models\User::all()->each(function (App\Models\User $user) {
            $user->update([
                'approved' => true,
            ]);
        });
    }
}
