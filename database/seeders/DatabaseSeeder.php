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
        \App\Models\Complaint::factory(50)->create();
        \App\Models\Faq::factory(50)->create();
    }
}
