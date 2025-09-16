<?php

namespace App\Services\User\Dto\Profile;

use App\Interfaces\AbstractDto;

/**
 * Class ChangeUserDto
 */
class ChangeProfileDto extends AbstractDto
{
    /**
     * @var string|null
     */
    public $phone;

    /**
     * @var ChangeProfileDetailDto
     */
    public $detail;

    /**
     * @param CreateUserDetailDto $detail
     * @return $this
     */
    public function setDetail(CreateUserDetailDto|array $detail)
    {
        $this->detail = is_array($detail) ? new ChangeProfileDetailDto($detail) : $detail;

        return $this;
    }
}
