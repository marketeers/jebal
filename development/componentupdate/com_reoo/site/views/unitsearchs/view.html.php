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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the unitsearch Component
 *
 * @package    unitsearch
 * @subpackage Views
 */

class unitsearchsViewunitsearchs extends JViewLegacy
{
    /**
     * unitsearchs view display method
     * @return void
     **/
    function display($tpl = null)
    {
        $model = $this->getModel();

        //$this->drawConstructionPhase($model);
        //$this->drawFinishingLevel($model);
        $this->drawCategories($model);
        $this->drawFloor($model);
        //$this->drawProjects($model);
        $this->drawProvinceCityRegion($model);

        parent::display($tpl);
    }

    function drawProvinceCityRegion($model)
    {

        $provinces =  $model->getProvinces();
        $provincesOptions = array();

        $cities =  $model->getCities();
        $citiesOptions = array();

        $regions =  $model->getRegions();
        $regionsOptions = array();

        $provincesOptions[] = JHTML::_('select.option', null, "");
    $citiesOptions[] = JHTML::_('select.option', null, "");
    $regionsOptions[] = JHTML::_('select.option', null, "");

    foreach($provinces as $province) :
    $provincesOptions[] = JHTML::_('select.option', $province["ID"], $province["Name"]);
    endforeach;

    foreach($cities as $city) :
        $citiesOptions[] = JHTML::_('select.option', $city["ID"], $city["Name"]);
    endforeach;

    foreach($regions as $region) :
        $regionsOptions[] = JHTML::_('select.option', $region["ID"], $region["Name"]);
    endforeach;


        echo "<script language=\"javascript\" type=\"text/javascript\">\n\t\t";
        echo "var citiesArr = new Array;\n\t\t";

        $i = 1;
        
        foreach ($cities as $city) {
            echo "citiesArr[".$i++."] = new Array( '".$city["ProvinceID"]."','".addslashes( $city["ID"] )."','".addslashes( $city["Name"] )."' );\n\t\t";
        }

        echo "var regionsArr = new Array;\n\t\t";

        $i = 1;

        foreach ($regions as $region) {
            echo "regionsArr[".$i++."] = new Array( '".$region["CityID"]."','".addslashes( $region["ID"] )."','".addslashes( $region["Name"] )."' );\n\t\t";
        }
        echo "</script>";

        $javascriptCity = "onchange=\"changeDynaList( 'CityID', citiesArr, document.adminForm.ProvinceID.options[document.adminForm.ProvinceID.selectedIndex].value, 0, 0); document.adminForm.CityID.add(new Option('', null), document.adminForm.CityID.options[0]); document.adminForm.CityID.selectedIndex=0;  \"";
        $javascriptRegion = "onchange=\"changeDynaList( 'RegionID', regionsArr, document.adminForm.CityID.options[document.adminForm.CityID.selectedIndex].value, 0, 0); document.adminForm.RegionID.add(new Option('', null), document.adminForm.RegionID.options[0]); document.adminForm.RegionID.selectedIndex=0;  \"";

        $provincesDropdown = JHTML::_('select.genericlist', $provincesOptions, 'ProvinceID', 'class="inputbox" style="width:160px;"' . $javascriptCity, 'value', 'text',null);
        $citiesDropdown = JHTML::_('select.genericlist', $citiesOptions, 'CityID', 'class="inputbox" style="width:160px;"'.$javascriptRegion, 'value', 'text',null);
        $regionsDropdown = JHTML::_('select.genericlist', $regionsOptions, 'RegionID', 'class="inputbox" style="width:160px;"', 'value', 'text',null);
       
       
        $this->assignRef('provinces', $provincesDropdown);
        $this->assignRef('cities', $citiesDropdown);
        $this->assignRef('regions', $regionsDropdown);

    }

    function drawProjects($model)
    {
        $projects =  $model->getProjects();
        $projectOptions = array();

        $projectOptions[] = JHTML::_('select.option', null, "");

        foreach($projects as $project) :
        $projectOptions[] = JHTML::_('select.option', $project["ID"], $project["Name"]);
        endforeach;

        $projectsDropdown = JHTML::_('select.genericlist', $projectOptions, 'ProjectID', 'class="inputbox" style="width:160px;"', 'value', 'text',null);

        $this->assignRef('projects', $projectsDropdown);
    }

    function drawCategories($model)
    {
        //get construction phases list
        $categories =  $model->getCategories();
        $categoriesOptions = array();

        $categoriesOptions[] = JHTML::_('select.option', null, "");

        foreach($categories as $category) :
        $categoriesOptions[] = JHTML::_('select.option', $category["ID"], $category["Name"]);
        endforeach;

        $categoriesDropdown = JHTML::_('select.genericlist', $categoriesOptions, 'CategoryID', 'class="inputbox" style="width:160px;"', 'value', 'text',null);

        $this->assignRef('categories', $categoriesDropdown);
    }

    function drawConstructionPhase($model)
    {
        //get construction phases list
        $constructionPhases =  $model->getConstructionPhases();
        $constructionPhasesOptions = array();

        $constructionPhasesOptions[] = JHTML::_('select.option', null, "");

        foreach($constructionPhases as $constructionPhase) :
        $constructionPhasesOptions[] = JHTML::_('select.option', $constructionPhase["ID"], $constructionPhase["Name"]);
        endforeach;

        $constructionPhasesDropdown = JHTML::_('select.genericlist', $constructionPhasesOptions, 'ConstructionPhaseID', 'class="inputbox" style="width:160px;"' , 'value', 'text',null);

        $this->assignRef('constructionPhases', $constructionPhasesDropdown);
    }

    function drawFinishingLevel($model)
    {
        $finishinglevels =  $model->getFinishingLevels();
        $finishinglevelOptions = array();

        $finishinglevelOptions[] = JHTML::_('select.option', null, "");

        foreach($finishinglevels as $finishinglevel) :
        $finishinglevelOptions[] = JHTML::_('select.option', $finishinglevel["ID"], $finishinglevel["Name"]);
        endforeach;


        $finishinglevelsDropdown = JHTML::_('select.genericlist', $finishinglevelOptions, 'FinishingLevelID', 'class="inputbox" style="width:160px;"', 'value', 'text',null);

        $this->assignRef('finishinglevels', $finishinglevelsDropdown);
    }

    function drawFloor($model)
    {
        $floors =  $model->getFloors();
        $floorOptions = array();

        $floorOptions[] = JHTML::_('select.option', null, "");

        foreach($floors as $floor) :
        $floorOptions[] = JHTML::_('select.option', $floor["ID"], $floor["Name"]);
        endforeach;

        $floorsDropdown = JHTML::_('select.genericlist', $floorOptions, 'FloorID', 'class="inputbox" style="width:160px;"', 'value', 'text',null);

        $this->assignRef('floors', $floorsDropdown);
    }
}
