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
class importViewimport extends JViewLegacy {

    /**
     * subscriptionfeess view display method
     * @return void
     * */
    function display($tpl = null) {
        JSubMenuHelper::addEntry(JText::_('Import file'), 'index.php?option=com_reoo', true);
        JSubMenuHelper::addEntry(JText::_('Companies'), 'index.php?option=com_reoo&view=companieslist');
        JToolBarHelper::title(JText::_('Import structure file'), 'generic.png');

       //JToolBarHelper :: custom( 'test', 'archive.png', 'iconname.png', 'Test', true, false );
        
        $model = $this->getModel("import");
        $items = $model->getcompanies();
        $this->assignRef('companies', $items);
        
        parent::display($tpl);
    }

}
