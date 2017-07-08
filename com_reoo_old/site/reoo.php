<?php

ini_set('display_errors','off');

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if(!JFactory::getUser()->id)
{
    JFactory::getApplication()->redirect("index.php");
}

// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('reoo');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

