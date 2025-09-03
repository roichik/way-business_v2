<?php

namespace App\Services\User\Dto;

use App\Interfaces\AbstractDto;
use Carbon\Carbon;

/**
 * Class CreateUserDetailDto
 */
class CreateUserDetailDto extends AbstractDto
{
    public string $firstName;

    public string $lastName;

    public string|null $fatherName;

    public string $gender;

    public Carbon|null $birthdayAt;

    /**
     * @param Carbon $birthdayAt
     * @return CreateUserDetailDto
     */
    public function setBirthdayAt(Carbon|string|null $birthdayAt)
    {
        if($birthdayAt === null){
            return $this;
        }
        $this->birthdayAt = is_string($birthdayAt) ? new Carbon($birthdayAt) : $birthdayAt;

        return $this;
    }
}
