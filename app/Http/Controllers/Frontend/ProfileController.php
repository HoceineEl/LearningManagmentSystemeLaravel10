<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Cour;
use App\Models\CourseProgression;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index()
    { 
        $coursesprogression = CourseProgression::all()->where('user_id', auth()->user()->id);
        foreach($coursesprogression as $progression){
            $nameCour = Cour::find($progression->cour_id)->nom;
            $progression->cour_id = $nameCour;
        }
        $user = auth()->user();
        return view('frontend.profile', compact('user', 'coursesprogression'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function password(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('frontend.profile.index')->with('message', __('global.change_password_success'));
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = auth()->user();

        if ($user->two_factor) {
            $message = __('global.two_factor.disabled');
        } else {
            $message = __('global.two_factor.enabled');
        }

        $user->two_factor = ! $user->two_factor;

        $user->save();

        return redirect()->route('frontend.profile.index')->with('message', $message);
    }
}
