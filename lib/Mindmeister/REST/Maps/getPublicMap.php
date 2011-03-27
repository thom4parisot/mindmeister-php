<?php
/**
 * Get all ideas of a public map
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.maps.getPublicMap
 * @author oncletom
 */

class Mindmeister_REST_Maps_getPublicMap extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = false;
	const REQUIRES_AUTHENTICATION = false;
	const REQUIRES_ACCESS = '';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.maps.getPublicMap';
	}

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#initParametersMap()
	 */
	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'map_id' => array(
				'required' => true,
			),
		);
	}
}