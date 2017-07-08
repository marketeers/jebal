<?php
/**
 * @version $Id$
 * @package    unitsearch
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Nikolai Plath {@link http://www.easy-joomla.org}
 * @author     Created on 12-Jan-2011
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the unitsearch Component
 *
 * @package    unitsearch
 * @subpackage Views
 */

class reooViewunitdetails extends JViewLegacy
{
    /**
     * unitsearch view display method
     *
     * @return void
     **/
    function display($tpl = null)
    {
        
        //get the unitsearch
        $model = $this->getModel('unitdetails');
        $unitsearch		= $model->search();
        $this->assignRef('results', $unitsearch);
        
        $user =& JFactory::getUser();
        
        
        if($user->id)
        {
            $images = $model->getPimages($unitsearch[0]->pid);
            $this->assignRef('pimages', $images);
        }

        parent::display($tpl);
    }// function
}// class
