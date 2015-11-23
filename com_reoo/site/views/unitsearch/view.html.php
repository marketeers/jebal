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

class reooViewunitsearch extends JViewLegacy
{
    /**
     * unitsearch view display method
     *
     * @return void
     **/
    function display($tpl = null)
    {
        //get the unitsearch
        $model = $this->getModel('unitsearch');
        $unitsearch		= $model->search();
        $this->assignRef('results', $unitsearch);

        parent::display($tpl);
    }// function
}// class
