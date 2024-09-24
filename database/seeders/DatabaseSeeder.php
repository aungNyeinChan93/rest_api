<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // role (1 = user, 2 =admin , 3= superadmin )
        Role::create([
            "name"=>"user",
        ]);
        Role::create([
            "name"=>"admin",
        ]);
        Role::create([
            "name"=>"superadmin",
        ]);

        //--seed
        User::factory()->create();
        User::factory()->admin()->create();
        User::factory()->superadmin()->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     "password"=>Hash::make("password"),
        //     "role_id"=>2
        // ]);
        // User::create([
        //     'name' => 'superadmin',
        //     'email' => 'superadmin@gmail.com',
        //     "password"=>Hash::make("password"),
        //     "role_id"=>3
        // ]);


    }
}
