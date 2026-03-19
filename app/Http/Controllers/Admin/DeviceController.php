<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Called from JavaScript inside the NativePHP WebView after
     * the native layer provides an FCM registration token.
     *
     * Route: POST /admin/device/register-token
     */
    public function registerToken(Request $request)
    {
        $request->validate([
            'token'    => 'required|string|max:512',
            'platform' => 'required|in:android,ios',
        ]);

        // Upsert: update if token exists, create if new
        DeviceToken::updateOrCreate(
            ['token' => $request->token],
            [
                'user_id'      => auth()->id(),
                'platform'     => $request->platform,
                'last_used_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }
}
