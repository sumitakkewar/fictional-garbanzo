<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(100)->create();

        collect([
            "Plumbing",
            "AC Servicing",
            "Cleaning",
            "Car Washing",
            "Laundry",
            "Carpenter",
            "Painting",
            "Construction",
            "Rent Appartment",
            "Buy Appartment",
            "Electronic Repair",
            "Electric Repair",
            "Electric Installation",
            "Driver",
        ])->each(function($service) {
            DB::table("services")->insert([
                "name" => $service,
                "status" => "active",
                "created_at" => now(),
                "updated_at" => now()
            ]);
        });

        // provider
        $provider = User::create([
            'name' => "Provider",
            'email' => "provider@test.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        
        //subscriber
        $subscriber = User::create([
            'name' => "Subscriber",
            'email' => "subscriber@test.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
