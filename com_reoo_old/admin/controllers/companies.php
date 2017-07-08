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

jimport('joomla.application.component.controller');

/**
 * projects Controller
 *
 * @package    projects
 * @subpackage Controllers
 */
class companiesController extends JControllerForm
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add' , 'edit' );
	}// function

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'companies' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}// function

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('companies');
        $cid = JRequest::getVar('ID');
        
		if ($model->store()) {
			$msg = JText::_( 'Item Saved!' );
            $link = 'index.php?option=com_reoo&view=companieslist';
		} else {
			$msg = JText::_( 'Error Saving Item.' ). "  " .$model->getError();
            $link = 'index.php?option=com_reoo&controller=companies&task=edit&cid='.$cid;
		}

		// Check the table in so it can be edited.... we are done with it anyway
		
		$this->setRedirect($link, $msg);
	}// function

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('companies');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Items Could not be Deleted...'  .$model->getError());
		} else {
			$msg = JText::_( 'Item(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_reoo', $msg );
	}// function

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_reoo', $msg );
	}// function
}// class
