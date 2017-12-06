
## Movie Post

  The quickest way to get the latest information on movies you will like.
  
  # How to use
  
- Import MoviesDB.sql to a mysql schema
- check the following fields at laraverl->.env file

    --DB_HOST=localhost
    
    --DB_PORT=8889 *(Change to your mysql port)*
    
    --DB_DATABASE=manbm_moviepost *(Change to your database)*
    --DB_USERNAME=manbm *(Change to your database user name)*
    --DB_PASSWORD=moviepost123 *(Change to your database user name's password)*
        --*Check user is added to DB_DATABASE database*
        
- Set up a host (Ex. api.moviepost.loc) in your local hosts file, and set up a virtual host with servername *api.moviepost.loc* pointing to **laravel/public**  in order to be able to listen to the api.

- The project https://github.com/Manbec/MoviePostFront has configured the api url as *api.moviepost.loc* and All requests are sent to that address. you can change it to localhost:port or any address you set for this API on your hosts file server setup.
  
  ## Other Notes
```huheuehue
$ Application key [base64:UG0QwYwwFk+7b2EMl33F2LBZtP26x8qhm+sCncQUfek=] set successfully.
```

private.key and pubkey.key are used for the authentication inside Movie Post in .env file

Generated through:
openssl genrsa -out private.key 1024
openssl rsa -in private.key -pubout > pubkey.key
