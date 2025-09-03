<?php

namespace App\Services\User\Dto;

use App\Interfaces\AbstractDto;

/**
 * Class CreateUserDto
 */
class CreateUserDto extends AbstractDto
{
    public string $nickname;

    public string $email;

    public string|null $phone;

    public string $password;

    public bool $isEnabled = true;

    public CreateUserDetailDto $detail;

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
