<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'path',
        'lesson_id'
    ];
    public function lecon(){
        return $this->belongsTo(Lecon::class);
    }
}
