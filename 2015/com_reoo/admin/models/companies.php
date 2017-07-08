<?php

/**
 * @version $Id$
 * @package    projects
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     heba nasr {@link http://www.easy-joomla.org}
 * @author     Created on 03-Jan-2011
 */
//-- No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.model');

/**
 * projects Model
 *
 * @package    projects
 * @subpackage Models
 */
class companiesModelcompanies extends JModelLegacy {

    /**
     * Constructor that retrieves the ID from the request
     *
     * @access	public
     * @return	void
     */
    function __construct() {
        parent::__construct();

        $array = JRequest::getVar('cid', 0, '', 'array');
        $this->setId((string) $array[0]);
    }

//function

    /**
     * Method to set the projects identifier
     *
     * @access	public
     * @param	int projects identifier
     * @return	void
     */
    function setId($id) {
        // Set id and wipe data
        $this->_id = $id;
        //die($id);
        $this->_data = null;
    }

//function

    /**
     * Method to get a record
     * @return object with data
     */
    function &getData() {
        // Load the data
        if (empty($this->_data)) {
            $query = " SELECT * FROM #__sscompanies " .
                    " WHERE ID = " . $this->_id ;
            $this->_db->setQuery($query);
            $this->_data = $this->_db->loadObject();
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->ID = NULL;
            $this->_data->Name = null;
        }
        return $this->_data;
    }

//function

    /**
     * Method to store a record
     *
     * @access	public
     * @return	boolean	True on success
     */
    function store() {
        $row = & $this->getTable();

        $data = JRequest::get('post');
        // Bind the form fields to the hello table
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$row->check()) {
            $this->setError($row->getError());
            return false;
        }

        // Store the table to the database
        if (!$row->store()) {
            $this->setError($row->getErrorMsg());
            return false;
        }

        return true;
    }

//function

    /**
     * Method to delete record(s)
     *
     * @access	public
     * @return	boolean	True on success
     */
    function delete() {
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');

        $row = & $this->getTable("ssprojects");

        if (count($cids)) {
            foreach ($cids as $cid) {

                /* if (!$row->delete( $cid )) {
                  $this->setError( $row->getErrorMsg() );
                  return false;
                  } */
                $db = $this->_db;
                $db->BeginTrans();
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    $db->RollbackTrans();
                    return false;
                } else {
                    $q = "delete from #__ssunits where ProjectID = '" . $cid . "'";
                    $db->setQuery($q);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $this->setError("error deleting related units");
                        return false;
                    }
                    $db->CommitTrans();
                }
            }//foreach
        }
        return true;
    }

    //function
    //load provinces
    function getProvinces() {
        //die($this->_ext);
        $query = " SELECT ID,Name FROM #__ssprovinces  ";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    //load cities
    function getCities() {
        $query = " SELECT ID, Name,ProvinceID FROM #__sscities ";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load regions
     */

    function getRegions() {
        $query = " SELECT ID,Name,CityID FROM #__ssregions ";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases
     */

    function getConstructionPhases() {
        $query = " SELECT ID,Name FROM #__ssconstructionphases ";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases Details
     */

    function getConstructionPhaseDetailsSingle($ConstructionPhaseID) {
        $query = " SELECT ID,Name FROM #__ssconstructionphasedetails  WHERE  PhaseID='" . $ConstructionPhaseID . "'";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases Details
     */

    function getConstructionPhaseDetails() {
        $query = " SELECT ID,Name,PhaseID FROM #__ssconstructionphasedetails order by PhaseID";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    function getProvinceCityOfProject($regionId) {
        $query = " SELECT CityID , ProvinceID From
                  #__ssregions inner join #__sscities on #__ssregions.CityID= #__sscities.ID
                  WHERE #__ssregions.ID='" . $regionId . "'";
        //die($query);
        $this->_db->setQuery($query);
        return $this->_db->loadAssoc();
    }
    
    //For New Enteries Only
    //function
    //load provinces
    function getProvincesNew() {
        //die($this->_ext);
        $query = " SELECT ID,Name FROM #__ssprovinces WHERE ID LIKE 'WebSite%' ";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    //load cities
    function getCitiesNew() {
        $query = " SELECT ID, Name,ProvinceID FROM #__sscities WHERE ID LIKE 'WebSite%'";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load regions
     */

    function getRegionsNew() {
        $query = " SELECT ID,Name,CityID FROM #__ssregions WHERE ID LIKE 'WebSite%'";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases
     */

    function getConstructionPhasesNew() {
        $query = " SELECT ID,Name FROM #__ssconstructionphases WHERE ID LIKE 'WebSite%'";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases Details
     */

    function getConstructionPhaseDetailsSingleNew($ConstructionPhaseID) {
        $query = " SELECT ID,Name FROM #__ssconstructionphasedetails  WHERE ID LIKE 'WebSite%' AND PhaseID='" . $ConstructionPhaseID . "'";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

    /*
     * Method to load Construction Phases Details
     */

    function getConstructionPhaseDetailsNew() {
        $query = " SELECT ID,Name,PhaseID FROM #__ssconstructionphasedetails WHERE ID LIKE 'WebSite%' order by PhaseID";
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }

}

// class
