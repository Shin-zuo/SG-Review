<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lessons;
use App\Models\Modules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::latest()->get();

        return view('pages.reviewer', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reviewers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'acronym' => 'required|string|max:50',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'enrollment_link' => 'required|url',
            'bg_color' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'modules' => 'nullable|array',
            'modules.*.module_number' => 'nullable|integer',
            'modules.*.module_title' => 'nullable|string|max:255',
            'modules.*.lessons' => 'nullable|array',
            'modules.*.lessons.*.lesson_number' => 'nullable|integer',
            'modules.*.lessons.*.lesson_title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image_path'] = $imagePath;
        }

        if (empty($validated['bg_color'])) {
            $validated['bg_color'] = 'blue-600';
        }

        DB::transaction(function () use ($validated, $request) {
            $course = Course::create($validated);
            $modules = $request->input('modules', []);

            foreach ($modules as $moduleData) {
                if (empty($moduleData['module_title']) && empty($moduleData['module_number'])) {
                    continue;
                }

                $module = $course->modules()->create([
                    'module_number' => $moduleData['module_number'] ?? null,
                    'module_title' => $moduleData['module_title'] ?? null,
                ]);

                foreach ($moduleData['lessons'] ?? [] as $lessonData) {
                    if (empty($lessonData['lesson_title']) && empty($lessonData['lesson_number'])) {
                        continue;
                    }

                    $module->lessons()->create([
                        'lesson_number' => $lessonData['lesson_number'] ?? null,
                        'lesson_title' => $lessonData['lesson_title'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('reviewers')->with('success', 'Reviewer course added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {// Fetch the specific course
        $course = Course::findOrFail($id);

        // Pass the $course variable directly to the edit view
        return view('reviewers.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'acronym' => 'required|string|max:50',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'enrollment_link' => 'required|url',
            'bg_color' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'modules' => 'nullable|array',
            'modules.*.module_number' => 'nullable|integer',
            'modules.*.module_title' => 'nullable|string|max:255',
            'modules.*.lessons' => 'nullable|array',
            'modules.*.lessons.*.lesson_number' => 'nullable|integer',
            'modules.*.lessons.*.lesson_title' => 'nullable|string|max:255',
        ]);

        if ($request->has('remove_image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image_path'] = $imagePath;
        }

        if (empty($validated['bg_color'])) {
            $validated['bg_color'] = 'blue-600';
        }

        DB::transaction(function () use ($course, $validated, $request) {
            $course->update($validated);

            $course->modules()->delete();

            foreach ($request->input('modules', []) as $moduleData) {
                if (empty($moduleData['module_title']) && empty($moduleData['module_number'])) {
                    continue;
                }

                $module = $course->modules()->create([
                    'module_number' => $moduleData['module_number'] ?? null,
                    'module_title' => $moduleData['module_title'] ?? null,
                ]);

                foreach ($moduleData['lessons'] ?? [] as $lessonData) {
                    if (empty($lessonData['lesson_title']) && empty($lessonData['lesson_number'])) {
                        continue;
                    }

                    $module->lessons()->create([
                        'lesson_number' => $lessonData['lesson_number'] ?? null,
                        'lesson_title' => $lessonData['lesson_title'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('reviewers')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        // Delete the associated image if it exists
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }

        // Delete the course record
        $course->delete();

        return redirect()->route('reviewers')->with('success', 'Course deleted successfully!');
    }
}
