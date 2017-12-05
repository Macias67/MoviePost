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

    public function fromTokem($token) {
        return $this->decodeToken($token);
    }

    private function  decodeToken($token){

        // Get public keys from URL as an array
        $publicKeyURL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
        $key = json_decode(file_get_contents($publicKeyURL), true);

        /**
        * IMPORTANT:
        * You must specify supported algorithms for your application. See
        * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
        * for a list of spec-compliant algorithms.
        */
        if($token == NULL){
            return "Error";
        }
        JWT::$leeway = 5; // Allows a 5 second tolerance on timing checks
        $decoded = JWT::decode($token, $key, array('RS256'));

        return $decoded;

    }
}
