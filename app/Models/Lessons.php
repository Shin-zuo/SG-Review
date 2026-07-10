<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modules;

class Lessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'lesson_number',
        'lesson_title',
    ];

    public function module()
    {
        return $this->belongsTo(\App\Models\Modules::class);
    }
}
