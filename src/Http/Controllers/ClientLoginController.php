<?php

namespace Techneved\Client\Http\Controllers;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Techneved\Client\Http\Requests\MobileLogin;

class ClientLoginController extends Controller
{
    const GUARD = 'client-logins';

    /**
     * InstructorLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:'.static::GUARD)->except('login');
    }

    /**
     * Get a JWT token through given credentials
     *
     * @param MobileLogin $request
     * @return JsonResponse
     */

    public function login(MobileLogin $request)
    {
        return $this->authentication();
    }


    /**
     * Credential Authentication
     *
     * @return JsonResponse
     */

    private function authentication()
    {
        if ($token = $this->attempt()) {

            return $this->successResponse($this->tokenResponse($token), Response::HTTP_OK);
        }
        return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Credential attempt
     *
     * @return mixed
     */

    private function attempt()
    {
        return $this->guard()->attempt([
            'mobile' => request()->input('mobile'), 
            'password'      => request()->input('password'),
            'status'        => 1
            ]);
    }

    /**
     * Token Response
     *
     * @param $token
     * @return array
     */
    private function tokenResponse($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'client' => $this->guard()->user()
        ];
    }

    /**
     * Success Response
     *
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    private function successResponse($message, $statusCode)
    {
        return response()->json([

            'data' => $message
        ], $statusCode);
    }

    /**
     * Error Response
     *
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    private function errorResponse($message, $statusCode)
    {
        return response()->json([
            'errors' => [

                'error' => $message
            ]
        ], $statusCode);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return mixed
     */
    private function guard()
    {
        return Auth::guard(static::GUARD);
    }


     /**
     * Logout the teacher authentication
     *
     * @return JsonResponse;
     */

     public function logout()
     {
         $this->guard()->logout();
         return $this->successResponse([ 'message' => 'Successfully logout'], Response::HTTP_OK);
     }
}
