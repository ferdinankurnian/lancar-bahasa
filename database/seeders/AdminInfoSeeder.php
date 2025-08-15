<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        if (! Admin::first()) {
            $admin = new Admin();
            $admin->name = 'John Doe';
            $admin->email = 'admin@gmail.com';
            $admin->image = 'uploads/website-images/admin.jpg';
            $admin->password = Hash::make(1234);
            $admin->status = 'active';
            $admin->save();

            $role = Role::first();
            $admin?->assignRole($role);
        }
    }
}
