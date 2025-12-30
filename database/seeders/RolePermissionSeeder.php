<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Kendaraan permissions
            'view-kendaraan',
            'create-kendaraan',
            'edit-kendaraan',
            'delete-kendaraan',
            
            // Supir permissions
            'view-supir',
            'create-supir',
            'edit-supir',
            'delete-supir',
            
            // Peminjaman permissions
            'view-peminjaman',
            'create-peminjaman',
            'edit-peminjaman',
            'delete-peminjaman',
            'verify-peminjaman',
            'approve-peminjaman',
            'assign-vehicle-driver',
            
            // Surat Tugas permissions
            'view-surat-tugas',
            'create-surat-tugas',
            'download-surat-tugas',
            
            // Settings permissions
            'view-settings',
            'edit-settings',
            
            // Audit Log permissions
            'view-audit-log',
            
            // User management permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Role management permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin role - has all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions(Permission::all());

        // P3B (Kassubag Perlengkapan) role
        $p3bRole = Role::firstOrCreate(['name' => 'P3B']);
        $p3bRole->syncPermissions([
            'view-kendaraan',
            'view-supir',
            'view-peminjaman',
            'verify-peminjaman',
            'assign-vehicle-driver',
            'view-surat-tugas',
            'view-audit-log',
        ]);

        // Pengurus Barang role
        $pengurusBarangRole = Role::firstOrCreate(['name' => 'Pengurus Barang']);
        $pengurusBarangRole->syncPermissions([
            'view-kendaraan',
            'view-supir',
            'view-peminjaman',
            'approve-peminjaman',
            'view-surat-tugas',
            'create-surat-tugas',
            'download-surat-tugas',
            'view-audit-log',
        ]);

        // User (Anggota Dewan) role
        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->syncPermissions([
            'view-kendaraan',
            'view-peminjaman',
            'create-peminjaman',
        ]);

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@ekdosetwan.com'],
            [
                'name' => 'Administrator',
                'phone' => '081234567890',
                'password' => bcrypt('password'),
            ]
        );
        $admin->syncRoles(['Admin']);

        // Create P3B user
        $p3b = User::firstOrCreate(
            ['email' => 'p3b@ekdosetwan.com'],
            [
                'name' => 'Kassubag Perlengkapan',
                'phone' => '081234567891',
                'password' => bcrypt('password'),
            ]
        );
        $p3b->syncRoles(['P3B']);

        // Create Pengurus Barang user
        $pengurusBarang = User::firstOrCreate(
            ['email' => 'pengurus@ekdosetwan.com'],
            [
                'name' => 'Pengurus Barang',
                'phone' => '081234567892',
                'password' => bcrypt('password'),
            ]
        );
        $pengurusBarang->syncRoles(['Pengurus Barang']);

        // Create sample user
        $user = User::firstOrCreate(
            ['email' => 'user@ekdosetwan.com'],
            [
                'name' => 'Anggota Dewan',
                'phone' => '081234567893',
                'password' => bcrypt('password'),
            ]
        );
        $user->syncRoles(['User']);
    }
}
