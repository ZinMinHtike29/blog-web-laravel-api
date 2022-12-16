<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\WebsiteVisitCount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("zinminhtike"),
            "role" => "admin"
        ]);
        User::create([
            "name" => "user",
            "email" => "user@gmail.com",
            "password" => Hash::make("zinminhtike"),
            "role" => "user"
        ]);

        WebsiteVisitCount::create([
            "visit_count" => 0
        ]);
    }
}