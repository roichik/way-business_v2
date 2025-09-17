<?php

namespace App\Services\User\Dto;

use App\Interfaces\AbstractDto;

/**
 * Class ChangeUserDto
 */
class ChangeUserDto extends AbstractDto
{
    /**
     * @var string|null
     */
    public $nickname;

    /**
     * @var string|null
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
     * @var string|null
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
     * @return $this
     */
    public function setDetail(CreateUserDetailDto|array $detail)
    {
        $this->detail = is_array($detail) ? new CreateUserDetailDto($detail) : $detail;

        return $this;
    }

    /**
     * @return array
     */
    public function toAttributes(): array
    {
        $attributes = parent::toArray();

        if ($attributes['nickname'] === null || $attributes['nickname'] === '') {
            unset($attributes['nickname']);
        }
        if ($attributes['email'] === null || $attributes['email'] === '') {
            unset($attributes['email']);
        }
        if ($attributes['password'] === null || $attributes['password'] === '') {
            unset($attributes['password']);
        }

        return $attributes;
    }
}
