<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\CustomResponse;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{

    use VerifiesEmails;
    use CustomResponse;


    public function show(Request $request)
    {
        $user =  User::findOrFail($request->id);
        if ($user->hasVerifiedEmail()) {
            return $this->sendResponse('Email verified!');
        }
        else {
            return $this->sendFailedResponse('Verfied Failed');
        }
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user =  User::query()->where('id', $request->id)->whereNull('email_verified_at')->first();
        if($user){
            $user->markEmailAsVerified();
            $user->email_verified_at = now();
            $user->save();
            event(new Verified($request->user()));
            return $this->sendResponse('Email verified!');
        } else {
            return $this->sendFailedResponse('Verfied Failed');
        }
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse( $response)
    {
        return response()->json(['success' => ["message" => $response] ], 200);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedResponse( $response)
    {
        return response()->json(['error' => ["message" => $response] ], 422);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
//            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json('The notification has been resubmitted');
//        return back()->with('resent', true);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('signed')->only('verify');
        //$this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
