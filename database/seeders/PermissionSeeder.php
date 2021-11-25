<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPermission;
use App\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name'=>'Manage Admin Users',
                'slug'=>'manage-admin-users',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'name'=>'Manage Registered Users',
                'slug'=>'manage-registered-users',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ]);

        $count = Permission::count();
        for ($i= 1; $i <= $count ; $i++) {
            UserPermission::insert([
                ['user_id'=>'1',
                    'permission_id'=>$i,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
            ]);
        }

    }
}
