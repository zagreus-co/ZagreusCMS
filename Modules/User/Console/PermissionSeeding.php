<?php

namespace Modules\User\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Schema;
use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;

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
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::hasTable('permissions')) {
            $this->error('You have to complete the database migrations first!');
            return 1;
        }
        
        
        $sudo = Role::whereTitle('sudo')->first();
        if (is_null($sudo)) { // Create sudo role if it's not created yet!
            $sudo = Role::create(['title'=> 'sudo']);
        }

        foreach (\Module::getOrdered() as $module) {
            if (!file_exists($module->getExtraPath('module.json'))) continue;

            $config = json_decode(file_get_contents($module->getExtraPath('module.json')));
            if (!isset($config->permissions)) continue;

            foreach($config->permissions as $tag => $title) {
                if (Permission::whereTag($tag)->count() > 0) continue;
                
                $permission = Permission::create(compact('tag', 'title'));
                $sudo->permissions()->attach([$permission->id]);
                $this->info("Permission [$tag] created for module ".$module->getName());
            }
        }

        $this->info("Seeding permissions completed successfully!");
        return 0;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
