<?php

namespace App\Http\Controllers;

use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function signUp(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'domain'   => ['required', 'string', 'min:4'],
        ]);

        /** @var User $user */
        User::query()->create([
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'domain'   => $request->input('domain'),
        ]);

        return $this->toJson(['message' => 'Successfully created user!'], Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws \App\Exceptions\BadCredentials
     */
    public function signIn(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email'    => 'required|string|email|exists:users',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (! $token = $this->generateToken($credentials, 1)) {
            return $this->toJson([
                'message' => 'You cannot sign with those credentials',
                'errors'  => 'Unauthorised',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ((bool)$request->get('remember_me')) {
            $request->user()->setRememberToken(Str::random(60));
            $request->user()->save();
        }

        return $this->toJson([
            'token'      => $token,
            'token_type' => 'Bearer',
            "expires_at" => Carbon::parse($this->tokenStorage->getClaim('exp'))->toDateTimeString()
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->setRememberToken('');
        $user->save();

        $token = $this->tokenStorage->setToken($request->bearerToken());
        $token->invalidate();

        return $this->toJson(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $this->tokenStorage->setToken($request->bearerToken());
        return $this->toJson(['result' => $this->tokenStorage->user()], Response::HTTP_OK);
    }
}
