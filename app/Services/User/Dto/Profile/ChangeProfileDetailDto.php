<?php

namespace App\Services\User\Dto\Profile;

use App\Interfaces\AbstractDto;
use App\Services\User\Dto\CreateUserDetailDto;
use Carbon\Carbon;

/**
 * Class ChangeUserProfileDto
 */
class ChangeProfileDetailDto extends AbstractDto
{
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string|null
     */
    public $fatherName;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var Carbon|null
     */
    public $birthdayAt;

    /**
     * @param Carbon $birthdayAt
     * @return CreateUserDetailDto
     */
    public function setBirthdayAt(Carbon|string|null $birthdayAt)
    {
        if ($birthdayAt === null) {
            return $this;
        }
        $this->birthdayAt = is_string($birthdayAt) ? new Carbon($birthdayAt) : $birthdayAt;

        return $this;
    }
}
