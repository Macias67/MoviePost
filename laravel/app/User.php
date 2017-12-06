<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Firebase\JWT\JWT;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function fromToken($token) {
        
        // get Public Key
        $key = strtr(env('APP_AUTH_PUBLIC_KEY', false), array('\\n' => "\n", "_" => " "));
        
        JWT::$leeway = 5; // Allows a 5 second tolerance on timing checks
        $decoded = JWT::decode($token, $key, array('RS256'));
        
        return $decoded;

    }

}
