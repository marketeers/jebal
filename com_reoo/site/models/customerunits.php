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
class reooModelcustomerunits extends JModelLegacy
{
	/**
	 * Gets the greetings
	 * @return string The greeting to be displayed to the user
	 */
	function getCustomersUnits()
	{
        $curLang = JFactory::getLanguage()->_lang;
        $ext = "";
        if($curLang == "en-GB")
            $this->_ext = "_trans";
        $customerID = $this->mapCustomer();

		$db =& JFactory::getDBO();


		$query = 'SELECT #__sscontracts.ID as CID,#__sscontracts.UnitID as ID,#__sscontracts.TotalValue, if(#__ssconstructionphases.Name'.$ext.'<>"",#__ssconstructionphases.Name'.$ext.',#__ssconstructionphases.Name) as ConstructionPhase,#__ssunits.PlotNumber,
                    if(#__ssprojects.Name'.$ext.'<>"",#__ssprojects.Name'.$ext.',#__ssprojects.Name) as Name, "1" as paid, "1" as inst
                    FROM #__sscustomers inner join #__sscontracts on #__sscustomers.ID = #__sscontracts.CustomerID
                    LEFT join #__ssunits on #__ssunits.ID = #__sscontracts.UnitID
                    LEFT join #__ssprojects on #__ssprojects.ID = #__ssunits.ProjectID
                    LEFT join #__ssconstructionphases on #__ssconstructionphases.ID = #__ssunits.ConstructionPhaseID
                    WHERE #__sscontracts.CustomerID=' . $customerID;
        //die($query);
		$db->setQuery( $query );
		$customerUnits = $db->loadObjectList();

        foreach ($customerUnits as $unit)
        {
            $unit->paid = $this->getPayments($unit->CID);
        }
        foreach ($customerUnits as $unit)
        {
            $unit->inst = $this->getInstallmentsCount($unit->CID);
        }
        //die ($query);
		return $customerUnits;
	}// function

    function mapCustomer()
    {
        $curuser = &JFactory::getUser();
        $joomlauserid = $curuser->id;
        if ($joomlauserid ==0)  return -1;
        $db =& JFactory::getDBO();

		$query = 'SELECT ID FROM #__sscustomers where userid='. $joomlauserid;
        //die ($query);
		$db->setQuery( $query );
		$customerid = $db->loadResult();
        if(!$customerid) return -1;
		return $customerid;

    }

    function getPayments($contractID)
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT sum( brg_sspayments.Amount ) AS paid
                  FROM brg_ssinstallments
                  INNER JOIN brg_sspayments ON brg_sspayments.installmentID = brg_ssinstallments.ID
                  and brg_ssinstallments.ContractID =' . $contractID;
		$db->setQuery( $query );
		$customerUnits = $db->loadResult();

		return $customerUnits;
	}// function

    function getInstallmentsCount($contractID)
	{
	//die($contractID);

		$db =& JFactory::getDBO();
                $db->setQuery('SET SQL_BIG_SELECTS=1');
                $db->query();

		$query = 'SELECT count(#__ssinstallments.ID)
                  FROM #__ssinstallments left join #__sspayments on #__sspayments.installmentID = #__ssinstallments.ID
                  where #__ssinstallments.ContractID='. $contractID . ' and #__sspayments.ID is NULL';
		$db->setQuery( $query );
		$Installments1 = $db->loadResult();
		//die($Installments1 );
		
  		$db->setQuery('SET SQL_BIG_SELECTS=1');
                $db->query();
        $query = 'SELECT count(#__ssinstallments.ID), sum( #__sspayments.amount ) AS pamount,#__ssinstallments.amount
                FROM #__ssinstallments
                LEFT JOIN #__sspayments ON #__sspayments.installmentID = #__ssinstallments.ID
                WHERE #__ssinstallments.ContractID ='. $contractID . '
                GROUP BY #__ssinstallments.ID
                HAVING pamount <> #__ssinstallments.amount';

		//die( $query);
		$Installments2 = $db->loadResult();

		return $Installments1 + $Installments2;
	}// function
}// class
