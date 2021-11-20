<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index(Request $request)
    {   
        if (! checkGate(['view_users', 'manage_users']) ) abort(403);

        if ($request->ajax()) return $this->table();

        if (class_exists('\SEO')) \SEO::setTitle(__('Manage users'));
        return view('panel.users.admin.index');
    }

    
    public function create()
    {
        if (! checkGate('manage_users') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Create user'));
        return view('panel.users.admin.create');
    }

    public function store(Request $request)
    {
        if (! checkGate('manage_users') ) abort(403);

        $request->validate($this->rules());

        if ($request->filled('number')) {
            $request->validate([
                'number'=> ['required', 'numeric', 'unique:users']
            ]);
        }

        User::create([
            'full_name' => $request->full_name,
            'number'=> $request->number,
            'email' => $request->email,
            'role_id'=> $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        alert()->success(__("User created successfully!"));
        return redirect( route('panel.users.index') );
    }

    public function show($id)
    {
        if (! checkGate(['view_users', 'manage_users']) ) abort(403);
        return back();
    }

    public function edit(User $user)
    {
        if (! checkGate('manage_users') ) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Edit user'));
        return view('panel.users.admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (! checkGate('manage_users') ) abort(403);

        $request->validate([
            'full_name'=> ['required', 'string', 'min:3'],
            'email'=> ['required', 'email', Rule::unique('users')->ignore($user, 'email')],
            'role_id'=> ['required', 'numeric'],
        ]);

        if ($request->filled('number')) {
            $request->validate([
                'number'=> ['required', 'numeric', Rule::unique('users')->ignore($user, 'number')]
            ]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:6', 'confirmed'],
            ]);
        }

        $user->update([
            'full_name' => $request->full_name,
            'number'=> $request->number,
            'email' => $request->email,
            'role_id'=> $request->role_id,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        alert()->success(__("User edited successfully!"));
        return redirect( route('panel.users.index') );
    }


    public function destroy(User $user)
    {
        if (! checkGate('manage_users') ) abort(403);
        
        $user->delete();
        alert()->success(__("User deleted successfully!"));
        return back();
    }

    public function loginUsingId(User $user) {
        if (! checkGate('manage_users') ) abort(403);

        auth()->loginUsingId($user->id);

        return redirect(route('index'));
    }

    protected function rules() {
        return [
            'full_name'=> ['required', 'string', 'min:3'],
            'email'=> ['required', 'email', 'unique:users'],
            'role_id'=> ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
