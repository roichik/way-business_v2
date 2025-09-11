<?php

namespace App\Services\User\Operations;

use App\Dto\PaginationDto;
use App\Models\User\User;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Support\Facades\DB;

/**
 * Crud operations for user
 * Class CrudOperation
 */
class CrudOperation extends AbstractOperation
{
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
     * @param  $userDto
     * @return boolean
     */
    public function change(User $user, CreateUserDto $userDto)
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
        return User::orderBy('id', $paginationDto->sort)
            ->paginate(
                $paginationDto->per_page
            );
    }
}
