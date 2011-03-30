<?php
/**
 * Deals the storage in temporary files
 * 
 * @author oncletom
 */
class Mindmeister_Storage_TmpFile implements Mindmeister_Storage_Interface
{
	private $_configuration;

	public function __construct(Mindmeister_REST_Configuration $configuration)
	{
		$this->_configuration = $configuration;
	}

	/**
	 * Retrieves the Auth Token filename
	 * 
	 * @private
	 * @return String
	 */
	private function getAuthTokenFilename()
	{
		return sprintf('%s/%s', sys_get_temp_dir(), md5($this->_configuration->getApiKey().$this->_configuration->getSecret()));
	}
	
	/**
	 * @todo throw an exception if file not found?
	 * @return String
	 */
	public function getAuthToken()
	{
		$file = $this->getAuthTokenFilename();

		if (file_exists($file))
		{
			return trim((string)file_get_contents($file));
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @throws	Mindmeister_Storage_Exception_StandardError
	 * @param String $auth_token
	 */
	public function setAuthToken($auth_token)
	{
		if (false === file_put_contents($this->getAuthTokenFilename(), $auth_token))
		{
			throw new Mindmeister_Storage_Exception_StandardError(sprintf('Could not write to "%s"', $this->getAuthTokenFilename()));
		}
	}
	
	/**
	 * Destructs object
	 */
	public function __destruct()
	{
		unset($this->_configuration);
	}
}