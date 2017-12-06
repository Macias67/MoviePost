<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use \Firebase\JWT\JWT;

class MoviePostLoginController extends Controller
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
     * Login User
     *
     * input json $userData
     * @return Response
     */
    public function index()
    {

        $userData = Input::json()->all();
        
        // Check the user submitted data is valid
        $userValidator = $this->validator($userData);
        if($userValidator->fails()){
    
            $message = $userValidator->errors();
            // The submitted user has invalid data
            return response($message, 400)
                  ->header('Content-Type', 'text/plain'); 

        }

        if (Auth::attempt(['email' => $userData["email"], 'password' => $userData["password"]])) {
            // Authentication passed...
            $user = Auth::user();

            $userTokenData = array(
                "email" => $user["email"],
                "name" => $user["name"]
            );

            // We encode and create the access Token for the client
            $encodedUser = JWT::encode($userTokenData, strtr(env('APP_AUTH_PRIVATE_KEY', false), array('\\n' => "\n", "_" => " ")), 'RS256');

            return $encodedUser;
        }

        $message = "Wrong Access Credentials";
        return response($message, 400)
                ->header('Content-Type', 'text/plain'); 


    }


    /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     * @return \Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }

}
