# Central-Auth-System

This is not designed to be accessed directly, this is a system for handling logins.

I will include an example of how to integrate this to a website as I progress in development.

This is being designed for the new website at digitalhazards.net

You can make a query by sending the required data to the api.php via HTML. these can be done many ways, the easiest using cURL.

All data returned will be in a JSON format. sample data of a successful run will be included soon.

The code is the status after the code has run, you can find a list of them here:

0: Code completed successfully<br>
1: MYSQL error occurred, error will be in the message<br>
2: Invalid query, this usually means there was not enough information entered to proceed, message will tell you what is missing<br>
3: Invalid API key, the key you specified was not found in the database<br>
4: <Registration> User name already in use.<br>
5: <Login> Password incorrect<br>
6: <Login> Username not found in database<br>

Types:

register:
	returns:
		userid=the userid of the newly created user

	required data:
		GET: key - Your API key
		POST: username
		POST: password

login:
	returns:
		id: The unique Identification digit of the user
		regodate: The unixtime of registration
		lastlogin: Last unixtime the user logged in
	
	required data:
		GET: key - Your API key
		POST: username
		POST: password
		
	The lastlogin is automaticly updated in this method
		
		
changepass:
	required data:
		GET: key - Your API key
		POST: username
		POST: password
		POST: newpassword
		
	You do not need to check the old password before sending this.
		
		
test:
	required data:
		GET: key - Your API key
		
	This can be used to quickly test if your API key is valid