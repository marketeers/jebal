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
class reooModelunitsearchs extends JModelLegacy
{
    function  __construct() {
        parent::__construct();
        $this->_ext="";
        $curLang = JFactory::getLanguage()->_lang;
        if($curLang == "en-GB")
            $this->_ext = "_trans";
    }
	//load provinces
    function getProvinces()
    {
        //die($this->_ext);
        $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__ssprovinces ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load cities
    function getCities()
    {
         $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name,ProvinceID FROM #__sscities ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load regions
    function getRegions()
    {
         $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name,CityID FROM #__ssregions ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load categories
    function getCategories()
    {
         $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__sscategories ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load  floors
    function getFloors()
    {
        $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__ssfloors ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load construction phases
    function getConstructionPhases()
    {
        $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__ssconstructionphases ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load finishing levels
    function getFinishingLevels()
    {
        $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__ssfinishinglevels ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

    //load projects
    function getProjects()
    {
        //$this->_db	    = &JFactory::getDBO();
        $query = ' SELECT ID,if(Name'.$this->_ext.'<>"",Name'.$this->_ext.',Name)as Name FROM #__ssprojects ';
        $this->_db->setQuery( $query );
		return $this->_db->loadAssocList ();
    }

}
