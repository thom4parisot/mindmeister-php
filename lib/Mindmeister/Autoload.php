<?php
/**
 * Mindmeister API Autoload
 * 
 * Enables to autoload child class more easily
 * 
 * @author oncletom
 */
class Mindmeister_Autoload
{
	const SEPARATOR = '_';
	const PREFIX		= 'Mindmeister';

	/**
	 * Activates the autoloader by calling the class
	 */
	public function __construct()
	{
		spl_autoload_register(array($this, 'autoloader'));
	}
	
	/**
	 * Loads all 'Mindmeister_<Class>.php' files magically
	 * 
	 * @private
	 * @param $className	String	Classname called, provided by the SPL library
	 */
	private function autoloader($className)
	{
		if(0 === strpos($className, self::PREFIX))
		{
			$path = dirname(__FILE__).'/../'.str_replace('_', '/', $className).'.php';
			require $path;
		}
	}
}