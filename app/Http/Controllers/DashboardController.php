<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use App\Models\Video;
use App\Models\Enroll;
use App\Models\Lesson;
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
            if (Lesson::find($lesson_id))
                $lessonLabels[$lesson_id] = Lesson::find($lesson_id)->label; // Retrieve the lesson label using the original lesson_id
        }

        $truePercent = [];

        foreach ($lessonCount as $lesson_id => $count) {
            if (isset($lessonLabels[$lesson_id])) {
                $truePercent[$lessonLabels[$lesson_id]] = ($trueCounts[$lesson_id] / $count) * 100;
            }
        }

        $lessonNames = array_keys($lessonCount);

        // Users for the table in the dashboard
        $users = User::all();

        foreach ($users as $user) {
            if (isset($user->roles[0])) {
                $user->role = $user->roles[0]->title;
            }
        }

        //* video
        $videosNumbers = Video::all()->count();
        return view('dashboard', compact('cours', 'users', 'truePercent', 'lessonLabels', 'videosNumbers'));
    }
}
