<?php
/**
 * Returns the list of maps of the current user
 * 
 * @see		http://www.mindmeister.com/fr/services/api/explore_method?method=mm.maps.getList
 * @author oncletom
 */

class Mindmeister_REST_Maps_getList extends Mindmeister_REST_RequestBase
{
	const REQUIRES_SIGNING = true;
	const REQUIRES_AUTHENTICATION = true;
	const REQUIRES_ACCESS = 'read';

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#getMethod()
	 */
	public function getMethod()
	{
		return 'mm.maps.getList';
	}

	/**
	 * @see lib/Mindmeister/REST/Mindmeister_REST_RequestBase#initParametersMap()
	 */
	public function initParametersMap()
	{
		$this->_parametersMap = array(
			'expand_people' => array(
				'required' => false,
			),
			'include_folder' => array(
				'required' => false,
			),
			'page' => array(
				'required' => false,
			),
			'per_page' => array(
				'required' => false,
			),
			'query' => array(
				'required' => false,
			),
		);
	}
}