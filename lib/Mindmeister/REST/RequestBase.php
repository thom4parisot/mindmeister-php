<?php
/**
 * Base methods for any REST Request, to handle parameters
 * 
 * @abstract
 * @author oncletom
 */
abstract class Mindmeister_REST_RequestBase
{
	private $_parameters = array();
	protected $_parametersMap = array();
	
	/**
	 * Initializes the Parameters Map
	 * @return unknown_type
	 */
	abstract public function initParametersMap();
	
	abstract public function getMethod();
	
	/**
	 * 
	 */
	//abstract public function initErrorCodes();
	
	/**
	 * Initializes the expected response parameter
	 */
	//abstract public function initResponseParameters();
	
	/**
	 * Builds a new API Request
	 */
	public function __construct()
	{
		$this->initParametersMap();
	}
	
	/**
	 * Returns if the request needs a special access
	 * 
	 * @return String
	 */
	public function getAccess()
	{
		return (string)constant(sprintf('%s::REQUIRES_ACCESS', get_class($this)));
	}
	
	/**
	 * Returns if the request needs authentication
	 * 
	 * @return Boolean
	 */
	public function requiresAuthentication()
	{
		return (bool)constant(sprintf('%s::REQUIRES_AUTHENTICATION', get_class($this)));
	}
	
	/**
	 * Returns if the request needs a signing
	 * 
	 * @return Boolean
	 */
	public function requiresSigning()
	{
		return (bool)constant(sprintf('%s::REQUIRES_SIGNING', get_class($this)));
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getParameters()
	{
		return $this->_parameters;
	}
	
	/**
	 * 
	 * @param $key
	 * @param $value
	 * @return unknown_type
	 */
	public function setParameter($key, $value)
	{
		$this->_parameters[$key] = (string)$value;
	}
	
	/**
	 * 
	 * @param array $parameters
	 * @return unknown_type
	 */
	public function setParameters(array $parameters)
	{
		$this->_parameters = $parameters;
	}
}