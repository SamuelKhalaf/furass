<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'false', 'message' => 'We could not find a user with that email address.'], 404);
        }

        // Create password reset token
        $token = Password::broker()->createToken($user);
        $user->notify(new ResetPassword($token, $user->email));

        return response()->json(['status' => 'true', 'message' => 'We have emailed your password reset link!']);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return response()->json(['status' => 'true','message' => trans($response)], 200);
        }

        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return response()->json(['status' => 'false','message' => trans($response)], 422);
        }

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
