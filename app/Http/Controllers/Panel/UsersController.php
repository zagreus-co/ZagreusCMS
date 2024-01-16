<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
}
