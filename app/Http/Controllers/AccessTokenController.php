<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AccessTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::whereEmail($request->username)->with('role')->first();

        $request->request->add([
            'client_id' => config('passport.password_client.id'),
            'client_secret' => config('passport.password_client.secret'),
            "grant_type" => config('passport.password_client.grant_type'),
	        "scope" => [
                $user->role
            ]
        ]);

        $tokenRequest = Request::create(
            'oauth/token',
            'POST'
        );

        return Route::dispatch($tokenRequest);
    }
}
