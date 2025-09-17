<?php

namespace App\Services\User\Operations;

use App\Dto\PaginationDto;
use App\Extensions\DataBase\Query\SettingOrderInQueriesTrait;
use App\Models\User\User;
use App\Services\User\Dto\ChangeUserDto;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Support\Facades\DB;

/**
 * Crud operations for user
 * Class UserCrudOperation
 */
class UserCrudOperation extends AbstractOperation
{
    use SettingOrderInQueriesTrait;

    /**
     * @param CreateUserDto $userDto
     * @return User
     */
    public function create(CreateUserDto $userDto)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user
                ->fill($userDto->toAttributes())
                ->save();

            $user
                ->detail()
                ->create(
                    $userDto->detail->toAttributes()
                );
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        DB::commit();

        return $user;
    }

    /**
     * @param ChangeUserDto $userDto
     * @return boolean
     */
    public function change(User $user, ChangeUserDto $userDto)
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
     * @param PaginationDto $paginationDto
     * @return mixed
     */
    public function listByPaginate(PaginationDto $paginationDto)
    {
        $user = new User();
        $query = $user->query();
        $query->select($user->getTable() . '.*');

        $this->addOrderIntoQueryAsArray(
            $user,
            $query,
            $paginationDto->sort
        );

        return $query->paginate(
            $paginationDto->per_page
        );
    }


    /**
     * @param User $user
     * @return boolean
     */
    public function delete(User $user)
    {
        return $user->delete();
    }
}
