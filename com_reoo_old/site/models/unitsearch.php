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

jimport('joomla.application.component.model');

/**
 * unitsearch Model
 *
 * @package    unitsearch
 * @subpackage Models
 */
class reooModelunitsearch extends JModelLegacy {

    /**
     * Constructor that retrieves the ID from the request
     *
     * @access	public
     * @return	void
     */
    function __construct() {
        parent::__construct();
        $this->check();
        $this->_ext = "";
        $curLang = JFactory::getLanguage()->_lang;
        if ($curLang == "en-GB")
            $this->_ext = "_trans";
    }

//function

    function check() {
        $provineID = JRequest::getVar('ProvinceID', 0, '', 'int');
        $cityID = JRequest::getVar('CityID', 0, '', 'int');
        $regionID = JRequest::getVar('RegionID', 0, '', 'int');
        //$projectID= JRequest::getVar('ProjectID',  0, '', 'int');
        $categoryID = JRequest::getVar('CategoryID', 0, '', 'int');
        //$finishingLevelID= JRequest::getVar('FinishingLevelID',  0, '', 'int');
        //$constructionPhaseID= JRequest::getVar('ConstructionPhaseID',  0, '', 'int');
        $floorID = JRequest::getVar('FloorID', 0, '', 'int');
        $priceFrom = JRequest::getVar('PriceFrom', 0, '', 'int');
        $priceTo = JRequest::getVar('PriceTo', 0, '', 'int');
        $areaFrom = JRequest::getVar('AreaFrom', 0, '', 'int');
        $areaTo = JRequest::getVar('AreaTo', 0, '', 'int');

        $whereArr = array();

        if ($provineID != null) {
            $text = " ";
            $query = "SELECT ID FROM #__ssprovinces WHERE TempID=" . $provineID;
            $data = $this->_getList($query);

            if (count($data) > 1) {
                $text .=" ( ";
                for ($i = 0; $i < count($data); $i++) {
                    $text .= "#__sscities.ProvinceID=" . $data[$i]->ID ;
                    if ($i != (count($data) - 1))
                        $text .= " OR ";
                }
                $text .=" ) ";
                $whereArr[] = $text;
            }elseif (!empty($data[0]->ID)) {
                $whereArr[] = "#__sscities.ProvinceID=" . $data[0]->ID ;
            }
        }

        if ($cityID != null) {
            $text = " ";
            $query = "SELECT ID FROM #__sscities WHERE TempID=" . $cityID;
            $data = $this->_getList($query);
            //die($query);
            if (count($data) > 1) {
                $text .=" ( ";
                for ($i = 0; $i < count($data); $i++) {
                    $text .= "#__ssregions.CityID=" . $data[$i]->ID ;
                    if ($i != (count($data) - 1))
                        $text .= " OR ";
                }
                $text .=" ) ";
                $whereArr[] = $text;
            }elseif(!empty ($data[0]->ID))
                $whereArr[] = "#__ssregions.CityID=" . $data[0]->ID ; //$cityID;
        }

        if ($regionID != null) {
            $text = " ";
            $query = "SELECT ID FROM #__ssregions WHERE TempID=" . $regionID;
            $data = $this->_getList($query);

            if (count($data) > 1) {
                $text .=" ( ";
                for ($i = 0; $i < count($data); $i++) {
                    $text .= "#__ssprojects.RegionID=" . $data[$i]->ID ;
                    if ($i != (count($data) - 1))
                        $text .= " OR ";
                }
                $text .=" ) ";
                $whereArr[] = $text;
            }elseif(!empty ($data[0]->ID))
                $whereArr[] = "#__ssprojects.RegionID=" . $data[0]->ID ; //$regionID;
        }

        if ($categoryID != null) {
            $text = " ";
            $query = "SELECT ID FROM #__sscategories WHERE TempID=" . $categoryID;
            $data = $this->_getList($query);

            if (count($data) > 1) {
                $text .=" ( ";
                for ($i = 0; $i < count($data); $i++) {
                    $text .= "#__ssunits.CategoryID=" . $data[$i]->ID ;
                    if ($i != (count($data) - 1))
                        $text .= " OR ";
                }
                $text .=" ) ";
                $whereArr[] = $text;
            }elseif(!empty ($data[0]->ID))
                $whereArr[] = "#__ssunits.CategoryID=" . $data[0]->ID; //$categoryID;
        }

        if ($floorID != null) {
            $text = " ";
            $query = "SELECT ID FROM #__ssfloors WHERE TempID=" . $floorID;
            $data = $this->_getList($query);

            if (count($data) > 1) {
                $text .="( ";
                for ($i = 0; $i < count($data); $i++) {
                    $text .= " #__ssunits.FloorID=" . $data[$i]->ID ;
                    if ($i != (count($data) - 1))
                        $text .= " OR ";
                }
                $text .=" ) ";
                $whereArr[] = $text;
            }elseif(!empty ($data[0]->ID))
                $whereArr[] = "#__ssunits.FloorID=" . $data[0]->ID ; //$floorID;
        }

        if ($priceFrom != null)
            $whereArr[] = "#__ssunits.TotalValue >=" . $priceFrom;
        if ($priceTo != null)
            $whereArr[] = "#__ssunits.TotalValue <=" . $priceTo;
        if ($areaFrom != null)
            $whereArr[] = "#__ssunits.Area >=" . $areaFrom;
        if ($areaTo != null)
            $whereArr[] = "#__ssunits.Area <=" . $areaTo;

        if (count($whereArr) > 0) {
            $whereClause = " where " . implode(" and ", $whereArr);
            $this->_data = $whereClause;
            $this->error = false;
        } else {
            $this->error = true;

            $this->setError(JText::_("Please select at least one search option..."));
        }

        if ($priceFrom != null && $priceTo != null && $priceFrom > $priceTo) {
            $this->error = true;
            $this->setError(JText::_("Please enter valid range in price fields"));
        }
        if ($areaFrom != null && $areaTo != null && $areaFrom > $areaTo) {
            $this->error = true;
            $this->setError(JText::_("Please enter valid range in area fields"));
        }
    }

    /**
     * Method to get a record
     * @return object with data
     */
    function search() {
        //$whereClause = $this->_data ;
        //$whereClause = $this->_data;
        if (!empty($this->_data)) {
            $whereClause = $this->_data;
        } else {
            $whereClause = "WHERE #__sscities.ProvinceID='0'";
        }
        //die($whereClause);
        $query = "SELECT #__ssunits.ID ,#__ssunits.PlotNumber, #__ssunits.Area, #__ssunits.TotalValue,
                 if(#__ssprojects.Name" . $this->_ext . "<>'',#__ssprojects.Name" . $this->_ext . ",#__ssprojects.Name) as Name,
                 if(#__ssregions.Name" . $this->_ext . "<>'',#__ssregions.Name" . $this->_ext . ",#__ssregions.Name) as rname,
                 if(#__sscities.Name" . $this->_ext . "<>'',#__sscities.Name" . $this->_ext . ",#__sscities.Name) as cname"
                . " FROM #__ssunits inner join #__ssprojects on #__ssunits.ProjectID = #__ssprojects.ID and (#__ssunits.ReservationStatusID LIKE '%000000001') "
                . "inner join #__ssregions on #__ssregions.ID = #__ssprojects.RegionID  "
                . "inner join #__sscities on #__sscities.ID = #__ssregions.CityID  "
                . $whereClause;

        //die($query);

        $data = $this->_getList($query);

        return $data;
    }

//function
}

// class
