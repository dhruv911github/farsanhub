<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ChangePasswordRequest;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $total_contents = Content::count();

        return view('admin.dashboard', compact('total_contents'));
    }

    // change password
    public function changePassword()
    {
        return view('module.change-password');
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if (Hash::check($validated['current_password'], $user->password)) {
            $user->password = Hash::make($validated['password']);
            $user->save();

            return redirect()->back()->with('success', __('portal.password_changed'));
        }

        return redirect()->back()->withErrors([
            'current_password' => __('portal.current_password_incorrect'),
        ])->withInput($request->only('current_password'));
    }

   
}
