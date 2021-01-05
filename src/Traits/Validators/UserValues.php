<?php

namespace App\Traits\Validators;

use App\Entity\User;

trait UserValues
{
    /**
     * @param User|null $user
     */
    public function validUserEntity(?User $user): void
    {
        if (!$user || !$user->getId()) {
            throw new \DomainException('Invalid User!');
        }
    }
}