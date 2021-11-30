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
        // $this->call(TagsTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PageSeeder::class);
        \App\Models\Complaint::factory(15)->create();
        \App\Models\Faq::factory(15)->create();
        \App\Models\Booking::factory(15)->create();
        \App\Models\Category::factory(15)->create();
        \App\Models\Service::factory(50)->create();
        \App\Models\Payment::factory(15)->create();
        \App\Models\Gallery::factory(15)->create();
    }
}
