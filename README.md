RANDOm image exchange
=====================

Client
------

Current version deployed on [rando.clouds.gallery](http://rando.clouds.gallery)




Service
-------

Service is available on [rando-server.clouds.gallery](http://rando-server.clouds.gallery)

RANDO Service API expressed in terms of application domain entities and can be accessed in following form:
```
{HTTP_METHOD} /{Entity}/{Key}
```

`HTTP_METHOD` is used by service to define which kind of action should be performed with entity instance with specified `key`. For `GET` method `key` param can be omitted to get a list of entity instances.

###User authentication

To authenticate current user next params should be passed as part of request: 

 - `username` - username (email)
 - `seed` - random string
 - `token` - public key, generated as follows:
```
$token = md5(md5($password), $seed)
```
Example of API calls with authentication params:
```
GET /photo/?filter=outgoing&seed=779&token=032eed42ea880071552eced167f3f27f&username=max@gmail.com HTTP/1.1

GET /photo/15?seed=779&token=032eed42ea880071552eced167f3f27f&username=max@gmail.com HTTP/1.1
```

###Application domain


For now supported entities *User* and *Photo*.

####User

####Photo



