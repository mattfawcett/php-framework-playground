PHP framework playground
=========================

A small PHP framework demo. The source code is split into 2 main pieces,
framework and app. The framework is intended to be independent, and has its
own test suite. The app folder is dependent on the framework and is an example
of the framework in use.

As this is intended to be an exercise in building a framework, I have limited the use of
external libraries with the aim of implementing the logic within the framework.
However in reality I would be more likely to use off the shelf components.
To save some time, I did use an off the shelf routing library.

The framework is intended to allow easily adding of additional entities without
having to write lots of code; the basic SQL queries being handled by the
framework and available to the app through inheritance.

The framework follows the repository pattern, which I don't really have much
experience with but would like to experiment with. The reason being that the
tight coupling between business logic and database when following the
ActiveRecord pattern can sometime make unit testing difficult and slow.

The sample app is a simple rest API that allows crud operations on uses.

Database
--------

As a very basic demo, for simplicity, the web app and test suite share a
database. The schema and some seed data can be populated by running
`./bin/db-seed`. The test suite runs this command before each test. Going
forward a proper system of migrations will be needed.

Running the tests
-----------------

The version of phpunit installed in the vagrant package is out of date and not
compatible with this codebase. The tests can be run with:
`vendor/phpunit/phpunit/phpunit` for now.

Running the application
-----------------------

The vagrant image will run the application. `www.testbox.dev` should be pointed
to the IP address accordingly.

Status Codes
------------

* 200 - Success
* 201 - User was created
* 204 - No content - When user is deleted
* 404 - User could not be found or route not found
* 422 - Entity unprocessable - validation failure

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

### Update User

Make a PATCH request to /users/:id

Will return 200 status if the user was updateted along with the JSON
representation of the updated user. For failed validation, the 422 status code will be
served, along with an errors object.

Success:

        curl -i --request 'PATCH' --data 'last_name=new' http://www.testbox.dev/users/1
        HTTP/1.1 200 OK
        Server: nginx
        Date: Sun, 02 Jul 2017 13:19:44 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        {"id":1,"email":"user1@example.com","first_name":"John","last_name":"new"}

Failed Validation

        curl -i --request 'PATCH' --data 'last_name=' http://www.testbox.dev/users/1
        HTTP/1.1 422
        Server: nginx
        Date: Sun, 02 Jul 2017 13:20:56 GMT
        Content-Type: application/json
        Transfer-Encoding: chunked
        Connection: keep-alive

        {"errors":["Last name is required"]}

### Delete User

Make a DELETE request to /users/:id

Will return 204 status code with an body as the resource no longer exists, there is nothing to serve.

        curl -i --request 'DELETE'  http://www.testbox.dev/users/1
        HTTP/1.1 204 No Content
        Server: nginx
        Date: Sun, 02 Jul 2017 13:27:00 GMT
        Content-Type: application/json
        Connection: keep-alive
