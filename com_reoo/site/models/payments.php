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
class customersModelpayments extends JModelLegacy
{
	/**
	 * Gets the greetings
	 * @return string The greeting to be displayed to the user
	 */
	function getPayments()
	{
        $contractID = JRequest::getVar("id");
		$db =& JFactory::getDBO();

		$query = 'SELECT sum( #__sspayments.Amount ) AS paid
                  FROM #__ssinstallments
                  INNER JOIN #__sspayments ON #__sspayments.installmentID = #__ssinstallments.ID
                  and #__ssinstallments.ContractID =' . $contractID;
		//die($query);
                $db->setQuery( $query );
		$customerUnits = $db->loadResult();

		return $customerUnits;
	}// function

    function getInstallments()
    {
        $curLang = JFactory::getLanguage()->_lang;
        $ext = "";
        if($curLang == "en-GB")
            $this->_ext = "_trans";
            
        $contractID = JRequest::getVar("id");
        $db =& JFactory::getDBO();
        $db->setQuery('SET SQL_BIG_SELECTS=1');
                $db->query();

		$query = 'SELECT #__ssinstallments.Amount,if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(#__ssinstallments.Date),"%d-%m-%Y") as idate
                  FROM #__ssinstallments left join #__sspayments on #__sspayments.installmentID = #__ssinstallments.ID
                  where #__ssinstallments.ContractID='. $contractID . ' and #__sspayments.ID is NULL order by #__ssinstallments.Date';

        $query = '(SELECT #__ssinstallments.Amount, if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(#__ssinstallments.Date),"%d-%m-%Y") as idate , "0" as pamount, #__ssinstallments.Date
                  FROM #__ssinstallments left join #__sspayments on #__sspayments.installmentID = #__ssinstallments.ID
                  where #__ssinstallments.ContractID= '. $contractID . ' and #__sspayments.ID is NULL order by #__ssinstallments.Date)
                    union
                    (SELECT #__ssinstallments.amount,if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(#__ssinstallments.Date),"%d-%m-%Y") as idate, sum( #__sspayments.amount ) AS pamount, #__ssinstallments.Date
                    FROM #__ssinstallments
                    LEFT JOIN #__sspayments ON #__sspayments.installmentID = #__ssinstallments.ID
                    WHERE #__ssinstallments.ContractID ='. $contractID . '
                    GROUP BY #__ssinstallments.ID
                    HAVING pamount <> #__ssinstallments.amount)
                    order by date';
        //mysql_query("set sql_big_selects=1");
		$db->setQuery( $query );
		$customerid = $db->loadObjectList();

		return $customerid;

    }
}// class
