<?php

/**
 * @version $Id$
 * @package    subscriptionfees
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     heba nasr {@link http://www.easy-joomla.org}
 * @author     Created on 03-Oct-2010
 */
//-- No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.view');

/**
 * HTML View class for the subscriptionfees Component
 *
 * @package    subscriptionfees
 * @subpackage Views
 */
class importViewcompanieslist extends JViewLegacy {

    /**
     * subscriptionfeess view display method
     * @return void
     * */
    function display($tpl = null) {
        JSubMenuHelper::addEntry(JText::_('Import file'), 'index.php?option=com_reoo&view=import');
        JSubMenuHelper::addEntry(JText::_('Companies'), 'index.php?option=com_reoo',TRUE);
        JToolBarHelper::title(JText::_('Companies List'), 'generic.png');
        
        JToolBarHelper::deleteList();
        JToolBarHelper::addNew();
        JToolBarHelper::editList();

        // Get data from the model
        
        $this->items = &$this->get('Data');
       
        $this->pagination = &$this->get('Pagination');
        $this->state = &$this->get('State');

        $this->assignRef('items', $this->items);

        parent::display($tpl);
    }

}
