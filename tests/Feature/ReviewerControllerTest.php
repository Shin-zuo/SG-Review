<?php

namespace Tests\Feature;

use App\Models\Course;
use Tests\TestCase;

class ReviewerControllerTest extends TestCase
{
    public function test_edit_form_displays_existing_modules_and_lessons(): void
    {
        $course = Course::create([
            'title' => 'Civil Engineering',
            'acronym' => 'CELE',
            'description' => 'Board exam reviewer',
            'price' => 5000,
            'enrollment_link' => 'https://example.com',
            'bg_color' => 'blue-600',
        ]);

        $module = $course->modules()->create([
            'module_number' => 1,
            'module_title' => 'Mathematics',
        ]);

        $module->lessons()->create([
            'lesson_number' => 1,
            'lesson_title' => 'Algebra',
        ]);

        $response = $this->get(route('reviewers.edit', $course));

        $response->assertOk();
        $response->assertSee('Mathematics');
        $response->assertSee('Algebra');
    }
}
