<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;
use Modules\User\Entities\AccessList;

class RolesController extends Controller
{
    public function index()
    {
        if (!checkGate('manage_roles')) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Manage roles'));
        return view('user::roles.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!checkGate('manage_roles')) abort(403);

        if (class_exists('\SEO')) \SEO::setTitle(__('Create role'));
        return view('user::roles.create');
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

        return redirect(route('module.user.roles.index'));
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
        return view('user::roles.edit', compact('role'));
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

        return redirect(route('module.user.roles.index'));
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

    public function LimitAccessView(Request $request, Role $role) {
        if (!checkGate('manage_roles')) abort(403);

        if ($request->method() == 'POST') $this->handleAccessList($request, $role);

        if (class_exists('\SEO')) \SEO::setTitle('مدیریت دسترسی های گروه');
        return view('user::roles.limit', compact('role'));
    }

    protected function handleAccessList(Request $request, Role $role) {
        $request->validate([
            'categories'=> ['array']
        ]);
        
        if ($request->filled('categories')) {
            $role->accessList()->whereAccessableType('Modules\Blog\Entities\Category')->delete();
            foreach($request->categories as $category) {
                $role->accessList()->create([
                    'accessable_id'=> $category,
                    'accessable_type'=> 'Modules\Blog\Entities\Category'
                ]);
            }
        } else { $role->accessList()->whereAccessableType('Modules\Blog\Entities\Category')->delete(); }
        
        alert()->success('تغییرات با موفقیت اعمال شد.');
    }
}
