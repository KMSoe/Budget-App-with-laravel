<?php

namespace App\Policies;

use App\User;
use App\Budget;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetPolicy
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
    public function delete(User $user, Budget $budget){
        return $user->id === $budget->user_id ? Response::allow() : Response::deny('You don\'t have Permission');
    }
}
