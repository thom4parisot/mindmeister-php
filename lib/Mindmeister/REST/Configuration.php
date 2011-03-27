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
	);
	
	const ENDPOINT_PATTERN = '%endpoint%?method=%method%&api_key=%api_key%%parameters%%api_sig%';
	const ENDPOINT_SIG_PARAMETER = '&api_sig=%s';
	
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
	 * @return unknown_type
	 */
	public function getAuthToken()
	{
		if (!$this->_auth_token)
		{
			
		}
		
		return $this->_auth_token;
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
	public function getEndpointUrl()
	{
		return self::$endpoints[$this->_endpoint];
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