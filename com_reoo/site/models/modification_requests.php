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
        FROM cstm_ssmodification_request
        inner join cstm_ssmodification_details on cstm_ssmodification_details.ModificationRequest_ID = cstm_ssmodification_request.Id
        inner join cstm_ssmodification_status on cstm_ssmodification_status.Id = cstm_ssmodification_request.ModificationStatus
        and cstm_ssmodification_request.UnitID = ' . $unitID;
		$db->setQuery( $query );
		$modificationRequests = $db->loadResult();

		return $modificationRequests;
	}// function

}// class
