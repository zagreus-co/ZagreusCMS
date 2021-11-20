<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'=> 1,
            'email'=> 'test@zagreus.company',
            'full_name'=> 'Zagreus Admin',
            'role_id'=> 1,
            'password'=> Hash::make('123456789'),
        ]);
    }
}
