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
    public function index()
    {
        // Retrieve user from Authorization token

        $token = Request::header('Authorization');
        if(!isset($token)){
            $message = "Error";
            return response($message, 400)
                  ->header('Content-Type', 'text/plain'); 
        }
        $user = User::fromToken($token);
        
        $page = Input::get('page', -1);



        if($page > -1) {
            $movies = DB::table('user_movies')->where('iduser', $user->email)
                ->offset(($page-1)*10)
                ->limit(10)
                ->get();

            $count = DB::table('user_movies')
                    ->where('iduser', $user->email)
                    ->count();
                
            $pages = intval($count/10) + 1; // Assumes page size 10
            return array(
                "total_results" => $count,
                "total_pages" => $pages,
                "results" => $movies
            );

        } 
        else {
            $movies = DB::table('user_movies')->where('iduser', $user->email)->get();
        }
        
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
        // Retrieve user from Authorization token

        $token = Request::header('Authorization');
        if(!isset($token)){
            $message = "Error";
            return response($message, 400)
                  ->header('Content-Type', 'text/plain'); 
        }

        $user = User::fromToken($token);

        $movieData = Input::json()->all();

        if(!isset($movieData["movie"]["id"])){
            $movieData["movie"]["id"] = $movieData["movie"]["idmovie"];
        }

        $movies = DB::table('user_movies')
                    ->where('iduser', $user->email)
                    ->where('idmovie', $movieData["movie"]["id"])->first();
        
        if(!$movies){
            DB::table('user_movies')->insert(
                ['iduser' => $user->email, 
                    'idmovie' => $movieData["movie"]["id"],
                    'title' => $movieData["movie"]["title"],
                    'overview' => $movieData["movie"]["overview"],
                    'poster_path' => $movieData["movie"]["poster_path"]]
            );
        }
        
        return "success";

    }

    /**
     * Obtain all User Movies
     *
     * @param  int  $idmovie
     * @return Response
     */
    public function delete($idmovie = null)
    {
        // Retrieve user from Authorization token

        $token = Request::header('Authorization');
        if(!isset($token)){
            $message = "Error";
            return response($message, 400)
                  ->header('Content-Type', 'text/plain'); 
        }
        $user = User::fromToken($token);


        DB::table('user_movies')
            ->where('iduser', $user->email)
            ->where('idmovie', $idmovie)->delete();
        
        return "success";
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
