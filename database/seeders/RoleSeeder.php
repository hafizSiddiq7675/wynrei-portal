<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $Role = new Role();
        $Role->role = 'SuperAdmin';
        $Role->save();

        $Role = new Role();
        $Role->role = 'Investor';
        $Role->save();

        $Role = new Role();
        $Role->role = 'Agent';
        $Role->save();
    }
}
