<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedUserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        /** @var User|null $user */
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->getAuthPassword())){
            return response()->json(
                [
                    'message' => __('auth.failed')
                ],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
        ]);
    }

    public function destroy(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
