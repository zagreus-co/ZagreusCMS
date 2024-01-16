<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        User::firstOrCreate(
            ['role_id' => Role::where('title', 'sudo')->first()->id],
            [
                'email' => 'test@zagreus.company',
                'first_name' => 'Zagreus',
                'password' => Hash::make('123456789'),
            ]
        );

        $this->call([
            // 
        ]);
    }
}
