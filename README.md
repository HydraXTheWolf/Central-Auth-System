# Central-Auth-System

This is not designed to be accessed directly, this is a system for handling logins.

I will include an example of how to integrate this to a website as I progress in development.

This is being designed for the new website at digitalhazards.net


Each API query returns a JSON encoded array with the following:
code,
message

Some query's might return other values as well, however all of the will return at least the above.

The code is the status after the code has run, you can find a list of them here:

0: Code completed successfully
1: MYSQL error occurred, error will be in the message
2: Invalid query, this usually means there was not enough information entered to proceed, message will tell you what is missing
3: Invalid API key, the key you specified was not found in the database
4: <Registration> User name already in use.
5: <Login> Password incorrect
6: <Login> Username not found in database

Returns:

Register:
userid=register will (on success) return the userid of the newly created user


Login:
id: The unique Identification digit of the user
regodate: The date of registration