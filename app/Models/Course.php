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
        'bg_color',
        'image_path',
        'badge',
    ];
}
