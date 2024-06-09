<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return response()->json([
               'message' => __('auth.already_verified')
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => __('auth.verification_link_sent')]);
    }
}
