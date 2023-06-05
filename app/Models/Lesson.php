<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Lesson extends Model
{
    use SoftDeletes, HasFactory;


    public $table = 'lessons';

    public static $searchable = [
        'label',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'label',
        'section_id',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lessonQuizzes()
    {
        return $this->hasMany(Quiz::class, 'lesson_id', 'id');
    }

    public function lessonScoreQuizzes()
    {
        return $this->hasMany(ScoreQuiz::class, 'lesson_id', 'id');
    }

    public function lessonProgressions()
    {
        return $this->hasMany(Progression::class, 'lesson_id', 'id');
    }

    public function lessonCommentaires()
    {
        return $this->hasMany(Commentaire::class, 'lesson_id', 'id');
    }

    public function lessonContenus()
    {
        return $this->hasMany(Contenu::class, 'lesson_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function videos()
    {
        return $this->hasMany(LessonVideo::class);
    }
}
