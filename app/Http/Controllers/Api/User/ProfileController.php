<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\Activation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\AuthCreateRequest;
use App\Http\Requests\User\ChangeUserRequest;
use App\Http\Responses\Api\Profile\ProfileDetailResponse;
use App\Models\User\ActivationCode;
use App\Models\User\ReferrerCodeGenerator;
use App\Services\Brevo\Events\BrevoEventsService;
use App\Services\Brevo\Events\Dictionaries\EventDictionary;
use App\Services\User\Dto\ChangeUserDto;
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
     * @param AuthCreateRequest $request
     * @return void
     */
    public function change(ChangeUserRequest $request, UserService $userService)
    {
        $user = Auth::user();
        $dto = new ChangeUserDto($request->validated());
        $userService
            ->crud()
            ->change($user, $dto);

        return new JsonResponse();
    }

    /**
     * @param AuthCreateRequest $request
     * @return void
     */
    public function detail()
    {
        $user = Auth::user();

        return (new ProfileDetailResponse($user))
            ->toArray(new Request());
    }

    /**
     * @param AuthCreateRequest $request
     * @return void
     */
    public function changePassword(UserService $userService)
    {
        $user = Auth::user();

        return new JsonResponse();
    }

}
