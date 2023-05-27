<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecon extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'lecons';

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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function leconQuizzes()
    {
        return $this->hasMany(Quiz::class, 'lecon_id', 'id');
    }

    public function leconScoreQuizzes()
    {
        return $this->hasMany(ScoreQuiz::class, 'lecon_id', 'id');
    }

    public function leconProgressions()
    {
        return $this->hasMany(Progression::class, 'lecon_id', 'id');
    }

    public function leconCommentaires()
    {
        return $this->hasMany(Commentaire::class, 'lecon_id', 'id');
    }

    public function leconContenus()
    {
        return $this->hasMany(Contenu::class, 'lecon_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function lessonVideos(){
        return $this->hasMany(LessonVideo::class, 'lecon_id', 'id');
    }
}
