<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'quizzes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nom',
        'lecon_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function quizQuizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'id');
    }

    public function quizScoreQuizzes()
    {
        return $this->hasMany(ScoreQuiz::class, 'quiz_id', 'id');
    }

    public function lecon()
    {
        return $this->belongsTo(Lecon::class, 'lecon_id');
    }
}
