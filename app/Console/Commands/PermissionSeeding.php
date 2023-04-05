<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Permission;
use Nwidart\Modules\Facades\Module;

class PermissionSeeding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zagreus:load-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load and insert modules permissions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!Schema::hasTable('permissions')) {
            $this->error('You have to complete the database migrations to execute this command first.');
            return false;
        }

        // load the CMS core permissions from the configuration file. [> /config/permissions.php]
        foreach(config('permissions') as $tag => $title) {
            if ($this->addPermission($tag, $title))
                $this->info("Permission [$tag] created for CMS core");
        }

        // Load the modules permissions [> modules/ModuleName/module.json]
        foreach (Module::getOrdered() as $module) {
            if (!file_exists($module->getExtraPath('module.json'))) continue;

            $config = json_decode(file_get_contents($module->getExtraPath('module.json')), true);
            
            if (!isset($config['permissions'])) continue;

            foreach($config['permissions'] as $tag => $title) {
                if ($this->addPermission($tag, $title))
                    $this->info("Permission [$tag] created for module ".$module->getName());
            }
        }

        $this->info("Seeding permissions completed successfully!");
        return 0;
    }

    protected function addPermission($tag, $title) {
        $sudo = Role::firstOrCreate(['title'=> 'sudo']);
        
        if (Permission::whereTag($tag)->count() > 0) return false;
                
        $permission = Permission::create(compact('tag', 'title'));
        $sudo->permissions()->attach([$permission->id]);
        return true;
    }
}
