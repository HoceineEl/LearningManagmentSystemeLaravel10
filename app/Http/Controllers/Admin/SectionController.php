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
        $cour = $request->input('courId');
        // Create a new section
        $section = new Section();
        $section->label = $sectionName;
        $section->position=$position;
        $section->cour_id=$cour;
        $section->save();
        // Return the generated section ID
        return response()->json(['sectionId' => $section->id]);
    }

    // public function storeEx(Request $request)
    // {
      
    //     $sectionName = $request->sectionName;
    //     $position = $request->position;
    //     // Create a new section
    //     $section = new Section();
    //     $section->label = $sectionName;
    //     $section->position=$position;
    //     $section->cour_id=1;
    //     $section->save();
    //     dd($section);
    //     // Return the generated section ID
    //     return redirect('section.index');
    // }

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
    public function edit($id){
        $sections=Section::all();
        $one=Section::find($id);
        $data=[
            'sections'=>$sections,
            'sec'=>$one,
        ];
    return view('admin.lessons.edit',$data);
    }

    public function delete(Section $section){
        if(!$section){
            return response()->json(['message'=>'Section Not Found']);
        }
        $section->delete();
        return response()->json(['message'=>'Section is Deleted Successfully']);

    }
}
