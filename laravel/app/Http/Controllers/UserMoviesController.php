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

class UserMoviesController extends Controller
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
     * Obtain all User Movies
     *
     * @
     * @return Response
     */
    public function index($idmovie = null)
    {
        // Retrieve user from Authorization token

        $token = Request::header('Authorization');
        $user = User::fromToken($token);
        
        $movies = DB::table('user_movies')->where('iduser', $user->email)->get();
        
        return $movies;

    }

    /**
     * Save new user movie
     *
     * @param  array  $movie
     * @return Response
     */
    public function save($movie = null)
    {

        $token = Request::header('Authorization');
        $user = User::fromToken($token);

        $movieData = Input::json()->all();
        
        $movies = DB::table('user_movies')->where('iduser', $user->email)->get();
        
        return $movies;

    }

    /**
     * Obtain all User Movies
     *
     * @param  int  $idmovie
     * @return Response
     */
    public function delete($idmovie = null)
    {
        return Route::currentRouteName();
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
