<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckTwoFactorRequest;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class TwoFactorController extends Controller
{
    public function show()
    {
        abort_if(auth()->user()->two_factor_code === null,
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        return view('auth.twoFactor');
    }

    public function check(CheckTwoFactorRequest $request)
    {
        $user = auth()->user();

        if ($request->input('two_factor_code') == $user->two_factor_code) {
            $user->resetTwoFactorCode();

            $route = (Route::has('frontend.home') && ! $user->is_admin) ? 'frontend.home' : 'admin.home';

            return redirect()->route($route);
        }

        return redirect()->back()->withErrors(['two_factor_code' => __('global.two_factor.does_not_match')]);
    }

    public function resend()
    {
        abort_if(auth()->user()->two_factor_code === null,
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );

        auth()->user()->notify(new TwoFactorCodeNotification());

        return redirect()->back()->with('message', __('global.two_factor.sent_again'));
    }
}
