<?php

namespace Modules\Analytics\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Analytics\Entities\Rule;

class AnalyticsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Rule::create([
            'name'=> 'disallow_page',
            'data'=> '/panel/*'
        ]);
        Rule::create([
            'name'=> 'disallow_page',
            'data'=> '/livewire/*'
        ]);
        
        // $this->call("OthersTableSeeder");
    }
}
