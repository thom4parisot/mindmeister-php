<?php

abstract class Mindmeister_REST_RequestBase
{
	private $_parameters = array();
	protected $_parametersMap = array();
	
	/**
	 * Initializes the Parameters Map
	 * @return unknown_type
	 */
	abstract public function initParametersMap();
	
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