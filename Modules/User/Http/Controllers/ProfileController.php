<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    
    public function index(Request $request) {
        if ($request->method() == 'POST') return $this->handleForm($request);
        if (class_exists('\SEO')) \SEO::setTitle('پروفایل کاربری');
        return view('user::profile');
    }
    
    protected function handleForm(Request $request) {
        $request->validate([
            'current_password' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
            auth()->user()->update([
                'password'=> Hash::make($request->password)
            ]);

            alert()->success('رمز عبور شما با موفقیت ویرایش شد.');
            return back();
        }

        return back()->withErrors(['رمزعبور وارد شده معتبر نمیباشد.']);
    }
}
