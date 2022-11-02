<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        



        UserRole::truncate();

        $user_role = new UserRole();
        $user_role->user_id = '1';
        $user_role->role_id = '1';
        $user_role->save();

        $user_role = new UserRole();
        $user_role->user_id = '2';
        $user_role->role_id = '2';
        $user_role->save();

        $user_role = new UserRole();
        $user_role->user_id = '3';
        $user_role->role_id = '3';
        $user_role->save();
    }
}
