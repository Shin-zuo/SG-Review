<?php

namespace App\Http\Controllers;

use App\Services\GoogleClassroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleOAuthController extends Controller
{
    /**
     * Redirect Admin to Google OAuth Consent screen to authorize Classroom access.
     */
    public function redirect(GoogleClassroomService $service)
    {
        $authUrl = $service->getAuthUrl();
        return redirect()->away($authUrl);
    }

    /**
     * Handle OAuth Callback from Google and display Refresh Token.
     */
    public function callback(Request $request, GoogleClassroomService $service)
    {
        if ($request->has('error')) {
            $errorMsg = $request->query('error_description', $request->query('error'));
            return response()->view('errors.400', ['message' => "Google returned an error: {$errorMsg}"], 400);
        }

        $code = $request->query('code');

        if (!$code) {
            return response()->view('errors.400', ['message' => 'Missing authorization code from Google. Please initiate authorization from http://localhost:8090/admin/google/auth first.'], 400);
        }

        try {
            $tokenData = $service->handleCallback($code);
            $refreshToken = $tokenData['refresh_token'] ?? null;
            $accessToken = $tokenData['access_token'] ?? null;

            return view('pages.admin.google_token', compact('refreshToken', 'accessToken', 'tokenData'));
        } catch (\Exception $e) {
            Log::error("Google OAuth Callback Error: " . $e->getMessage());
            return response()->view('errors.500', ['message' => 'Failed to exchange token: ' . $e->getMessage()], 500);
        }
    }
}
