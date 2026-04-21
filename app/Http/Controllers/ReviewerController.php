<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB image
        ]);

        // Handle Image Upload Logic
        if ($request->hasFile('image')) {
            // This saves the image to storage/app/public/courses
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set fallback background color if empty
        if (empty($validated['bg_color'])) {
            $validated['bg_color'] = 'blue-600';
        }

        // Create the record in the database!
        Course::create($validated);

        // Redirect back to the table with a SweetAlert success message
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
        ]);

        // 1. Explicit Image Removal Logic
        // If the admin checked the "Remove" box...
        if ($request->has('remove_image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path); // Delete from server
            }
            $validated['image_path'] = null; // Clear the database record so it reverts to color
        }

        // 2. New Image Upload Logic (This overrides the removal checkbox if they do both)
        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image_path'] = $imagePath;
        }

        // 3. Ensure a fallback color exists
        if (empty($validated['bg_color'])) {
            $validated['bg_color'] = 'blue-600';
        }

        // Update the database record
        $course->update($validated);

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
