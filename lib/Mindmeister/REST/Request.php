<?php
/**
 * Mindmeister REST request to their API
 * 
 * @author oncletom
 *
 */
class Mindmeister_REST_Request
{
	private $_configuration;
	
	protected static $default_parameters = array(
		'%endpoint%' => 	'',
		'%method%' =>			'',
		'%parameters%' =>	'',
		'%api_sig%' =>		'',
	);

	private $_method;

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
	 * Retrieves the API signature for the current method request
	 * 
	 * @return string	MD5 hash
	 */
	public function getApiSignature()
	{
		$parameters = $this->_method->getParameters();
		ksort($parameters);
		$query = $this->_configuration->getSecret();
		
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
	 * Defines the Request method call
	 * 
	 * @param $method
	 * @return unknown_type
	 */
	protected function setMethod($method)
	{
		$class = 'Mindmeister_REST_'.ucfirst(preg_replace('/^(mm\.)?([^\.]+)\.(.+)$/sU', '\\2_\\3', $method));
		$this->_method = new $class;
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
}