<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $status = Password::sendResetLink($request->only('email'));

        //FIXME: return better response
        if($status !== Password::RESET_LINK_SENT){
            return response()->json(
                [
                    'message' => __($status)
                ],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return response(status: Response::HTTP_OK);
    }
}
