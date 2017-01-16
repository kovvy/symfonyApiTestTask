Install and run application.

1. composer install
2. php bin/console doctrine:database:create
3. php bin/console doctrine:generate:entity


API Documentation

The API uses HTTP methods GET, POST, PUT, DELETE, PATCH, LINK, and UNLINK.
We can create, receive, edit, delete and update "requests".
We can save the query (request header, body, path, method, IP).
We can find a request by request body and the method.
If we need to change the data query, we can use the PATCH method.

Base rout of application: /{requests}/{method}

## GET / -- method return all requests

In response you will recieve json with status message:

```

{
    "success":"true",
    "requests":[
        {
            "id":1,
            "headers":"{\u0022host\u0022:[\u0022symfonyapitesttask\u0022],\u0022user-agent\u0022:[\u0022Mozilla\\\/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko\\\/20100101 Firefox\\\/50.0\u0022],\u0022accept\u0022:[\u0022text\\\/html,application\\\/xhtml+xml,application\\\/xml;q=0.9,*\\\/*;q=0.8\u0022],\u0022accept-language\u0022:[\u0022ru,uk;q=0.8,en-US;q=0.5,en;q=0.3\u0022],\u0022accept-encoding\u0022:[\u0022gzip, deflate\u0022],\u0022connection\u0022:[\u0022keep-alive\u0022],\u0022upgrade-insecure-requests\u0022:[\u00221\u0022],\u0022cache-control\u0022:[\u0022max-age=0\u0022],\u0022x-php-ob-level\u0022:[0]}",
            "body":"",
            "route":"wef",
            "method":"GET",
            "ip":"127.0.0.1",
            "created":{"date":"2017-01-16 03:44:23.000000","timezone_type":3,"timezone":"Europe\/Moscow"}}
        }
}
```

## GET /requests/{id} -- method return request

If the request was not found returns a 404 error.

```

{
    "success":"true",
    "request":
        {
            "id":2,
            "headers":"{\u0022host\u0022:[\u0022symfonyapitesttask\u0022],\u0022user-agent\u0022:[\u0022Mozilla\\\/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko\\\/20100101 Firefox\\\/50.0\u0022],\u0022accept\u0022:[\u0022text\\\/html,application\\\/xhtml+xml,application\\\/xml;q=0.9,*\\\/*;q=0.8\u0022],\u0022accept-language\u0022:[\u0022ru,uk;q=0.8,en-US;q=0.5,en;q=0.3\u0022],\u0022accept-encoding\u0022:[\u0022gzip, deflate\u0022],\u0022connection\u0022:[\u0022keep-alive\u0022],\u0022upgrade-insecure-requests\u0022:[\u00221\u0022],\u0022cache-control\u0022:[\u0022max-age=0\u0022],\u0022x-php-ob-level\u0022:[0]}",
            "body":"",
            "route":"wef",
            "method":"GET",
            "ip":"127.0.0.1",
            "created":{"date":"2017-01-16 03:45:30.000000","timezone_type":3,"timezone":"Europe\/Moscow"}
        }
}
```

## GET|POST /requests/getInfo/ -- find a request by request body and the method.

Parameters: search, method.

If the request was not found returns a 404 error.

```

{
    "success":"true",
    "request":
        {
            "id":4,
            "headers":"{\u0022host\u0022:[\u0022symfonyapitesttask\u0022],\u0022user-agent\u0022:[\u0022Mozilla\\\/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko\\\/20100101 Firefox\\\/50.0\u0022],\u0022accept\u0022:[\u0022text\\\/html,application\\\/xhtml+xml,application\\\/xml;q=0.9,*\\\/*;q=0.8\u0022],\u0022accept-language\u0022:[\u0022ru,uk;q=0.8,en-US;q=0.5,en;q=0.3\u0022],\u0022accept-encoding\u0022:[\u0022gzip, deflate\u0022],\u0022connection\u0022:[\u0022keep-alive\u0022],\u0022upgrade-insecure-requests\u0022:[\u00221\u0022],\u0022cache-control\u0022:[\u0022max-age=0\u0022],\u0022x-php-ob-level\u0022:[0]}",
            "body":"test",
            "route":"wef",
            "method":"GET",
            "ip":"127.0.0.1",
            "created":{"date":"2017-01-16 03:45:30.000000","timezone_type":3,"timezone":"Europe\/Moscow"}
        }
}
```


## GET /requests/storeRequest/{route} -- method save the query (request header, body, path, method, IP).

If the request was not found returns a 404 error.

```

{
    'success' => 'false',
    'message' => 'reason of fail'
}
```

ELSE

```

{
    'success' => 'true',
    'id' => 6
}
```

## POST /requests

Create a form, bind it to incoming data, and if all the data are valid save them and return the response.
If this is not valid, return 400 along with the form.


## PUT /requests/{id} -- method edit request.


## DELETE /requests/{id} -- method delete request.


## PATCH /requests/{id}

