<?php
/**
 * @version $Id$
 * @package    customers
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Nikolai Plath {@link http://www.easy-joomla.org}
 * @author     Created on 18-Jan-2011
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.model' );

/**
 * customers Model
 *
 * @package    customers
 * @subpackage Models
 */
class customerunitsModelmodification_requests extends JModelLegacy
{
	/**
	 * Gets the greetings
	 * @return string The greeting to be displayed to the user
	 */
	function getModificationRequests()
	{
        $unitID = JRequest::getVar("uid");
		$db =& JFactory::getDBO();

		$query = 'SELECT Subject , ModificationData, PossibiltyToDo, Name
        FROM #__ssmodification_request
        inner join #__ssmodification_details on #__ssmodification_details.ModificationRequest_ID = #__ssmodification_request.Id
        inner join #__ssmodification_status on #__ssmodification_status.Id = #__ssmodification_request.ModificationStatus
        and #__ssmodification_request.UnitID = ' . $unitID;
		$db->setQuery( $query );
		$modificationRequests = $db->loadResult();

		return $modificationRequests;
	}// function

}// class
