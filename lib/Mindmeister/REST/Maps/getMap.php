<?php
/**
 * Get all ideas of a map
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.maps.getMap
 * @author oncletom
 */

class Mindmeister_REST_Maps_getMap extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = true;
	const REQUIRES_AUTHENTICATION = true;
	const REQUIRES_ACCESS = 'read';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.maps.getMap';
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
			'expand_people' => array(
				'required' => false,
			),
			'include_folder' => array(
				'required' => false,
			),
			'include_theme' => array(
				'required' => false,
			),
			'revision' => array(
				'required' => false,
			),
		);
	}
}