<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'acronym',
        'description',
        'price',
        'enrollment_link',
        'google_classroom_id',
        'bg_color',
        'image_path',
        'badge',
    ];

    public function modules()
    {
        return $this->hasMany(\App\Models\Modules::class);
    }

    public function students()
    {
        return $this->hasMany(\App\Models\Students::class, 'course_id');
    }
}
