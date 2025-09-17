<?php

namespace App\Http\Controllers\Api\User;

use App\Dictionaries\User\UserFlagDictionary;
use App\Dto\PaginationDto;
use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaginationRequest;
use App\Http\Requests\Api\User\ChangeUserRequest;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Responses\Api\User\UserResponse;
use App\Models\User\User;
use App\Services\User\Dto\ChangeUserDto;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @param UserService $userService
     * @return array
     * @throws \Throwable
     */
    public function create(CreateUserRequest $request, UserService $userService)
    {
        $dto = new CreateUserDto($request->validated());
        $user = $userService
            ->userCrud()
            ->create($dto);

        return (new UserResponse($user))
            ->toArray(new Request());
    }

    /**
     * @param User $user
     * @param ChangeUserRequest $request
     * @param UserService $userService
     * @return array
     * @throws \Throwable
     */
    public function change(User $user, ChangeUserRequest $request, UserService $userService)
    {
        $dto = new ChangeUserDto($request->validated());
        $userService
            ->userCrud()
            ->change($user, $dto);

        return (new UserResponse($user))
            ->toArray(new Request());
    }

    /**
     * @param User $user
     * @return array
     */
    public function one(User $user)
    {
        return (new UserResponse($user))
            ->toArray(new Request());
    }

    /**
     * @param PaginationRequest $request
     * @param UserService $userService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listByPaginate(PaginationRequest $request, UserService $userService)
    {
        $collection = $userService
            ->userCrud()
            ->listByPaginate((new PaginationDto($request->validated())));

        return UserResponse::collection($collection);
    }

    /**
     * @param User $user
     * @param UserService $userService
     * @return JsonResponse
     */
    public function delete(User $user, UserService $userService)
    {
        if ($user->id == Auth::id()) {
            throw new Exception('Вы не можете удалить пользователя, под которым авторизированы');
        }

        if ($user->hasFlag(UserFlagDictionary::PROHIBIT_DELETION)) {
            throw new Exception('Удаление пользователя запрещено');
        }

        $userService
            ->userCrud()
            ->delete($user);

        return new JsonResponse();
    }

}
