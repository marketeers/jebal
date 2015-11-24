<?php
/**
 * @version $Id$
 * @package    projects
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     heba nasr {@link http://www.easy-joomla.org}
 * @author     Created on 03-Jan-2011
 */

//-- No direct access
defined('_JEXEC') or die('=;)');


/**
 * projects Table class
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class Tablecompanies extends JTable
{
	var $ID = null;
	var $Name = null;
	/**
     *
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function Tablecompanies(& $db) {
		parent::__construct('#__sscompanies', 'ID', $db);
	}
}
?>
