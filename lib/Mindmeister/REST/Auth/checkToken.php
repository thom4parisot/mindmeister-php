<?php
/**
 * Checks if an auth token is valid
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.auth.checkToken
 * @author oncletom
 */

class Mindmeister_REST_Auth_checkToken extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = true;
	const REQUIRES_AUTHENTICATION = false;
	const REQUIRES_ACCESS = '';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.auth.checkToken';
	}

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#initParametersMap()
	 */
	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'auth_token' => array(
				'required' => true,
			),
		);
	}
}