<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    protected $resetPasswordTypes = ['email'];

    public function register(Request $request) {
        if ($request->method() == 'GET') {
            \SEO::setTitle(__('Register').' - '.get_option('site_short_name'))
                ->setDescription(get_option('site_description'));
            return panelView('register');
        }

        $request->validate([
            'full_name'=> ['required', 'string', 'min:3'],
            'email'=> ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($request->filled('number')) {
            $request->validate([
                'number'=> ['required', 'string', 'unique:users'],
            ]);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'number'=> $request->number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->loginUsingId($user->id);
        alert()->success('ثبت نام در سامانه با موفقیت انجام شد!');
        return redirect( route('module.panel.index') );
    }

    public function login(Request $request) {
        if ($request->method() == 'GET') {
            \SEO::setTitle(__('Login to account').' - '.get_option('site_short_name'))
                ->setDescription(get_option('site_description'));
            return panelView('login');
        }

        $request->validate([
            'email'=> ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        
        $user = User::whereEmail($request->email)->first();
        if (is_null($user)) return $this->responseFaild();

        if (Hash::check($request->password, $user->password)) {
            // The passwords match...
            $request->session()->regenerate();
            auth()->loginUsingId($user->id, $request->filled('remember'));

            return redirect( route('module.panel.index') );
        }
        
        return $this->responseFaild();
    }

    public function forgetPassword($type = 'email') {
        if (!in_array($type, $this->resetPasswordTypes)) return back();

        \SEO::setTitle(__('Forget password').' - '.get_option('site_short_name'));
                
        return panelView('passwords.'.$type);
    }

    public function sendPasswordLink(Request $request, $type = 'email') {
        if ($type == 'email') {
            $request->validate(['email' => 'required|email']);
    
            $status = Password::sendResetLink(
                $request->only('email')
            );
        
            return $status === Password::RESET_LINK_SENT
                        ? back()->with(['status' => __($status)])
                        : back()->withErrors(['email' => __($status)]);
        }
    }

    public function resetPasswordUsingEmail(Request $request, $token) {
        \SEO::setTitle(__('Change password').' - '.get_option('site_short_name')); 
        return panelView('passwords.reset', ['token' => $token]);
    }

    public function updatePasswordUsingEmail(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
        
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(['reset-password'=>__('Your password has been changed successfully! please login again.')]);
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back();
    }

    protected function responseFaild() {
        return back()->withErrors([__('Incorrect username or password.')]);
    }
}
