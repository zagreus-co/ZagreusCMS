<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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

    public function register()
    {
        \SEO::setTitle(__('Register') . ' - ' . get_option('site_short_name'))
            ->setDescription(get_option('site_description'));
        return panelView('register');
    }

    public function doRegister(RegisterRequest $validatedRequest)
    {
        $user = User::create([
            'full_name' => $validatedRequest->full_name,
            'number' => $validatedRequest->number,
            'email' => $validatedRequest->email,
            'password' => Hash::make($validatedRequest->password),
        ]);
        auth()->loginUsingId($user->id);
        alert()->success('ثبت نام در سامانه با موفقیت انجام شد!');
        return redirect(route('panel.index'));
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            \SEO::setTitle(__('Login to account') . ' - ' . get_option('site_short_name'))
                ->setDescription(get_option('site_description'));
            return panelView('login');
        }

        $validator = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::whereEmail($validator['email'])->first();
        if (is_null($user)) return $this->responseFaild();

        if (Hash::check($validator['password'], $user->password)) {
            // The passwords match...
            $request->session()->regenerate();
            auth()->loginUsingId($user->id, $request->filled('remember'));

            return redirect(route('panel.index'));
        }

        return $this->responseFaild();
    }

    public function forgetPassword($type = 'email')
    {
        if (!in_array($type, $this->resetPasswordTypes)) return back();

        \SEO::setTitle(__('Forget password') . ' - ' . get_option('site_short_name'));

        return panelView('passwords.' . $type);
    }

    public function sendPasswordLink(Request $request, $type = 'email')
    {
        if ($type == 'email') {
            $validator = $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                [
                    'email' => $validator['email']
                ]
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        }
    }

    public function resetPasswordUsingEmail(Request $request, $token)
    {
        \SEO::setTitle(__('Change password') . ' - ' . get_option('site_short_name'));
        return panelView('passwords.reset', ['token' => $token]);
    }

    public function updatePasswordUsingEmail(Request $request)
    {
        $validator =$request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $validator['email'],
                'password' => $validator['password'],
                'password_confirmation' => $validator['password'],
                'token' => $validator['token']
            ],
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(['reset-password' => __('Your password has been changed successfully! please login again.')]);
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back();
    }

    protected function responseFaild()
    {
        return back()->withErrors([__('Incorrect username or password.')]);
    }
}
