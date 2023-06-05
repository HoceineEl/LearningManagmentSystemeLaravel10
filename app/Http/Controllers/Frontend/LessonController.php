<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Lesson;
use App\Models\Section;


class LessonController extends Controller
{

    public function show($lesson)
    {
        $lesson = Lesson::findOrFail($lesson);
        $video = $lesson->videos->first();
        $course = $lesson->section->cour;
        return view('frontend.lessons.show', compact('lesson', 'video','course'));
    }
}
