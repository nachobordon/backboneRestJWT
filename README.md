
# backboneRestJWT
=================
Estructure for API rest whith JWT authentication

Installation
------------

Change in parameters.yml the pass phrase
jwt_key_pass_phrase:  'set_your_key_pass_phrase'              # ssh key pass phrase

Generate the SSH keys :

``` bash
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
```