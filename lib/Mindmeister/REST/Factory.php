<?php
/**
 * Mindmeister REST configuration
 * 
 * @author oncletom
 * @todo	Add a setEndpoints method
 */
class Mindmeister_REST_Factory
{
	/**
	 * @var Mindmeister_REST_Configuration
	 */
	private $_configuration;

	/**
	 * Construct a new REST object
	 * 
	 * @private
	 * @param Mindmeister_REST_Configuration $configuration
	 * @return unknown_type
	 */
	private function __construct(Mindmeister_REST_Configuration $configuration)
	{
		$this->_configuration = $configuration;
	}
	
	/**
	 * Builds a new Mindmeister REST object
	 * 
	 * Initializes the autolaoder if needed
	 * 
	 * @static
	 * @param $api_key	String	Mindmeister API key
	 * @param $secret		String	Mindmeister shared secret
	 * @return Mindmeister_REST_Factory
	 */
	public static function initialize($api_key, $secret)
	{
		if (!class_exists('Mindmeister_Autoload'))
		{
			require dirname(__FILE__).'/../Autoload.php';
			new Mindmeister_Autoload();
		}
		
		$mm = new Mindmeister_REST_Factory(new Mindmeister_REST_Configuration($api_key, $secret));
		return $mm;
	}

	/**
	 * Returns the configuration object
	 * 
	 * @return Mindmeister_REST_Configuration
	 */
	public function getConfiguration()
	{
		return $this->_configuration;
	}
	
	/**
	 * Returns true if the configuration setting is authenticated
	 * 
	 * @return Boolean
	 */
	public function isAuthenticated()
	{
		return $this->_configuration->isAuthenticated();
	}
	
	/**
	 * Prepares an HTTP request for Mindmeister API
	 * 
	 * @param String $method
	 * @return Mindmeister_REST_Request
	 */
	public function request($method)
	{
		return new Mindmeister_REST_Request($this->_configuration, $method);
	}
}