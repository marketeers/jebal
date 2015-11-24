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
class reooModelpayments extends JModelLegacy
{
	/**
	 * Gets the greetings
	 * @return string The greeting to be displayed to the user
	 */
	function getPayments()
	{
        $contractID = JRequest::getVar("id");
		$db =& JFactory::getDBO();

		$query = 'SELECT sum( cstm_sspayments.Amount ) AS paid
                  FROM cstm_ssinstallments
                  INNER JOIN cstm_sspayments ON cstm_sspayments.installmentID = cstm_ssinstallments.ID
                  and cstm_ssinstallments.ContractID =' . $contractID;
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

		$query = 'SELECT cstm_ssinstallments.Amount,if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(cstm_ssinstallments.Date),"%d-%m-%Y") as idate
                  FROM cstm_ssinstallments left join cstm_sspayments on cstm_sspayments.installmentID = cstm_ssinstallments.ID
                  where cstm_ssinstallments.ContractID='. $contractID . ' and cstm_sspayments.ID is NULL order by cstm_ssinstallments.Date';

        $query = '(SELECT cstm_ssinstallments.Amount, if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(cstm_ssinstallments.Date),"%d-%m-%Y") as idate , "0" as pamount, cstm_ssinstallments.Date
                  FROM cstm_ssinstallments left join cstm_sspayments on cstm_sspayments.installmentID = cstm_ssinstallments.ID
                  where cstm_ssinstallments.ContractID= '. $contractID . ' and cstm_sspayments.ID is NULL order by cstm_ssinstallments.Date)
                    union
                    (SELECT cstm_ssinstallments.amount,if(Type'.$ext.'<>"",Type'.$ext.',Type) as Type,DATE_FORMAT(DATE(cstm_ssinstallments.Date),"%d-%m-%Y") as idate, sum( cstm_sspayments.amount ) AS pamount, cstm_ssinstallments.Date
                    FROM cstm_ssinstallments
                    LEFT JOIN cstm_sspayments ON cstm_sspayments.installmentID = cstm_ssinstallments.ID
                    WHERE cstm_ssinstallments.ContractID ='. $contractID . '
                    GROUP BY cstm_ssinstallments.ID
                    HAVING pamount <> cstm_ssinstallments.amount)
                    order by date';
        //mysql_query("set sql_big_selects=1");
		$db->setQuery( $query );
		$customerid = $db->loadObjectList();

		return $customerid;

    }
}// class
