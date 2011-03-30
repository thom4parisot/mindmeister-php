# Mindmeister PHP #

This library is a PHP wrapper of Mindmeister API, the REST API so far.  
It's goal is to provide an object approach to query Mindmeister and handling
easily the authentication part.

I've initially started this library to deeply embed Mindmeister into WordPress blogs.
That's why it's not PHP 5.3 and thus, there is no namespace usage.

## Requirements ##

* PHP 5.2+
* PHP Curl package ([apt://php5-curl](apt://php5-curl))

## Usage ##
### Creating your application ###
First, [head to your account](http://www.mindmeister.com/users/myaccount/api) 
and [register an API key](http://www.mindmeister.com/services/api/add_key) for 
your application.

The **API key** and the **shared secret** are mandatory to use this library. 

### Authentication ###
The authentication process is not very clear, as [described in the documentation](http://www.mindmeister.com/fr/services/api/auth).

For the desktop process, here is the detailed walkthrough:

1. Retrieve a *frob* (random string) through `mm.auth.getFrob` method
2. Redirect the user to the Auth URL
3. Retrieve the *auth token* through `mm.auth.getToken` method
4. Permanently store the token

Then, for all following API calls, use the *auth token* for the authenticated methods.  
The library automatically append this parameter if needed, in order to avoid thinking about that detail.

The `mm.auth.getToken` will successfully reply only if the Auth URL has been visited.
Otherwise, it will fail.

What the library does not do (yet), is the authentication workflow. 

### Authenticate Application ###

	require 'lib/Mindmeister/REST/Factory.php';
	$mm = Mindmeister_REST_Factory::initialize(API_KEY, SHARED_SECRET);
	
	//lists all maps if authenticated
	if (!$mm->isAuthenticated())
	{
		/*
		 * 1) Retrieving frob
		 */
		$request = $mm->request('mm.auth.getFrob');
		$frob = $request->dispatch()->getValue('frob');

		/*
		 * 2) Visiting Mindmeister Auth URL
		 */
		$url = $mm->getConfiguration()->getAuthTokenUrl($frob);
		fread(STDIN);	//or other mechanism to pause execution while waiting user to visit the URL
		
		/*
		 * 3) Retrieving Auth Token
		 */
		$request = $mm->request('mm.auth.getToken');
		$request->setParameter('frob', $frob);
		$auth_token = $request->dispatch()->getValue('token');
		
		/*
		 * 4) Persisting Auth Token
		 * Second parameter is for persisting (stateless otherwise)
		 */
		$mm->getConfiguration()->setAuthToken($auth_token, true);
		//$mm->isAuthenticated() === true
	}
	

### Querying API ###

	require 'lib/Mindmeister/REST/Factory.php';
	$mm = Mindmeister_REST_Factory::initialize(API_KEY, SHARED_SECRET);
	
	//lists all maps if authenticated
	if ($mm->isAuthenticated())
	{
		$request = $mm->request('mm.maps.getList');
		$response = $request->dispatch();
		
		foreach ($response->getContent()->maps as $map)
		{
			$attributes = $map->attributes();

			//process stuff here
			//$attributes->title, $attributes->description etc.
		}
	}

## Implemented API Methods ##

Expected parameters and results can be found in [Mindmeister API documentation](http://www.mindmeister.com/fr/services/api/explore).

### Auth ###

* mm.auth.checkToken
* mm.auth.getFrob
* mm.auth.getToken

### Maps ###

* mm.maps.getList
* mm.maps.getMap
* mm.maps.getPublicList
* mm.maps.getPublicMap

## TODO ##

* Provide an API for response, to avoid cycling through SimpleXMLElements
* Provide an Auth Token storage backend
* Provide a validation mechanism _before_ dispatching a request
* Implementing Exceptions
* Handling error codes (and mix them with Exceptions mechanism)
* Implement ArrayAccess interface for Response
* Unit Testing