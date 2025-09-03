<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\Activation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Models\User\ActivationCode;
use App\Models\User\ReferrerCodeGenerator;
use App\Models\User;
use App\Services\Brevo\Events\BrevoEventsService;
use App\Services\Brevo\Events\Dictionaries\EventDictionary;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 */
class AuthController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function signUp()
    {
        return new JsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            throw new \Exception('Credentials not match', 401);
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->is_enabled) {
            throw new \Exception('Credentials not match', 401);
        }

        if (!$user->email_verified_at) {
            throw new \Exception('Your account is not verified');
        }

        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return new JsonResponse([
            'token' => $token,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function resetPassword()
    {
        return new JsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function resetPasswordByToken()
    {
        return new JsonResponse();
    }
}
