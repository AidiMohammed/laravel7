<?php

namespace App\Policies;

use App\Answer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function delete(User $user, Answer $answer)
    {
        if($user->id === $answer->user_id)return true;
    }

    public function update(User $user,Answer $answer)
    {
        return $user->id === $answer->user_id;
    }
}
