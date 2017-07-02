Examples
--------

### List users

Make a GET request to /users

        curl -i http://www.testbox.dev/users
        HTTP/1.1 200 OK
        Server: nginx
        Date: Sun, 02 Jul 2017 12:59:23 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        [{"id":1,"email":"user1@example.com","first_name":"John","last_name":"Smith"},{"id":2,"email":"tim@example.com","first_name":"Tim","last_name":"Smart"},{"id":3,"email":"alan@example.com","first_name":"Alan","last_name":"Parker"}]

### Show one user details

Make a GET request to /users/:id

        curl -i http://www.testbox.dev/users/1
        HTTP/1.1 200 OK
        Server: nginx
        Date: Sun, 02 Jul 2017 12:59:57 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        {"id":1,"email":"user1@example.com","first_name":"John","last_name":"Smith"}

### Create User

Make a POST request to /users

Will return 201 status if the user was inserted properly along with the json
representation of that user. For failed validation, the 422 status code will be
served, along with an errors object.

Success:

        curl -i -d 'first_name=matt&last_name=fawcett&email=matt@example.com&password=123' http://www.testbox.dev/users
        HTTP/1.1 201 Created
        Server: nginx
        Date: Sun, 02 Jul 2017 13:02:13 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        {"first_name":"matt","last_name":"fawcett","email":"matt@example.com","id":"4"}

Failed Validation

        curl -i -d 'first_name=matt&email=fake&password=123' http://www.testbox.dev/users 
        HTTP/1.1 422
        Server: nginx
        Date: Sun, 02 Jul 2017 13:03:01 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        {"errors":["Last name is required","Email is invalid"]}
