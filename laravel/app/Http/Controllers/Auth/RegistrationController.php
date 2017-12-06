<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use \Firebase\JWT\JWT;

class RegistrationController extends Controller
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
     * Register a user
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

        // We Create the validated User
        $newUser = $this->create($userData);

        // We encode and create the access Token for the client
        $encodedUser = JWT::encode($newUser, strtr(env('APP_AUTH_PRIVATE_KEY', false), array('\\n' => "\n", "_" => " ")), 'RS256');

        return $encodedUser;

    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Support\Facades\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
