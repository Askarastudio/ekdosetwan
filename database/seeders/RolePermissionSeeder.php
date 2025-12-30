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
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin role - has all permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // P3B (Kassubag Perlengkapan) role
        $p3bRole = Role::create(['name' => 'P3B']);
        $p3bRole->givePermissionTo([
            'view-kendaraan',
            'view-supir',
            'view-peminjaman',
            'verify-peminjaman',
            'assign-vehicle-driver',
            'view-surat-tugas',
            'view-audit-log',
        ]);

        // Pengurus Barang role
        $pengurusBarangRole = Role::create(['name' => 'Pengurus Barang']);
        $pengurusBarangRole->givePermissionTo([
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
        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo([
            'view-kendaraan',
            'view-peminjaman',
            'create-peminjaman',
        ]);

        // Create default admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ekdosetwan.com',
            'phone' => '081234567890',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Create P3B user
        $p3b = User::create([
            'name' => 'Kassubag Perlengkapan',
            'email' => 'p3b@ekdosetwan.com',
            'phone' => '081234567891',
            'password' => bcrypt('password'),
        ]);
        $p3b->assignRole('P3B');

        // Create Pengurus Barang user
        $pengurusBarang = User::create([
            'name' => 'Pengurus Barang',
            'email' => 'pengurus@ekdosetwan.com',
            'phone' => '081234567892',
            'password' => bcrypt('password'),
        ]);
        $pengurusBarang->assignRole('Pengurus Barang');

        // Create sample user
        $user = User::create([
            'name' => 'Anggota Dewan',
            'email' => 'user@ekdosetwan.com',
            'phone' => '081234567893',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('User');
    }
}
