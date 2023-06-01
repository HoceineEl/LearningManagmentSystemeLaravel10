<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Cour;

class HomeController
{
    use MediaUploadingTrait;

    public function index()
    {
        $courses  = Cour::with(['auteur', 'media'])->get();
    
        return view('frontend.home', compact('courses'));
    }
}
