<?php

namespace Modules\Option\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Option\Entities\Option;

class OptionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('option.options') as $key => $option) {
            Option::create($option);
        }
    }
}
