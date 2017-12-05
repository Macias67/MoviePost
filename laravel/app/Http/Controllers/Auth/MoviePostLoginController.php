<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * Register a user
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {

        $userData = Input::json()->all();
        
        // Check the user submitted data is valid
        
        $userValidator = $this->validator($userData);
        if($userValidator->fails()){
            
            $message = $userValidator->errors();

            // The submitted user is incorrect

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
            $encodedUser = JWT::encode($userTokenData, env('APP_AUTH_PRIVATE_KEY', false));

            return $encodedUser;
        }

        $message = "Wrong Access Credentials";

        return response($message, 400)
                ->header('Content-Type', 'text/plain'); 


    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
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
