<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('voyager.dashboard');
        } elseif ($user->isLawyer()) {
            return redirect()->route('lawyer.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }
}
