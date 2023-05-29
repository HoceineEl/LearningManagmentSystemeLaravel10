<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Section;
class SectionController extends Controller
{
    // Create The Section And Store It In The Database with the name inserted
    public function store(Request $request)
    {
        $sectionName = $request->input('sectionName');
        $position = $request->input('position');
        // Create a new section
        $section = new Section();
        $section->label = $sectionName;
        $section->position=$position;
        $section->save();
        // Return the generated section ID
        return response()->json(['sectionId' => $section->id]);
    }


    // Update The Name Of the Section When the Save Buttons is Clicked
    public function update(Request $request, Section $section)
{
    $section->label = $request->input('name');
    $section->save();

    return response()->json(['message' => 'Section updated successfully']);
}
    public function updatePosition(Request $request)
{
        $sectionPositions = $request->all();
        // Loop through the received sectionPositions
        foreach ($sectionPositions as $sectionPosition) {
            $section = Section::findOrFail($sectionPosition['sectionId']);
            $section->position = $sectionPosition['position'];
            $section->save();
        }
        return response()->json(['message' => 'Section positions updated successfully']);
}
}
