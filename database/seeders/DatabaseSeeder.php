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
        $this->call(CategoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PageSeeder::class);
        \App\Models\Complaint::factory(25)->create();
        \App\Models\Faq::factory(25)->create();
        \App\Models\Booking::factory(25)->create();
        \App\Models\Task::factory(25)->create();
        \App\Models\Service::factory(25)->create();
        \App\Models\Payment::factory(25)->create();
    }
}
