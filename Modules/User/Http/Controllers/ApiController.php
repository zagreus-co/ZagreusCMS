<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'code'=> ['required'],
            'number'=> ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    
        $user = User::whereCountryCode($request->code)->whereNumber($request->number)->first();
        if (is_null($user)) return ['result'=> false, 'message'=> 'ورود نا موفق'];
    
        if (Hash::check($request->password, $user->password)) {
            $user->tokens()->delete();
            $token = $user->createToken('app-token');
            return ['result'=> true, 'token'=> $token->plainTextToken, 'message'=> 'ورود به سامانه با موفقیت انجام شد.'];
        }

        return ['result'=> false, 'message'=> 'ورود نا موفق'];
    }

    public function register(Request $request) {
        $request->validate([
            'first_name'=> ['required', 'string', 'min:3'],
            'last_name'=> ['required', 'string', 'min:2'],
            'code'=> ['required'],
            'number'=> ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($request->filled('email')) {
            $request->validate([
                'email'=> ['email']
            ]);
        }

        $user = User::create([
            'full_name' => $request->first_name.' '.$request->last_name,
            'country_code'=> $request->code,
            'number'=> $request->number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->tokens()->delete();
        $token = $user->createToken('app-token');
        return ['result'=> true, 'token'=> $token->plainTextToken, 'message'=> 'ثبت نام در سامانه با موفقیت انجام شد.'];
    }
}
