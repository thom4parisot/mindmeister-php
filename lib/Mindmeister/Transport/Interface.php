<?php
/**
 * Transport Interface
 * 
 * @author oncletom
 */
interface Mindmeister_Transport_Interface
{
	/**
	 * Initializes the transport and checks for its availability
	 * 
	 * @throws	Mindmeister_Transport_Exception_TransportNotFound
	 */
	public function __construct();

	/**
	 * Retrieves an URL content
	 * 
	 * @throws	Mindmeister_Transport_Exception_StandardError
	 * @param String $url
	 * @return String
	 */
	public function getUrlContent($url);
}