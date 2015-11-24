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


		$query = 'SELECT cstm_sscontracts.ID as CID,cstm_sscontracts.UnitID as ID,cstm_sscontracts.TotalValue, if(cstm_ssconstructionphases.Name'.$ext.'<>"",cstm_ssconstructionphases.Name'.$ext.',cstm_ssconstructionphases.Name) as ConstructionPhase,cstm_ssunits.PlotNumber,
                    if(cstm_ssprojects.Name'.$ext.'<>"",cstm_ssprojects.Name'.$ext.',cstm_ssprojects.Name) as Name, "1" as paid, "1" as inst
                    FROM cstm_sscustomers inner join cstm_sscontracts on cstm_sscustomers.ID = cstm_sscontracts.CustomerID
                    LEFT join cstm_ssunits on cstm_ssunits.ID = cstm_sscontracts.UnitID
                    LEFT join cstm_ssprojects on cstm_ssprojects.ID = cstm_ssunits.ProjectID
                    LEFT join cstm_ssconstructionphases on cstm_ssconstructionphases.ID = cstm_ssunits.ConstructionPhaseID
                    WHERE cstm_sscontracts.CustomerID=' . $customerID;
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

		$query = 'SELECT ID FROM cstm_sscustomers where userid='. $joomlauserid;
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

		$query = 'SELECT count(cstm_ssinstallments.ID)
                  FROM cstm_ssinstallments left join cstm_sspayments on cstm_sspayments.installmentID = cstm_ssinstallments.ID
                  where cstm_ssinstallments.ContractID='. $contractID . ' and cstm_sspayments.ID is NULL';
		$db->setQuery( $query );
		$Installments1 = $db->loadResult();
		//die($Installments1 );
		
  		$db->setQuery('SET SQL_BIG_SELECTS=1');
                $db->query();
        $query = 'SELECT count(cstm_ssinstallments.ID), sum( cstm_sspayments.amount ) AS pamount,cstm_ssinstallments.amount
                FROM cstm_ssinstallments
                LEFT JOIN cstm_sspayments ON cstm_sspayments.installmentID = cstm_ssinstallments.ID
                WHERE cstm_ssinstallments.ContractID ='. $contractID . '
                GROUP BY cstm_ssinstallments.ID
                HAVING pamount <> cstm_ssinstallments.amount';

		//die( $query);
		$Installments2 = $db->loadResult();

		return $Installments1 + $Installments2;
	}// function
}// class
