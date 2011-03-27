<?php
/**
 * Returns the token for a user
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.auth.getToken
 * @author oncletom
 */

class Mindmeister_REST_Auth_getToken extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = true;
	const REQUIRES_AUTHENTICATION = false;
	const REQUIRES_ACCESS = '';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.auth.getToken';
	}
	
	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#initParametersMap()
	 */
	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'frob' => array(
				'required' => true,
			),
		);
	}
}