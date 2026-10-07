<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view loans',
            'manage loans',
            'view users',
            'manage users',
            'manage roles',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $clientRole->syncPermissions(['view loans']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(['view loans', 'manage loans', 'view users']);

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->syncPermissions($permissions);

        // Les comptes par defaut ont change de domaine a chaque rebranding (Aurenza ->
        // Mellenthin Financial -> Aurelis Capital -> fedelispay). Sans ce renommage, le firstOrCreate
        // ci-dessous ne retrouverait pas le compte existant et creerait un SECOND
        // super-admin sur les installations deja en service. Le mot de passe, lui,
        // reste inchange.
        $legacyAccounts = [
            'support@aurenzafinancial.online' => 'support@fedelispay.com',
            'noreply@aurenzafinancial.online' => 'info@fedelispay.com',
            'support@mellenthinfinancial.online' => 'support@fedelispay.com',
            'noreply@mellenthinfinancial.online' => 'info@fedelispay.com',
            'contact@bank.expediva.online'       => 'support@fedelispay.com',
            'support@aureliscapital.de'          => 'support@fedelispay.com',
            'noreply@aureliscapital.de'          => 'info@fedelispay.com',
        ];

        foreach ($legacyAccounts as $oldEmail => $newEmail) {
            if (User::where('email', $newEmail)->exists()) {
                continue;
            }

            $renamed = User::where('email', $oldEmail)->update(['email' => $newEmail]);

            if ($renamed) {
                $this->command?->warn("Compte renomme : {$oldEmail} -> {$newEmail} (mot de passe inchange)");
            }
        }

        // Default super-admin account
        $superAdmin = User::firstOrCreate(
            ['email' => 'support@fedelispay.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('ChangeMe@2025!'),
                'type'     => 'staff',
            ]
        );
        $superAdmin->syncRoles(['super-admin']);

        // Default admin account
        $admin = User::firstOrCreate(
            ['email' => 'info@fedelispay.com'],
            [
                'name'     => 'Admin Aurenza Capital',
                'password' => Hash::make('Admin@2025!'),
                'type'     => 'staff',
            ]
        );
        $admin->syncRoles(['admin']);

        $this->command->info('Roles, permissions and default accounts created.');
        $this->command->table(
            ['Role', 'Email', 'Password (change immediately)'],
            [
                ['super-admin', 'support@fedelispay.com', 'ChangeMe@2025!'],
                ['admin',       'info@fedelispay.com', 'Admin@2025!'],
            ]
        );
    }
}
