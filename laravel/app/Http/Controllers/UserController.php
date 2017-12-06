<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Obtain user information
     *
     * @
     * @return Response
     */
    public function index($idmovie = null)
    {
        // Retrieve user from Authorization token

        $token = Request::header('Authorization');
        $user = User::fromToken($token);
        
        $foundUser = DB::table('users')->where('email', $user->email)->first();

        $user = array(
            "email" => $foundUser->email,
            "name" => $foundUser->name
        );

        return $user;

    }

}
