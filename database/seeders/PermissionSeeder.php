<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Permission siyahısı.
     */
    public function run(): void
    {
        $permissions = [

            // Restoranlar
            [
                'name' => 'Restoranları gör',
                'slug' => 'view_restaurants',
                'group' => 'restaurants',
            ],

            [
                'name' => 'Restoran yarat',
                'slug' => 'create_restaurants',
                'group' => 'restaurants',
            ],

            [
                'name' => 'Restoran redaktə et',
                'slug' => 'edit_restaurants',
                'group' => 'restaurants',
            ],

            [
                'name' => 'Restoran sil',
                'slug' => 'delete_restaurants',
                'group' => 'restaurants',
            ],

            // Filiallar
            [
                'name' => 'Filialları gör',
                'slug' => 'view_branches',
                'group' => 'branches',
            ],

            [
                'name' => 'Filial yarat',
                'slug' => 'create_branches',
                'group' => 'branches',
            ],

            [
                'name' => 'Filial redaktə et',
                'slug' => 'edit_branches',
                'group' => 'branches',
            ],

            [
                'name' => 'Filial sil',
                'slug' => 'delete_branches',
                'group' => 'branches',
            ],

            // İstifadəçilər
            [
                'name' => 'İstifadəçiləri gör',
                'slug' => 'view_users',
                'group' => 'users',
            ],

            [
                'name' => 'İstifadəçi yarat',
                'slug' => 'create_users',
                'group' => 'users',
            ],

            [
                'name' => 'İstifadəçi redaktə et',
                'slug' => 'edit_users',
                'group' => 'users',
            ],

            [
                'name' => 'İstifadəçi sil',
                'slug' => 'delete_users',
                'group' => 'users',
            ],

            // Paketlər
            [
                'name' => 'Paketləri gör',
                'slug' => 'view_plans',
                'group' => 'plans',
            ],

            [
                'name' => 'Paket yarat',
                'slug' => 'create_plans',
                'group' => 'plans',
            ],

            [
                'name' => 'Paket redaktə et',
                'slug' => 'edit_plans',
                'group' => 'plans',
            ],

            [
                'name' => 'Paket sil',
                'slug' => 'delete_plans',
                'group' => 'plans',
            ],
        ];

        foreach ($permissions as $permission) {

            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
