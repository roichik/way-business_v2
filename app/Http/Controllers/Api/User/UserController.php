<?php

namespace App\Http\Controllers\Api\User;

use App\Dto\PaginationDto;
use App\Facades\Activation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaginationRequest;
use App\Http\Requests\Api\User\UserChangeRequest;
use App\Http\Requests\Api\User\UserCreateRequest;
use App\Http\Responses\Api\Profile\ProfileDetailResponse;
use App\Models\User\ActivationCode;
use App\Models\User\ReferrerCodeGenerator;
use App\Models\User\User;
use App\Services\Brevo\Events\BrevoEventsService;
use App\Services\Brevo\Events\Dictionaries\EventDictionary;
use App\Services\User\Dto\ChangeUserDto;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserController
 */
class UserController extends Controller
{

    /**
     * @param UserCreateRequest $request
     * @param UserService $userService
     * @return JsonResponse
     * @throws \Throwable
     */
    public function create(UserCreateRequest $request, UserService $userService)
    {
        $dto = new CreateUserDto($request->validated());
        $user = $userService
            ->crud()
            ->create($dto);

        return new JsonResponse([
            'id' => $user->id,
        ]);
    }

    /**
     * @param User $user
     * @param UserChangeRequest $request
     * @param UserService $userService
     * @return JsonResponse
     * @throws \Throwable
     */
    public function change(User $user, UserChangeRequest $request, UserService $userService)
    {
        $dto = new ChangeUserDto($request->validated());
        $userService
            ->crud()
            ->change($user, $dto);

        return new JsonResponse();
    }

    /**
     * @param User $user
     * @param UserService $userService
     * @return JsonResponse
     */
    public function one(User $user)
    {
        return (new ProfileDetailResponse($user))
            ->toArray(new Request());
    }

    /**
     * @param UserService $userService
     * @return JsonResponse
     */
    public function listByPaginate(PaginationRequest $request, UserService $userService)
    {
        $collection = $userService
            ->crud()
            ->listByPaginate((new PaginationDto($request->validated())));

        return ProfileDetailResponse::collection($collection);
    }

    /**
     * @param User $user
     * @param UserService $userService
     * @return JsonResponse
     */
    public function changePassword(User $user, UserService $userService)
    {

        return new JsonResponse();
    }

    /**
     * @param User $user
     * @param UserService $userService
     * @return JsonResponse
     */
    public function delete(User $user, UserService $userService)
    {
        return new JsonResponse();
    }

}
