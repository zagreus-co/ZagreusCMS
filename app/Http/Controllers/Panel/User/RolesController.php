<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class RolesController extends Controller
{
    public function index()
    {
        if (!checkGate('manage_roles')) abort(403);

        if (class_exists('\SEO')) SEOTools::setTitle(__('Manage roles'));

        $roles = Role::with('permissions')->latest()->get();
        return view('panel.users.admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!checkGate('manage_roles')) abort(403);

        if (class_exists('\SEO')) SEOMeta::setTitle(__('Create role'));
        return view('panel.users.admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (!checkGate('manage_roles')) abort(403);

        $request->validate([
            'title'=> ['required', 'string'],
            'permissions'=> ['required', 'array']
        ]);
        
        $role = Role::create([
            'title'=> $request->title
        ]);
        $role->permissions()->sync($request->permissions);

        return redirect(route('panel.roles.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (!checkGate('manage_roles')) abort(403);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role)
    {
        if (!checkGate('manage_roles')) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Edit role'));
        return view('panel.users.admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Role $role)
    {
        if (!checkGate('manage_roles')) abort(403);

        $request->validate([
            'title'=> ['required', 'string'],
            'permissions'=> ['required', 'array']
        ]);
        
        $role->update([
            'title'=> $request->title
        ]);
        $role->permissions()->sync($request->permissions);

        return redirect(route('panel.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Role $role)
    {
        if (!checkGate('manage_roles')) abort(403);

        $role->delete();
        return true;
    }
}
