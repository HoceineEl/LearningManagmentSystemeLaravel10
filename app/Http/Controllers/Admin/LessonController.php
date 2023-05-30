<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Lesson;
use App\Models\Section;


class LessonController extends Controller
{

    // Display The section And their Current Lessons
    public function index()
{
    $lessons = Lesson::orderBy('position')->get()->groupBy('section_id');
    $sections = Section::orderBy('position')->get();
    
    return view('admin.lessons.index', ['lessons' => $lessons, 'sections' => $sections]);
    // return view('admin.lessons.index');
}


    //stores the lesson with the inserted value
    public function store(Request $request)
    {
        $lessonName = $request->input('lessonName');
        $sectionId = $request->input('sectionId');
        $position = $request->input('position');

        // Create a new lesson
        $lesson = new Lesson();
        $lesson->label = $lessonName;
        $lesson->section_id = $sectionId; // Assuming the column name in the lessons table is 'section_id'
        $lesson->position=$position;
        $lesson->save();

        // Return a success response
        return response()->json(['lessonId' => $lesson->id]);
    }


    // Update the Lesson Name with another one iserted by the user 
    public function update(Request $request, Lesson $lesson)
    {
        $lesson->label = $request->input('name');
        $lesson->save();
    
        return response()->json(['message' => 'Lesson updated successfully']);
    }


    // Update the Position And the Section_id of the lesson when it's dragged and dropped
    public function updatePosition(Request $request)
    {
        $lessonPositions = $request->all();        
        // Loop through the received lessonPositions  
        foreach ($lessonPositions as $lessonPosition) {
            $lesson = Lesson::findOrFail($lessonPosition['lessonId']);
            $lesson->position = $lessonPosition['position'];
            $lesson->section_id = $lessonPosition['sectionId'];
            $lesson->save();
        }

        return response()->json(['message' => 'Lesson positions updated hssd successfully']);
  
    }
}
