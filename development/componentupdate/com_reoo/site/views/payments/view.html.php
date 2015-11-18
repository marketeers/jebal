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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the customers Component
 *
 * @package    customers
 * @subpackage Views
 */

class customersViewpayments extends JViewLegacy
{
    /**
     * customers view display method
     * @return void
     **/
	function display($tpl = null)
	{
        $model = $this->getModel('payments');
        $payments = $model->getPayments();
        $installments = $model->getInstallments();

		//$this->assignRef( 'payments',	$payments );
        $this->assignRef( 'installments',	$installments );

		parent::display($tpl);
	}
}// class
