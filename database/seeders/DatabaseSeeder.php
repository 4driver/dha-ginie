<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
        // \App\Models\User::factory(15)->create();
        \App\Models\Category::factory(15)->create();
        \App\Models\Service::factory(50)->create();
        \App\Models\Booking::factory(15)->create();
        \App\Models\Payment::factory(15)->create();
        \App\Models\Gallery::factory(15)->create();
        \App\Models\Faq::factory(15)->create();
        \App\Models\Complaint::factory(15)->create();
        \App\Models\Package::factory(5)->create();
        $this->call(PageSeeder::class);
    }
}
