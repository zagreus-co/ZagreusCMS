<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index()
    {
        if (!checkGate('manage_users')) return abort(403);

        $users = User::query()
            ->with('role')
            ->latest()
            ->paginate(20);

        return Inertia::render('Panel/Users/Users', compact('users'));
    }

    public function create()
    {
        if (!checkGate('manage_users')) return abort(403);

        return Inertia::render('Panel/Users/Create');
    }

    public function store(Request $request)
    {
        if (!checkGate('manage_users')) return abort(403);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return to_route('panel.users.index');
    }

    public function delete(User $user)
    {
        if (!checkGate('manage_users')) return abort(403);

        $user->delete();

        return to_route('panel.users.index');
    }
}
