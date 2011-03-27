<?php
/**
 * Returns list of public maps.
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.maps.getPublicList
 * @author oncletom
 */

class Mindmeister_REST_Maps_getPublicList extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = false;
	const REQUIRES_AUTHENTICATION = false;
	const REQUIRES_ACCESS = '';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.maps.getPublicList';
	}

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#initParametersMap()
	 */
	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'order' => array(
				'required' => false,
				'possible_values' => array('recent', 'viewed', 'rating'),
			),
			'page' => array(
				'required' => false,
			),
			'per_page' => array(
				'required' => false,
			),
			'search' => array(
				'required' => false,
			),
		);
	}
}