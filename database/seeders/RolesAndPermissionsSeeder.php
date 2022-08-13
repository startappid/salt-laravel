<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $structures = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        /**
         * NOTE:
         * Permissions Patterns
         * --- *.*.* ---
         * first * it means table or page name
         * second * it means event
         * last * optional as detail information
         *
         * Example:
         * users.create.role:user
         * the permission pattern above, user only has permission on users table
         * on event create or insert new data, with type role is user
        */

        $permissions = [
            ['name' => '*.*.*'],          // Superadministrator permissions
            ['name' => '*.create.*'],     // Create and Store data
            ['name' => '*.read.*'],       // Read List and Detail data
            ['name' => '*.update.*'],     // Update/Patch data
            ['name' => '*.restore.*'],    // Restore data from Trash
            ['name' => '*.destroy.*'],    // Soft Delete data
            ['name' => '*.trash.*'],      // Read Trashed data and detail
            ['name' => '*.delete.*'],     // Hard Delete from trash
            ['name' => '*.empty.*'],      // Empty all data in trash
            ['name' => '*.import.*'],     // Import data to Database
            ['name' => '*.export.*'],     // Export data to CSV, Excel, JSON, XML, PDF, etc
            ['name' => '*.report.*'],     // Report
            ['name' => '*.page.*'],       // Page menu navigation
        ];

        foreach ($structures as $key => $table) {
            // create permissions
            $permissions[] = ['name' => $table.'.create.*'];
            $permissions[] = ['name' => $table.'.read.*'];
            $permissions[] = ['name' => $table.'.update.*'];
            $permissions[] = ['name' => $table.'.restore.*'];
            $permissions[] = ['name' => $table.'.destroy.*'];
            $permissions[] = ['name' => $table.'.delete.*'];
            $permissions[] = ['name' => $table.'.trash.*'];
            $permissions[] = ['name' => $table.'.empty.*'];
            $permissions[] = ['name' => $table.'.import.*'];
            $permissions[] = ['name' => $table.'.export.*'];
            $permissions[] = ['name' => $table.'.report.*'];

            // NOTE: *.*.id should be their (user) own data
            $permissions[] = ['name' => $table.'.create.id'];
            $permissions[] = ['name' => $table.'.read.id'];
            $permissions[] = ['name' => $table.'.update.id'];
            $permissions[] = ['name' => $table.'.restore.id'];
            $permissions[] = ['name' => $table.'.destroy.id'];
            $permissions[] = ['name' => $table.'.delete.id'];
            $permissions[] = ['name' => $table.'.trash.id'];
            $permissions[] = ['name' => $table.'.empty.id'];
            $permissions[] = ['name' => $table.'.import.id'];
            $permissions[] = ['name' => $table.'.export.id'];
            $permissions[] = ['name' => $table.'.report.id'];

            $permissions[] = ['name' => $table.'.page.*'];
            $permissions[] = ['name' => $table.'.*.*']; // all permission only for this model
        }

        $permissions[] = ['name' => 'users.account.activate'];
        $permissions[] = ['name' => 'users.account.deactivate'];
        $permissions = collect($permissions)->map(function ($permission) {
            return array_merge($permission, ['guard_name' => 'web']);
        });
        Permission::insert($permissions->toArray());

        // create roles and assign created permissions
        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo(['*.*.*']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'operator']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'reporter']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'hrd']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'author']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'drafter']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $user = User::where('username', 'superadmin')->first();
        $user->assignRole('superadmin');
        $user = User::where('username', 'admin')->first();
        $user->assignRole('admin');
        $user = User::where('email', 'hrd@startapp.id')->first();
        $user->assignRole('hrd');
        $user = User::where('email', 'manager@startapp.id')->first();
        $user->assignRole('manager');
        $user = User::where('email', 'reporter@startapp.id')->first();
        $user->assignRole('reporter');
        $user = User::where('email', 'operator@startapp.id')->first();
        $user->assignRole('operator');
    }
}
