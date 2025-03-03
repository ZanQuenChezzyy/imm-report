<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions for users
        $permissions = [
            'View Any User',
            'View User',
            'Create User',
            'Update User',
            'Delete User',
            'Restore User',
            'Force Delete User',

            'View Any Role',
            'View Role',
            'Create Role',
            'Update Role',
            'Delete Role',
            'Restore Role',
            'Force Delete Role',

            'View Any Permission',
            'View Permission',
            'Create Permission',
            'Update Permission',
            'Delete Permission',
            'Restore Permission',
            'Force Delete Permission',

            // Permissions for Company
            'View Any Company',
            'View Company',
            'Create Company',
            'Update Company',
            'Delete Company',
            'Restore Company',
            'Force Delete Company',

            // Permissions for Report Type
            'View Any Report Type',
            'View Report Type',
            'Create Report Type',
            'Update Report Type',
            'Delete Report Type',
            'Restore Report Type',
            'Force Delete Report Type',

            // Permissions for Report
            'View Any Report',
            'View Report',
            'Create Report',
            'Update Report',
            'Delete Report',
            'Restore Report',
            'Force Delete Report',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'Administrator' => [
                'View Any User',
                'View User',
                'Create User',
                'Update User',
                'Delete User',
                'Restore User',
                'Force Delete User',
                'View Any Role',
                'View Role',
                'Create Role',
                'Update Role',
                'Delete Role',
                'Restore Role',
                'Force Delete Role',
                'View Any Permission',
                'View Permission',
                'Create Permission',
                'Update Permission',
                'Delete Permission',
                'Restore Permission',
                'Force Delete Permission',

                // Permissions for Company
                'View Any Company',
                'View Company',
                'Create Company',
                'Update Company',
                'Delete Company',
                'Restore Company',
                'Force Delete Company',

                // Permissions for Report Type
                'View Any Report Type',
                'View Report Type',
                'Create Report Type',
                'Update Report Type',
                'Delete Report Type',
                'Restore Report Type',
                'Force Delete Report Type',

                // Permissions for Report
                'View Any Report',
                'View Report',
                'Create Report',
                'Update Report',
                'Delete Report',
                'Restore Report',
                'Force Delete Report',
            ],
            'Kontraktor' => [
                'View Any Report',
                'View Report',
                'Create Report',
                'Update Report',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }

        // Create users and assign roles
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@starter.com',
                'password' => Hash::make('12345678'),
                'role' => 'Administrator',
                'status' => true,
            ],
            [
                'name' => 'User',
                'email' => 'user@starter.com',
                'password' => Hash::make('12345678'),
                'role' => 'Kontraktor',
                'status' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'status' => $userData['status'],
                ]
            );

            $user->assignRole($userData['role']);
        }

        $this->command->info('Roles, Permissions, dan Users Telah berhasil dibuat!');
    }
}
