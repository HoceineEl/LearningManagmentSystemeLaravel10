<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;


class LessonController extends Controller
{
    public function show($lesson)
    {
        $lesson = Lesson::findOrFail($lesson);
        $video = $lesson->videos->first();
        $course = $lesson->section->cour;

        $nextLesson = Lesson::where('section_id', $lesson->section_id)->where('position', '>', $lesson->position)->first();
        $previousLesson = Lesson::where('section_id', $lesson->section_id)->where('position', '<', $lesson->position)->orderByDesc('position')->first();

        // If there is no previous lesson in the same section, get the last lesson of the previous section
        if (!$previousLesson) {
            $previousSection = Section::where('cour_id', $lesson->section->cour_id)->where('position', '<', $lesson->section->position)->orderByDesc('position')->first();
            if ($previousSection) {
                $previousLesson = Lesson::where('section_id', $previousSection->id)->orderByDesc('position')->first();
            }
        }

        // If there is no next lesson in the same section, get the first lesson of the next section
        if (!$nextLesson) {
            $nextSection = Section::where('cour_id', $lesson->section->cour_id)->where('position', '>', $lesson->section->position)->orderBy('position')->first();
            if ($nextSection) {
                $nextLesson = Lesson::where('section_id', $nextSection->id)->orderBy('position')->first();
            }
        }

        return view('frontend.lessons.show', compact('lesson', 'video', 'course', 'nextLesson', 'previousLesson'));
    }
}
