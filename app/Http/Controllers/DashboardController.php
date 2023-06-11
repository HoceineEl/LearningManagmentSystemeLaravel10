<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use App\Models\Enroll;
use App\Models\Lesson;
use App\Models\LessonVideo;
use App\Models\Progression;
use App\Http\Controllers\Admin\LessonController;
use PHPUnit\TextUI\Configuration\FilterDirectory;

class DashboardController
{
    public function index()
    {
        //* cours array
        $cours = Cour::all()->toArray();


        //* progressions percentage
        $progressions = Progression::all()->toArray();

        $lessonCount = [];
        $trueCounts = [];
        $lessonLabels = []; // Create an array to store lesson labels

        foreach ($progressions as $progression) {
            $lesson_id = $progression['lesson_id'];
            $bool = $progression['est_complete'];

            if (!isset($lessonCount[$lesson_id])) {
                $lessonCount[$lesson_id] = 0;
                $trueCounts[$lesson_id] = 0;
            }

            $lessonCount[$lesson_id]++;
            if ($bool) {
                $trueCounts[$lesson_id]++;
            }
        }

        foreach ($lessonCount as $lesson_id => $count) {
            $lessonLabels[$lesson_id] = Lesson::find($lesson_id)->label; // Retrieve the lesson label using the original lesson_id
        }

        $truePercent = [];

        foreach ($lessonCount as $lesson_id => $count) {
            $truePercent[$lessonLabels[$lesson_id]] = ($trueCounts[$lesson_id] / $count) * 100; // Use the lesson label as the key instead of the lesson_id
        }
        $lessonNames = array_keys($lessonCount);

        //* users for the table in the dashboard
        $users = User::all();
        foreach ($users as  $user) {
            $user->role = $user->roles[0]->title;
        }
        //* video
        $videosNumbers = LessonVideo::all()->count();
        return view('dashboard', compact('cours', 'users', 'truePercent', 'lessonLabels', 'videosNumbers'));
    }
}
