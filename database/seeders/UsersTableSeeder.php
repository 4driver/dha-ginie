<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert(
        [
            'name' =>'Super Admin',
            'email' =>'admin@admin.com',
            'password'=>Hash::make('password'),
            'type' =>'admin',
            'phone' =>'',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ],
        [
            'name' =>'Moiz Chauhdry',
            'email' =>'moizchauhdry@gmail.com',
            'password'=>Hash::make('password'),
            'type' =>'user',
            'phone' =>'+92-320-4650584',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ],
        [
            'name' =>'Vendor John',
            'email' =>'vendor@vendor.com',
            'password'=>Hash::make('password'),
            'type' =>'vendor',
            'phone' =>'+92-320-4650584',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]
    );


    }
}
