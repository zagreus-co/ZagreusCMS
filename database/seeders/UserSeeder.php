<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['role_id'=> 1],
            [
                'email'=> 'test@zagreus.company',
                'full_name'=> 'Zagreus Admin',
                'password'=> Hash::make('123456789'),
            ]
        );
    }
}
