<?php

namespace App\Policies;

use App\Models\Countries;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CountriesPolicy extends Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models countries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user, Countries $model = null)
    {
        return optional($user);
    }

    /**
     * Determine whether the user can view the models countries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function view(?User $user, Countries $model = null)
    {
        return optional(null);
    }

    /**
     * Determine whether the user can create models countries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    // public function create(User $user, Countries $model = null)
    public function create(?User $user, ?Countries $model = null)
    {
        // FIXME: open on production
        return optional($user);
        // $table_name = $model->getTable();
        // $permissions = $model->getPermissions('create');
        // $permissions[] = $table_name.'@create';
        // $permissions[] = $table_name.'@*';
        // return $user->hasAnyPermission($permissions);
    }

    /**
     * Determine whether the user can update the models countries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function update(?User $user, Countries $model = null)
    {
        return optional($user);
        // $table_name = $model->getTable();
        // $permissions = $model->getPermissions('update');
        // $permissions[] = $table_name.'@update';
        // $permissions[] = $table_name.'@*';
        // return $user->hasAnyPermission($permissions);
    }

    /**
     * Determine whether the user can delete the models countries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function delete(?User $user, Countries $model = null)
    {
        return optional($user);
        // $table_name = $model->getTable();
        // $permissions = $model->getPermissions('delete');
        // $permissions[] = $table_name.'@delete';
        // $permissions[] = $table_name.'@*';
        // return $user->hasAnyPermission($permissions);
    }

    /**
     * Determine whether the user can restore the models countries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function restore(?User $user, Countries $model = null)
    {
        return optional($user);
        // $table_name = $model->getTable();
        // $permissions = $model->getPermissions('restore');
        // $permissions[] = $table_name.'@restore';
        // $permissions[] = $table_name.'@*';
        // return $user->hasAnyPermission($permissions);
    }

    /**
     * Determine whether the user can permanently delete the models countries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function forceDelete(User $user, Countries $model = null)
    {
        //
    }
}
