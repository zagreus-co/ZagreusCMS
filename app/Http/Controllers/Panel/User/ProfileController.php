<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    
    public function index(Request $request) {
        if ($request->method() == 'POST') return $this->handleForm($request);
        if (class_exists('\SEO')) \SEO::setTitle(__('Edit profile'));
        return view('panel.users.profile');
    }
    
    protected function handleForm(Request $request) {
        $request->validate([
            'current_password' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            auth()->user()->update([
                'password'=> Hash::make($request->password)
            ]);

            alert()->success(__('Your account password has been changed successfully!'));
            return back();
        }

        return back()->withErrors(["current_password"=> __('The current password you entered is not correct!')]);
    }
}
