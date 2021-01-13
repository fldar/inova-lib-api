<?php

namespace App\Traits\Validators;

use Carbon\Carbon;
use App\Entity\UserRecover;
use App\Exception\HashExpiredException;

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
     * @param UserRecover $userRecover
     */
    public function validHash(UserRecover $userRecover)
    {
        $dateCreated = $userRecover->getCreatedAt()->format('Y-m-d H:i:s');
        $dateCreated = Carbon::createFromDate($dateCreated);
        $date = Carbon::now();

        $this->validHashDateInvalid($dateCreated, $date);
        $this->validHashDateExpired($dateCreated, $date);
    }

    /**
     * @param Carbon $dateCreated
     * @param Carbon $now
     */
    public function validHashDateInvalid(Carbon $dateCreated, Carbon $now): void
    {
        if ($dateCreated > $now) {
            throw new HashExpiredException();
        }
    }

    /**
     * @param Carbon $dateCreated
     * @param Carbon $now
     */
    public function validHashDateExpired(Carbon $dateCreated, Carbon $now): void
    {
        if ($dateCreated->diffInMinutes($now) > 20) {
            throw new HashExpiredException();
        }
    }
}
