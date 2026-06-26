<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Models\Agent;
use App\Models\Course;
use App\Models\Modules;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $courses = Course::with('modules.lessons')->get();

        return view('pages.landing', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAgent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'agent_code' => 'required|string|max:50|unique:agents,agent_code',
        ]);

        // Create a new agent using the validated data
        Agent::create($validated);

        // Return a response or redirect as needed
        return redirect()->back()->with('success', 'Thank you, you are now and official agent!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
