<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request){

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(
                ['message' => __('auth.verified')],
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json(
            ['message' => __('auth.verified')],
        );
    }
}
