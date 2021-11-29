<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Faker\Provider\Lorem;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::insert([
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'description' => Lorem::paragraphs(3,true),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'description' => Lorem::paragraphs(5,true),
            ],

        ]);
    }
}
