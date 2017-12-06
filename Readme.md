
## Movie Post

  The quickest way to get the latest information on movies you will like.
  
```huheuehue
$ Application key [base64:UG0QwYwwFk+7b2EMl33F2LBZtP26x8qhm+sCncQUfek=] set successfully.
```

private.key and pubkey.key are used for the authentication inside Movie Post in .env file

Generated through:
openssl genrsa -out private.key 1024
openssl rsa -in private.key -pubout > pubkey.key
