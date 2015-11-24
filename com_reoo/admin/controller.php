<?php


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class importController extends JControllerLegacy
{
    function __construct()
    {
        parent::__construct();
    }

    function import()
    {
        $model = $this->getModel('import');
        $file = JRequest::getVar('file',null,'files','array');
        $passedChecks = true;
        $msg = $model->import($file,$passedChecks);

        echo $msg ."<br /><br />";
        parent::display();
    }

    function clear()
    {
        $model = $this->getModel('import');
        $msg = $model->clear();

        echo $msg ."<br /><br />";
        parent::display();
    }

    /**
     * Method to display the view
     *
     * @access	public
     */
    function display()
    {
        parent::display();
    }
    
}
