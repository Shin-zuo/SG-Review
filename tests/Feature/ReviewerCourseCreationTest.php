<?php

use App\Models\Course;
use App\Models\Lessons;
use App\Models\Modules;
use App\Models\User;

describe('reviewer course creation', function () {
    it('stores modules and lessons when creating a course', function () {
        $admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin-user-' . uniqid(),
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('reviewers.store'), [
            'title' => 'Civil Engineering',
            'acronym' => 'CE',
            'description' => 'Board exam review for civil engineering.',
            'price' => 5000,
            'enrollment_link' => 'https://example.com/enroll',
            'bg_color' => 'blue-600',
            'modules' => [
                [
                    'module_number' => 1,
                    'module_title' => 'Mathematics',
                    'lessons' => [
                        ['lesson_number' => 1, 'lesson_title' => 'Algebra'],
                        ['lesson_number' => 2, 'lesson_title' => 'Geometry'],
                    ],
                ],
                [
                    'module_number' => 2,
                    'module_title' => 'Surveying',
                    'lessons' => [
                        ['lesson_number' => 1, 'lesson_title' => 'Fieldwork'],
                    ],
                ],
            ],
        ]);

        $response->assertRedirect(route('reviewers'));

        $course = Course::where('title', 'Civil Engineering')->firstOrFail();
        $this->assertCount(2, $course->modules);

        $mathematics = $course->modules->firstWhere('module_title', 'Mathematics');
        $this->assertNotNull($mathematics);
        $this->assertCount(2, $mathematics->lessons);
        $this->assertEquals('Algebra', $mathematics->lessons->first()->lesson_title);
    });
});
