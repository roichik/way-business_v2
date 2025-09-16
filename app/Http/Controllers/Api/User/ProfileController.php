<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\AuthCreateRequest;
use App\Http\Requests\Api\User\ChangeProfileRequest;
use App\Http\Requests\Api\User\ChangeProfilePasswordRequest;
use App\Http\Requests\User\ChangeUserRequest;
use App\Http\Responses\Api\User\Profile\ProfileResponse;
use App\Services\User\Dto\ChangeUserDto;
use App\Services\User\Dto\Profile\ChangeProfileDto;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 */
class ProfileController extends Controller
{
    /**
     * @param ChangeProfileRequest $request
     * @param UserService $userService
     * @return JsonResponse
     * @throws \Throwable
     */
    public function change(ChangeProfileRequest $request, UserService $userService)
    {
        $userService
            ->profileCrud()
            ->change(
                Auth::user(),
                new ChangeProfileDto($request->validated())
            );

        return (new ProfileResponse(Auth::user()))
            ->toArray(new Request());
    }

    /**
     * @return array
     */
    public function detail()
    {
        return (new ProfileResponse(Auth::user()))
            ->toArray(new Request());
    }

    /**
     * @param AuthCreateRequest $request
     * @return void
     */
    public function changePassword(ChangeProfilePasswordRequest $request, UserService $userService)
    {
        $userService
            ->profileCrud()
            ->changePassword(
                Auth::user(),
                $request->json('password'),
            );

        return new JsonResponse();
    }

}
