<?php

namespace App\Services\User\Operations;

use App\Models\User\User;
use App\Services\User\Dto\ChangeUserDto;
use App\Services\User\Dto\Profile\ChangeProfileDto;
use Illuminate\Support\Facades\DB;

/**
 * Crud operations for user profile
 * Class ProfileCrudOperation
 */
class ProfileCrudOperation extends AbstractOperation
{
    /**
     * @param ChangeUserDto $userDto
     * @return boolean
     */
    public function change(User $user, ChangeProfileDto $userDto)
    {
        DB::beginTransaction();
        try {
            $b = $user
                ->fill($userDto->toAttributes())
                ->save();

            $user
                ->detail
                ->fill($userDto->detail->toAttributes())
                ->save();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        DB::commit();

        return $b;
    }

    /**
     * @param User $user
     * @param string $newPassword
     * @return void
     */
    public function changePassword(User $user, string $password)
    {
        $user->password = $password;
        $user->save();
    }
}
