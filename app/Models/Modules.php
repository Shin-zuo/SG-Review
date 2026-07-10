<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Lessons;

class Modules extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'module_number',
        'module_title',
    ];

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\Lessons::class, 'module_id');
    }
}
