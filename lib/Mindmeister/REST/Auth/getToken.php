<?php

class Mindmeister_REST_Auth_getToken extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = true;
	const REQUIRES_AUTHENTICATION = false;

	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'frob' => array(
				'required' => true,
			),
		);
	}
}