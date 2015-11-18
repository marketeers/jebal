<?php



// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
 
ini_set('display_errors','on');

 // Require specific controller if requested
if( $controller = JRequest::getWord('controller'))
{
   $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if( file_exists($path))
	{
		require_once $path;
	} else
	{
		$controller = '';
	}
}
else
{
		$controller = 'import';
}


// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance($controller);
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

