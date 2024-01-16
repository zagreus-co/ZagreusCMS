<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(config('permissions') as $tag => $title) {
            $this->addPermission($tag, $title);
        }
    }

    protected function addPermission($tag, $title): bool {
        $sudo = Role::firstOrCreate(['title'=> 'sudo']);
        
        if (Permission::whereTag($tag)->count() > 0) return false;
                
        $permission = Permission::create(compact('tag', 'title'));
        $sudo->permissions()->attach([$permission->id]);
        return true;
    }
}
