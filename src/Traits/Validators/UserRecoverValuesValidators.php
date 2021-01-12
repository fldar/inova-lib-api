<?php

namespace App\Traits\Validators;

use App\Entity\UserRecover;

trait UserRecoverValuesValidators
{
    /**
     * @param UserRecover|null $userRecover
     */
    public function validUserRecoverEntity(?UserRecover $userRecover): void
    {
        if (!$userRecover || !$userRecover->getId()) {
            throw new \DomainException('Invalid Hash!');
        }
    }

    /**
     * @param string|null $password
     */
    public function validPassword(?string $password): void
    {
        if (!($password)) {
            throw new \DomainException('Invalid Password!');
        }
    }
}
