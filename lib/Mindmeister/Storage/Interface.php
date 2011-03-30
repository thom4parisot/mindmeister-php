<?php
/**
 * Storage Interface
 * 
 * @author oncletom
 */
interface Mindmeister_Storage_Interface
{
	/**
	 * Builds a new storage upon configuration
	 * 
	 * @param Mindmeister_REST_Configuration $configuration
	 */
	public function __construct(Mindmeister_REST_Configuration $configuration);

	/**
	 * Returns the auth Token from storage
	 * 
	 * @return String
	 */
	public function getAuthToken();

	/**
	 * Stores the token in filesystem
	 * 
	 * @param String $token
	 */
	public function setAuthToken($token);
}