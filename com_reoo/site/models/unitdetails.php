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
class reooModelunitdetails extends JModelLegacy
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
		
		
        $query = 'SELECT cstm_ssunits.ID as uid, cstm_ssunits.*, cstm_ssprojects.ID as pid,cstm_ssprojects.*, if(cstm_ssprojects.Name'.$this->_ext.'<>"",cstm_ssprojects.Name'.$this->_ext.',cstm_ssprojects.Name) as Name,
                 if(cstm_ssregions.Name'.$this->_ext.'<>"",cstm_ssregions.Name'.$this->_ext.',cstm_ssregions.Name) as region,
                 if(cstm_sscities.Name'.$this->_ext.'<>"",cstm_sscities.Name'.$this->_ext.',cstm_sscities.Name) as city,
                 if(cstm_ssprovinces.Name'.$this->_ext.'<>"",cstm_ssprovinces.Name'.$this->_ext.',cstm_ssprovinces.Name) as province, '
        . 'if(cstm_sscategories.Name'.$this->_ext.'<>"",cstm_sscategories.Name'.$this->_ext.',cstm_sscategories.Name) as cat,
            if(cstm_sssubcategories.Name'.$this->_ext.'<>"",cstm_sssubcategories.Name'.$this->_ext.',cstm_sssubcategories.Name) as subcat,
            if(cstm_ssfloors.Name'.$this->_ext.'<>"",cstm_ssfloors.Name'.$this->_ext.',cstm_ssfloors.Name) as floor,
             if(cstm_ssfinishinglevels.Name'.$this->_ext.'<>"",cstm_ssfinishinglevels.Name'.$this->_ext.',cstm_ssfinishinglevels.Name) as flevel, '
        . ' if(cstm_ssreservationstatus.Name'.$resStatExt.'<>"",cstm_ssreservationstatus.Name'.$resStatExt.',cstm_ssreservationstatus.Name) as reserv ,
             if(cstm_ssconstructionphases.Name'.$this->_ext.'<>"",cstm_ssconstructionphases.Name'.$this->_ext.',cstm_ssconstructionphases.Name) as const,
             if(cstm_ssconstructionphasedetails.Name'.$this->_ext.'<>"",cstm_ssconstructionphasedetails.Name'.$this->_ext.',cstm_ssconstructionphasedetails.Name) as constdetails,'
        . 'DATE_FORMAT(DATE(cstm_ssprojects.IntialDeliveryDate),"%d-%m-%Y") as IntialDeliveryDate, DATE_FORMAT(DATE(cstm_ssprojects.FinalDeliveryDate),"%d-%m-%Y") as FinalDeliveryDate'
        . ' FROM cstm_ssunits inner join cstm_ssprojects on cstm_ssunits.ProjectID = cstm_ssprojects.ID and cstm_ssunits.ID='.$id
        . ' left join cstm_ssregions on cstm_ssregions.ID = cstm_ssprojects.RegionID  '
        . 'left join cstm_sscities on cstm_sscities.ID = cstm_ssregions.CityID  '
        . 'left join cstm_ssprovinces on cstm_ssprovinces.ID = cstm_sscities.ProvinceID  '
        . 'left join cstm_sscategories on cstm_sscategories.ID = cstm_ssunits.CategoryID  '
        . 'left join cstm_sssubcategories on cstm_sssubcategories.ID = cstm_ssunits.SubcategoryID  '
        . 'left join cstm_ssfloors on cstm_ssfloors.ID = cstm_ssunits.FloorID  '
        . 'left join cstm_ssfinishinglevels on cstm_ssfinishinglevels.ID = cstm_ssunits.FinishingLevelID  '
        . 'left join cstm_ssreservationstatus on cstm_ssreservationstatus.ID = cstm_ssunits.ReservationStatusID  '
        . 'left join cstm_ssconstructionphases on cstm_ssconstructionphases.ID = cstm_ssunits.ConstructionPhaseID  '
        . 'left join cstm_ssconstructionphasedetails on cstm_ssconstructionphasedetails.ID = cstm_ssunits.ConstructionPhaseDetailID  ';

        //die($query);

        $data = $this->_getList( $query );

        return $data;

    }//function

    function getPimages($PID)
    {
	$q = 'select Image from cstm_sspimages where ID = ' . $PID;
	$this->_db->setQuery($q);
 	$data = $this->_db->loadResultArray();
	return $data;
    }

}// class
