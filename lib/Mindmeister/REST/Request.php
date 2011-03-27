<?php
/**
 * Mindmeister REST request to their API
 * 
 * @author oncletom
 *
 */
class Mindmeister_REST_Request
{
	/**
	 * @var Mindmeister_REST_Configuration
	 */
	private $_configuration;

	/**
	 * @var Mindmeister_REST_RequestBase
	 */
	private $_method;
	
	/**
	 * @var String
	 */
	private $_request_url;

	/**
	 * Constructs a new API Request
	 * 
	 * @param Mindmeister_REST_Configuration $configuration
	 * @param String $method Mindmeister API method (as seen on http://www.mindmeister.com/services/api/explore)
	 * @return unknown_type
	 */
	public function __construct(Mindmeister_REST_Configuration $configuration, $method)
	{
		$this->_configuration = $configuration;
		$this->setMethod($method);
	}
	
	/**
	 * Executes the request
	 * 
	 * @todo	abstract the remote call
	 * @todo handling authentication
	 * @return Mindmeister_REST_Response
	 */
	public function dispatch()
	{
		$url = sprintf('%s?%s',
			$this->_configuration->getEndpointUrl(),
			http_build_query($this->getParameters())
		);

		if ($this->_method->requiresSigning())
		{
			$url .= sprintf('&api_sig=%s', $this->getApiSignature());
		}
		
		$this->_request_url = $url;
		$raw_response = $this->processRequest($url);
		return new Mindmeister_REST_Response($this, $raw_response);
	}
	
	/**
	 * Retrieves the API signature for the current method request
	 * 
	 * @return string	MD5 hash
	 */
	public function getApiSignature()
	{
		return self::signParameters($this->_configuration, $this->getParameters());
	}
	
	/**
	 * Sign parameters for a given configuration
	 * 
	 * @param Mindmeister_REST_Configuration $configuration
	 * @param Array $parameters
	 * @return String
	 */
	public static function signParameters(Mindmeister_REST_Configuration $configuration, array $parameters)
	{
		ksort($parameters);
		$query = $configuration->getSecret();

		if (!empty($parameters))
		{
			foreach ($parameters as $key => $value)
			{
				$query .= $key.$value;
			}
		}
		
		return md5($query);
	}
	
	/**
	 * Process the request and gives back the result
	 * 
	 * @todo check if curl_init is available
	 * @param $url
	 * @return String XML Response
	 */
	private function processRequest($url)
	{
		$curl = curl_init($url);
		curl_setopt_array($curl, array(
			CURLOPT_HEADER => false,
			CURLOPT_HTTPGET => true,
			CURLOPT_RETURNTRANSFER => true,
		));
		$response = curl_exec($curl);
		curl_close($curl);
		
		return $response;
	}
	
	/*
	 * METHOD
	 */
	/**
	 * Returns the API method object
	 * 
	 * @return Mindmeister_REST_RequestBase
	 */
	public function getMethod()
	{
		return $this->_method;
	}
	
	/**
	 * Defines the Request method call
	 * 
	 * @private
	 * @param $method
	 */
	private function setMethod($method)
	{
		$class = 'Mindmeister_REST_'.ucfirst(preg_replace('/^(mm\.)?([^\.]+)\.(.+)$/sU', '\\2_\\3', $method));
		$this->_method = new $class;
	}
	
	/*
	 * PARAMETERS
	 */
	
	/**
	 * Retrieves all request parameters, including the method ones
	 * 
	 * @return Array
	 */
	public function getParameters()
	{
		$parameters = array(
			'api_key' =>	$this->_configuration->getApiKey(),
			'method' =>		$this->_method->getMethod(),
		);
		
		/*
		 * Appending method parameters
		 */
		$p = $this->_method->getParameters();
		if (!empty($p))
		{
			$parameters += $p;
		}
		
		/*
		 * Checking access
		 */
		$access = $this->_method->getAccess();
		if ($access)
		{
			$parameters['access'] = $access;
		}
		
		/*
		 * Adding auth key
		 */
		if ($this->_method->requiresAuthentication())
		{
			$parameters['auth_token'] = $this->_configuration->getAuthToken();
		}
		
		return $parameters;
	}
	
	/**
	 * Proxy for method parameter setting
	 * 
	 * @param array $parameters
	 */
	public function setParameter($key, $value)
	{
		$this->_method->setParameter($key, $value);
	}
	
	/**
	 * Proxy for method parameters setting
	 * 
	 * @param array $parameters
	 */
	public function setParameters(array $parameters)
	{
		$this->_method->setParameters($parameters);
	}
	
	/*
	 * PHP INTERNALS
	 */

	/**
	 * Deconstructs the request
	 */
	public function __destruct()
	{
		unset($this->_method);
		unset($this->_configuration);
	}
}