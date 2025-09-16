<?php

namespace App\Services\User\Dto;

use App\Interfaces\AbstractDto;
use Carbon\Carbon;

/**
 * Class CreateUserDetailDto
 */
class CreateUserDetailDto extends AbstractDto
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
     * @var int|null
     */
    public $companyId;

    /**
     * @var int|null
     */
    public $divisionId;

    /**
     * @var int|null
     */
    public $positionId;

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
