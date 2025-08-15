<?php

namespace Database\Seeders;

use App\Traits\PermissionsTrait;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    use PermissionsTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::updateOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);

        $permissions = self::getSuperAdminPermissions();

        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permission = Permission::updateOrCreate([
                    'name' => $permissions[$i]['permissions'][$j],
                    'group_name' => $permissionGroup,
                    'guard_name' => 'admin',
                ]);

                $roleSuperAdmin->givePermissionTo($permission);
            }
        }
    }
}
