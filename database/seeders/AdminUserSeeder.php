<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' =>'Super Admin',
                'email' =>'admin@admin.com',
                'password'=>Hash::make('password'),
                'role' =>'admin',
                'phone' =>'',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'name' =>'Moiz Chauhdry',
                'email' =>'moizchauhdry@gmail.com',
                'password'=>Hash::make('password'),
                'role' =>'customer',
                'phone' =>'+92-320-4650584',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ]);
    }
}
