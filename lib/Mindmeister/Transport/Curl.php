<?php
/**
 * Uses PHP Curl functions
 * 
 * @author oncletom
 */
class Mindmeister_Transport_Curl implements Mindmeister_Transport_Interface
{
	private $_ch;
	
	/**
	 * @throws	Mindmeister_Transport_Exception_TransportNotFound
	 */
	public function __construct()
	{
		if (!function_exists('curl_init'))
		{
			throw new Mindmeister_Transport_Exception_TransportNotFound('cURL transport not found. Install php5-curl or whatever library providing curl_init functions.');
		}

		$this->_ch = curl_init();
	}
	
	/**
	 * @throws	Mindmeister_Transport_Exception_StandardError
	 * @see lib/Mindmeister/Transport/Mindmeister_Transport_Interface#getUrlContent($url)
	 */
	public function getUrlContent($url)
	{
		curl_setopt_array($this->_ch, array(
			CURLOPT_HEADER => false,
			CURLOPT_HTTPGET => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
		));

		$response = curl_exec($this->_ch);

		if (false === $response)
		{
			throw new Mindmeister_Transport_Exception_StandardError(curl_error($this->_ch));
		}
		else
		{
			return $response;
		}
	}
	
	/**
	 * Automatically closes the curl resource if available
	 */
	public function __destruct()
	{
		if (is_resource($this->_ch))
		{
			curl_close($this->_ch);
			unset($this->_ch);
		}
	}
}