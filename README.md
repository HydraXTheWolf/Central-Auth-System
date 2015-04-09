# Central-Auth-System

This is not designed to be accessed directly, this is a system for handling logins.

This is being designed for the new website at digitalhazards.net

There are 2 ways to send a query to the API:

The first(recommended) is by directly including the api.php. (See docs/include.txt)

The other way, is for having the API on a separate system to the service accessing it. (See docs/http.txt)

You can make a query by sending the required data to the api.php via HTML. these can be done many ways, the easiest using cURL.
A example of the GET data is:
http://localhost/cas/Central-Auth-System/api.php?key=MYKEY&type=listusers

All data returned will be in a JSON format.

The code is the status after the code has run, you can find a list of them here:

0: Code completed successfully<br>
1: MYSQL error occurred, error will be in the message<br>
2: Invalid query, this usually means there was not enough information entered to proceed, message will tell you what is missing<br>
3: Invalid API key, the key you specified was not found in the database<br>
4: <Registration> User name already in use.<br>
5: <Login> Password incorrect<br>
6: <Login> Username not found in database<br>
7: You tried to create a HTTP request when HTTP requests are disallowed

For information on each method, read the respective file in 'docs/methods/'