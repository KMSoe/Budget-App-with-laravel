<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        
        $this->call(IconSeeder::class);

        $roles = [
            ["name" => "user", "value" => 1],
            ["name" => "admin", "value" => 2],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        factory(User::class)->create([
            "name" => "Kaung Myat Soe",
            "email" => "kaungmyatsoe.m192@gmail.com",
            "role_id" => 2,
            "profile" => "avatar.svg",
        ]);

        User::create([
            "name" => "Kaung Myat",
            "email" => "budgetappteam@gmail.com",
            "profile" => "avatar.svg",
        ]);

        User::create([
            "name" => "Kaung Myat",
            "email" => "minkhant.galaxy@gmail.com",
            "profile" => "avatar.svg",
        ]);
      
        $users = User::all();
        foreach ($users as $user) {
            Setting::create([
                "user_id" => $user->id,
            ]);
        }

        $this->call(CategorySeeder::class);
        
    }
}
