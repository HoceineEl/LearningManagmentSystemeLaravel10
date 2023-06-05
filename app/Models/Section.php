<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes, HasFactory;
    public $table = 'sections';

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
        'cours_id',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }
   
    public function cour()
    {
        return $this->belongsTo(Cour::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
