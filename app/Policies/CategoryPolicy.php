<?php

namespace App\Policies;

use App\User;
use App\Category;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function delete(User $user, Category $category){
        return $user->id === $category->user_id ? Response::allow() : Response::deny('You don\'t have Permission');
    }
}
