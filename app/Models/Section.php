<?php

namespace App\Models;

use DateTimeInterface;
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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sectionLecons()
    {
        return $this->hasMany(Lecon::class, 'section_id', 'id');
    }

    public function cours()
    {
        return $this->belongsTo(Cour::class, 'cours_id');
    }
}
