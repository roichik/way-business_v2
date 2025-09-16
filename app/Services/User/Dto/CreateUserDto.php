<?php

namespace App\Services\User\Dto;

use App\Interfaces\AbstractDto;

/**
 * Class CreateUserDto
 */
class CreateUserDto extends AbstractDto
{
    /**
     * @var string
     */
    public $nickname;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string|null
     */
    public $emailVerifiedAt;

    /**
     * @var string|null
     */
    public $phone;

    /**
     * @var string|null
     */
    public $phoneVerifiedAt;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $isEnabled = true;

    /**
     * @var CreateUserDetailDto
     */
    public $detail;

    /**
     * @param CreateUserDetailDto $detail
     * @return CreateUserDto
     */
    public function setDetail(CreateUserDetailDto|array $detail)
    {
        $this->detail = is_array($detail) ? new CreateUserDetailDto($detail) : $detail;

        return $this;
    }
}
