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

jimport( 'joomla.application.component.model' );

/**
 * unitsearch Model
 *
 * @package    unitsearch
 * @subpackage Models
 */
class unitsearchsModelunitdetails extends JModelLegacy
{
    function  __construct() {
        parent::__construct();
        $this->_ext="";
        $curLang = JFactory::getLanguage()->_lang;
        if($curLang == "en-GB")
            $this->_ext = "_trans";


    }

    /**
     * Method to get a record
     * @return object with data
     */
    function search()
    {
        $id = JRequest::getvar("uid");
        $resStatExt = ($this->_ext == "_trans")? "_en" : "_ara";
		
		
        $query = 'SELECT #__ssunits.ID as uid, #__ssunits.*, #__ssprojects.ID as pid,#__ssprojects.*, if(#__ssprojects.Name'.$this->_ext.'<>"",#__ssprojects.Name'.$this->_ext.',#__ssprojects.Name) as Name,
                 if(#__ssregions.Name'.$this->_ext.'<>"",#__ssregions.Name'.$this->_ext.',#__ssregions.Name) as region,
                 if(#__sscities.Name'.$this->_ext.'<>"",#__sscities.Name'.$this->_ext.',#__sscities.Name) as city,
                 if(#__ssprovinces.Name'.$this->_ext.'<>"",#__ssprovinces.Name'.$this->_ext.',#__ssprovinces.Name) as province, '
        . 'if(#__sscategories.Name'.$this->_ext.'<>"",#__sscategories.Name'.$this->_ext.',#__sscategories.Name) as cat,
            if(#__sssubcategories.Name'.$this->_ext.'<>"",#__sssubcategories.Name'.$this->_ext.',#__sssubcategories.Name) as subcat,
            if(#__ssfloors.Name'.$this->_ext.'<>"",#__ssfloors.Name'.$this->_ext.',#__ssfloors.Name) as floor,
             if(#__ssfinishinglevels.Name'.$this->_ext.'<>"",#__ssfinishinglevels.Name'.$this->_ext.',#__ssfinishinglevels.Name) as flevel, '
        . ' if(#__ssreservationstatus.Name'.$resStatExt.'<>"",#__ssreservationstatus.Name'.$resStatExt.',#__ssreservationstatus.Name) as reserv ,
             if(#__ssconstructionphases.Name'.$this->_ext.'<>"",#__ssconstructionphases.Name'.$this->_ext.',#__ssconstructionphases.Name) as const,
             if(#__ssconstructionphasedetails.Name'.$this->_ext.'<>"",#__ssconstructionphasedetails.Name'.$this->_ext.',#__ssconstructionphasedetails.Name) as constdetails,'
        . 'DATE_FORMAT(DATE(#__ssprojects.IntialDeliveryDate),"%d-%m-%Y") as IntialDeliveryDate, DATE_FORMAT(DATE(#__ssprojects.FinalDeliveryDate),"%d-%m-%Y") as FinalDeliveryDate'
        . ' FROM #__ssunits inner join #__ssprojects on #__ssunits.ProjectID = #__ssprojects.ID and #__ssunits.ID='.$id
        . ' left join #__ssregions on #__ssregions.ID = #__ssprojects.RegionID  '
        . 'left join #__sscities on #__sscities.ID = #__ssregions.CityID  '
        . 'left join #__ssprovinces on #__ssprovinces.ID = #__sscities.ProvinceID  '
        . 'left join #__sscategories on #__sscategories.ID = #__ssunits.CategoryID  '
        . 'left join #__sssubcategories on #__sssubcategories.ID = #__ssunits.SubcategoryID  '
        . 'left join #__ssfloors on #__ssfloors.ID = #__ssunits.FloorID  '
        . 'left join #__ssfinishinglevels on #__ssfinishinglevels.ID = #__ssunits.FinishingLevelID  '
        . 'left join #__ssreservationstatus on #__ssreservationstatus.ID = #__ssunits.ReservationStatusID  '
        . 'left join #__ssconstructionphases on #__ssconstructionphases.ID = #__ssunits.ConstructionPhaseID  '
        . 'left join #__ssconstructionphasedetails on #__ssconstructionphasedetails.ID = #__ssunits.ConstructionPhaseDetailID  ';

        //die($query);

        $data = $this->_getList( $query );

        return $data;

    }//function

    function getPimages($PID)
    {
	$q = 'select Image from #__sspimages where ID = ' . $PID;
	$this->_db->setQuery($q);
 	$data = $this->_db->loadResultArray();
	return $data;
    }

}// class
