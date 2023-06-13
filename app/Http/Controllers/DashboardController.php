<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use App\Models\Enroll;
use App\Models\Lesson;
use App\Models\LessonVideo;
use App\Models\Progression;
use App\Http\Controllers\Admin\LessonController;
use App\Models\CourseProgression;
use PHPUnit\TextUI\Configuration\FilterDirectory;

class DashboardController
{
    public function index()
    {
        //* cours array
        $cours = Cour::all()->toArray();


        //* progressions percentage
        $progressions = CourseProgression::all()->toArray();
        $courCount = [];
        $trueCounts = [];
        $coursLabels = []; // Create an array to store lesson labels
        
        foreach ($progressions as $progression) {
            $cour_id = $progression['cour_id'];
            $bool = $progression['est_complete'];
            
            if (!isset($courCount[$cour_id])) {
                $courCount[$cour_id] = 0;
                $trueCounts[$cour_id] = 0;
            }
            
            $courCount[$cour_id]++;
            if ($bool) {
                $trueCounts[$cour_id]++;
            }
        }
        foreach ($courCount as $cour_id => $count) {
            if (Cour::find($cour_id))
            $coursLabels[$cour_id] = Cour::find($cour_id)->nom; // Retrieve the cour label using the original cour_id
        }
        
        if(sizeof($courCount) > 10){
            arsort($courCount);
            $courCount = array_slice($courCount, 0, 10, true);
        }
        
        $truePercent = [];
        
        foreach ($courCount as $cour_id => $count) {
            if (isset($coursLabels[$cour_id])) {
                $truePercent[$coursLabels[$cour_id]] = ($trueCounts[$cour_id] / $count) * 100;
            }
        }
        // Users for the table in the dashboard
        $users = User::all();
        
        foreach ($users as $user) {
            if (isset($user->roles[0])) {
                $user->role = $user->roles[0]->id;
            }
        }
        //* video
        $videosNumbers = LessonVideo::all()->count();
        return view('dashboard', compact('cours', 'users', 'truePercent', 'videosNumbers'));
    }
}
