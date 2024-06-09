<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class NewPasswordController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user) use ($request) {
                /** @var $user User */
                $user->forceFill([
                    'password' => $request->password,
                    'remember_token' => Str::random(60)
                ])->save();
                event(new PasswordReset($user));
                $user->tokens()->delete();
            }
        );
        //FIXME: maybe better response codes
        if($status !== Password::PASSWORD_RESET){
            return response()->json([
                'message' => __($status)
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json([
            'status' => __($status)
        ]);
    }
}
