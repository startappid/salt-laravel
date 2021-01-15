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
        app()['cache']->forget('spatie.permission.cache');
        $structures = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $permissions = array();
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

        Permission::create(['name' => '*.*.*']);          // Superadministrator permissions
        Permission::create(['name' => '*.create.*']);     // Create and Store data
        Permission::create(['name' => '*.read.*']);       // Read List and Detail data
        Permission::create(['name' => '*.update.*']);     // Update/Patch data
        Permission::create(['name' => '*.restore.*']);    // Restore data from Trash
        Permission::create(['name' => '*.destroy.*']);    // Soft Delete data
        Permission::create(['name' => '*.trash.*']);      // Read Trashed data and detail
        Permission::create(['name' => '*.delete.*']);     // Hard Delete from trash
        Permission::create(['name' => '*.empty.*']);      // Empty all data in trash
        Permission::create(['name' => '*.import.*']);     // Import data to Database
        Permission::create(['name' => '*.export.*']);     // Export data to CSV, Excel, JSON, XML, PDF, etc
        Permission::create(['name' => '*.report.*']);     // Report

        foreach ($structures as $key => $table) {
            // create permissions
            Permission::create(['name' => $table.'.create.*']);
            Permission::create(['name' => $table.'.read.*']);
            Permission::create(['name' => $table.'.update.*']);
            Permission::create(['name' => $table.'.restore.*']);
            Permission::create(['name' => $table.'.destroy.*']);
            Permission::create(['name' => $table.'.delete.*']);
            Permission::create(['name' => $table.'.trash.*']);
            Permission::create(['name' => $table.'.empty.*']);
            Permission::create(['name' => $table.'.import.*']);
            Permission::create(['name' => $table.'.export.*']);
            Permission::create(['name' => $table.'.report.*']);
            Permission::create(['name' => $table.'.*.*']); // all permission only for this model
        }

        Permission::create(['name' => 'users.activate']);
        Permission::create(['name' => 'users.deactivate']);

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

        $role = Role::create(['name' => 'driver']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['users.read.*', 'users.update.*']);

        $user = User::where('username', 'superadmin')->first();
        $user->assignRole('superadmin');
        $user = User::where('username', 'admin')->first();
        $user->assignRole('admin');
    }
}
