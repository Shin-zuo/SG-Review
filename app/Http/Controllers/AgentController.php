<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Mail\AgentWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::with('referrals.course')->latest()->get();
        
        $totalReferralsCount = $agents->sum(fn($agent) => $agent->referrals->count());
        $paidReferralsCount = $agents->sum(fn($agent) => $agent->referrals->where('is_paid', true)->count());
        $totalCommissionsEarned = $agents->sum(fn($agent) => $agent->referrals->where('is_paid', true)->sum('amount') * 0.10);

        return view('pages.agent', compact('agents', 'totalReferralsCount', 'paidReferralsCount', 'totalCommissionsEarned'));
    }

    /**
     * Show the agent registration form page.
     */
    public function showRegistrationForm()
    {
        return view('pages.agents.register');
    }

    /**
     * Store agent registration from the public form and send welcome email.
     */
    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone_number' => 'required|string|max:20',
            'facebook_link' => 'nullable|string|max:255',
            'agent_code' => 'nullable|string|max:50|unique:agents,agent_code',
        ]);

        // If referral code not customized, generate automatically
        if (empty($validated['agent_code'])) {
            $initials = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $validated['name']), 0, 3));
            if (empty($initials)) {
                $initials = 'SGR';
            }
            do {
                $code = $initials . '-' . strtoupper(Str::random(5));
            } while (Agent::where('agent_code', $code)->exists());
            $validated['agent_code'] = $code;
        } else {
            $validated['agent_code'] = strtoupper(trim($validated['agent_code']));
        }

        $validated['address'] = $validated['address'] ?? 'Online Ambassador';

        $agent = Agent::create($validated);

        try {
            Mail::to($agent->email)->send(new AgentWelcomeMail($agent));
        } catch (\Exception $e) {
            Log::error('Agent Welcome Email Failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Congratulations ' . $agent->name . '! Your ambassador registration is complete. We have emailed your official Referral Code (' . $agent->agent_code . ') and 10% commission partnership details to ' . $agent->email . '. Welcome aboard!');
    }

    /**
     * Store a newly created agent manually from the Admin dashboard.
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone_number' => 'required|string|max:20',
            'facebook_link' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'agent_code' => 'nullable|string|max:50|unique:agents,agent_code',
        ]);

        if (empty($validated['agent_code'])) {
            $initials = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $validated['name']), 0, 3));
            if (empty($initials)) {
                $initials = 'SGR';
            }
            do {
                $code = $initials . '-' . strtoupper(Str::random(5));
            } while (Agent::where('agent_code', $code)->exists());
            $validated['agent_code'] = $code;
        } else {
            $validated['agent_code'] = strtoupper(trim($validated['agent_code']));
        }

        $validated['address'] = $validated['address'] ?? 'Admin Added Ambassador';

        Agent::create($validated);

        return redirect()->route('agents')->with('success', 'New agent successfully created!');
    }

    /**
     * Update the specified agent in storage from Admin dashboard.
     */
    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone_number' => 'required|string|max:20',
            'facebook_link' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'agent_code' => 'required|string|max:50|unique:agents,agent_code,' . $agent->id,
        ]);

        $validated['agent_code'] = strtoupper(trim($validated['agent_code']));
        $agent->update($validated);

        return redirect()->route('agents')->with('success', 'Agent details successfully updated!');
    }

    /**
     * Remove the specified agent from storage.
     */
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return redirect()->route('agents')->with('success', 'Agent deleted successfully.');
    }

    /**
     * Store a newly created resource in storage (legacy / fallback).
     */
    public function store(Request $request)
    {
        return $this->storeRegistration($request);
    }
}

