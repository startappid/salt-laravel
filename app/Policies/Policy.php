<?php

namespace App\Policies;

use App\Models\Resources;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return optional($user);
    }

    /**
     * Determine whether the user can view the models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function view(?User $user)
    {
        return optional($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to create new data.");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to update data.");
    }

    /**
     * Determine whether the user can update the models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function update(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to update data.");
    }

    /**
     * Determine whether the user can delete the models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function delete(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to delete data.");
    }

    /**
     * Determine whether the user can restore the models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function restore(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to restore data.");
    }

    /**
     * Determine whether the user can permanently delete the models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Countries  $models\Countries
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to force delete data.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to retrieve data.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to see trash.");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to create new data.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to show detail data.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to destroy data.");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to import data.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to export data.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to show report data.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to delete data from trash.");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empty(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to empty all data in the trash.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreAll(User $user)
    {
        // You may give any logic here
        return $user
                ? Response::allow()
                : Response::deny("You don't have authorization to restore all data in the trash.");
    }

}
