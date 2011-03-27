<?php
/**
 * Mindmeister REST configuration
 * 
 * @author oncletom
 * @todo	Add a setEndpoints method
 */
class Mindmeister_REST_Configuration
{
	private $_api_key;
	private $_auth_token;
	private $_frob;
	private	$_secret;
	private $_endpoint = 'https';
	
	protected static $endpoints = array(
		'http' 	=> 'http://www.mindmeister.com/services/rest/',
		'https' => 'https://www.mindmeister.com/services/rest/',
		'auth' 	=> 'http://www.mindmeister.com/services/auth/',
	);

	/**
	 * Builds a new Mindmeister REST configuration
	 * 
	 * @see		http://www.mindmeister.com/users/myaccount/api
	 * @param $api_key	String	Mindmeister API key
	 * @param $secret		String	Mindmeister shared secret
	 */
	public function __construct($api_key, $secret)
	{
		$this->_api_key = $api_key;
		$this->_secret =	$secret;
		$this->_auth_token = $this->getAuthToken();
	}
	
	/**
	 * Returns the current API key
	 * 
	 * @return String
	 */
	public function getApiKey()
	{
		return $this->_api_key;	
	}
	
	/**
	 * Returns the authentication token
	 * 
	 * @return String|null
	 */
	public function getAuthToken()
	{
		if (!$this->isAuthenticated())
		{
			$auth_token = $this->readAuthToken();
		}
		else
		{
			$auth_token = $this->_auth_token;
		}
		
		return $auth_token;
	}
	
	/**
	 * Retrieves an auth token URl for a given frob
	 * 
	 * @param String $frob
	 * @return String
	 */
	public function getAuthTokenUrl($frob, $perms = 'read')
	{
		$parameters = array(
			'api_key' => $this->_api_key,
			'perms' => $perms,
			'frob' => $frob,
		);

		return sprintf('%s?%s&api_sig=%s',
			$this->getEndpointUrl('auth'),
			http_build_query($parameters),
			Mindmeister_REST_Request::signParameters($this, $parameters)
		);
	}
	
	/**
	 * Returns the current shared secret
	 * 
	 * @return String
	 */
	public function getSecret()
	{
		return $this->_secret;
	}
	
	/**
	 * Returns the Endpoint pattern for further replacements
	 * 
	 * @return String
	 */
	public function getEndpointPattern()
	{
		return self::ENDPOINT_PATTERN;
	}
	
	/**
	 * Retrieves Endpoint Url
	 * 
	 * @param $endpoint	String Endpoint ID
	 * @return String Endpoint URL
	 */
	public function getEndpointUrl($endpoint = null)
	{
		return self::$endpoints[null === $endpoint ? $this->_endpoint : $endpoint];
	}
	
	/**
	 * Returns if the system is authenticated for the current API key
	 * 
	 * @return Boolean
	 */
	public function isAuthenticated()
	{
		return null === $this->_auth_token ? false : true;
	}
	
	/**
	 * Reads a token from memory
	 * 
	 * @todo make directory configurable
	 * @todo abstract to read the token from other backend (memcache, apc etc.)
	 * @return String
	 */
	private function readAuthToken()
	{
		$auth_token = null;
		$file = sprintf('%s/%s', sys_get_temp_dir(), md5($this->_api_key.$this->_secret));

		if (file_exists($file))
		{
			$auth_token = trim(file_get_contents($file));
		}

		return $auth_token;
	}
	
	private function writeAuthToken($token)
	{
		$file = sprintf('%s/%s', sys_get_temp_dir(), md5($this->_api_key.$this->_secret));
		file_put_contents($file, $token);
	}
	
	public function setAuthToken($token, $persist = false)
	{
		$this->_auth_token = $token;
		
		if (true === $persist)
		{
			$this->writeAuthToken($token);
		}
	}
	
	/**
	 * Sets an Endpoint identifier
	 * 
	 * @param $endpoint	String Endpoint identifier
	 */
	public function setEndpoint($endpoint)
	{
		if (!isset(self::$endpoints[$endpoint]))
		{
			//@todo UnknownEndpointException
		}
		
		$this->_endpoint = $endpoint;
	}
}