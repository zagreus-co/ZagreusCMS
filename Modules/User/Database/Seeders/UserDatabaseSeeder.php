<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email'=> 'test@zagreus.company',
            'full_name'=> 'Zagreus Admin',
            'role_id'=> 1,
            'password'=> Hash::make('123456789'),
        ]);
    }
}
