<?php

/**
 * @version $Id$
 * @package    subscriptionfees
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     heba nasr {@link http://www.easy-joomla.org}
 * @author     Created on 03-Oct-2010
 */
//-- No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.model');
jimport('joomla.user.helper');

/**
 * subscriptionfees Model
 *
 * @package    subscriptionfees
 * @subpackage Models
 */
class importModelimport extends JModelLegacy {

    function getcompanies() {
        $db = & JFactory::getDBO();
        $Q = "SELECT * FROM cstm_sscompanies";
        $db->setQuery($Q);
        $companiesList = $db->loadObjectList();
        return $companiesList;
    }

    function import($file, &$passedContentsChecks) {
        //chmod(JPATH_COMPONENT . DS . "uploads".DS."uimages", 0775);
        //die();
        //die(phpinfo());
        $prefix = JRequest::getvar('prefix');
        if ($prefix == 0) {
            return "You should select Company";
        }
        $msg = "<b>Import process log:</b><br />==================<br />";
        jimport('joomla.filesystem.file');

        //new implementation
        //copy zip file from tmp folder
        $filename = "export.zip";
        $src = JPATH_COMPONENT . DS . "tmp" . DS . $filename;
        $dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;

        if (!JFile::copy($src, $dest))
            return "error while getting exported file";
        //end new implementation
        //checks end
        //file passed all checks
        //read file contents
        $passedContentsChecks = true;
        //die("here");
        //unzip file
        jimport(JPATH_COMPONENT . DS . "assets" . DS . "ZipArchive.php");
        //die("before");
        //require_once(JPATH_COMPONENT . DS . "assets" . DS . "ZipArchive.php");
        //die("require");
        $ziip = new ZipArchive();
        $zip = new ZipArchive();
        $res = $zip->open($dest);
        //die("res ".$res);
        if ($res === TRUE) {
            $exractedFilesDir = JPATH_COMPONENT . DS . "uploads" . DS . substr($filename, 0, -4);
            $zip->extractTo($exractedFilesDir . DS);
            $zip->close();

            $msg .= "Imported file was extracted succefully";
        } else {
            $msg.= "Imorted file extraction failed";
            //delete file
            JFile::delete($dest); //back
            return $msg;
        }


        //delete file
        JFile::delete($dest); //back

        $msg .= $this->handleFileContents($exractedFilesDir, $passedContentsChecks, $prefix);

        $this->rrmdir($exractedFilesDir);

        return $msg;
    }

    function handleFileContents($filePath, &$passedContentsChecks, $prefix) {
        require_once(JPATH_COMPONENT . DS . "assets" . DS . "CsvParser.php");

        //loop through files
        //for each file:
        // 1- create csvparser
        // 2- call validaterows and sendcsvparser instane
        // assumptions:
        // file names are same as table names but tables has additional "ss" in z beginning

        $msg = "";

        if ($handle = opendir($filePath)) {

            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (strtolower($file) == "customers.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveCustomers($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "floors.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveDataSearch($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "categories.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveDataSearch($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "provinces.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveDataSearch($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "cities.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveDataSearch($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "regions.csv")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveDataSearch($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (($file != "customers.csv" || $file != "regions.csv" || $file != "cities.csv" || $file != "provinces.csv" || $file != "categories.csv" || $file != "floors.csv") && strtolower(JFile::getExt($file)) == 'csv')
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->SaveData($filePath, $file, $passedContentsChecks, $prefix);
                    elseif (strtolower($file) == "uimages.zip")
                        $msg.= "<br /><br /> " . $this->ExtractImages($filePath, "uimages");
                    elseif (strtolower($file) == "pimages.zip")
                        $msg.= "<br /><br /> " . $this->ExtractImages($filePath, "pimages");
                    elseif (strtolower($file) == "existingids.zip")
                        $msg.= "<br /><br /> " . $file . "<br />" . $this->handleDeletedRows($filePath, $prefix, $passedContentsChecks);
                }
            }
            closedir($handle); //die("Here");
            $this->AddForgienKeys();
        }
        return $msg;
    }

    function AddForgienKeys() {
        //to add Province Foregin Key & City Foregin key into the Temp tables of search CityTemp and RegionTemp
        $db = $this->_db;
        $db->BeginTrans();

        //Cities Table
        //Select From Cities tables the ProvinceId and Temp Id and Select from province table the TempId corresponding to it
        //Update the ProvinceId in Cities temp table with the ProvinceTemp ID
        $QSelectIds = "SELECT cstm_sscities.ID,cstm_sscities.Name,cstm_sscities.ProvinceID,cstm_sscities.TempID,cstm_ssprovincestemp.ID AS ProvinceTempID
                       FROM cstm_sscities 
                       INNER JOIN cstm_ssprovinces ON cstm_ssprovinces.ID=cstm_sscities.ProvinceID
                       INNER JOIN cstm_ssprovincestemp ON cstm_ssprovincestemp.ID=cstm_ssprovinces.TempID";
        //WHERE cstm_sscities.ID LIKE '".$prefix."%'";
        //print_r($QSelectIds);
        $db->setQuery($QSelectIds);
        $IdsProvinces = $db->loadObjectList();

        for ($row = 0; $row < count($IdsProvinces); $row++) {
            //Update the PrvinceTempID in citiestable with the Ids from provincetemp table
            $QUpdateCities = " UPDATE cstm_sscities SET ProvinceTempID=" . $IdsProvinces[$row]->ProvinceTempID .
                    " WHERE cstm_sscities.ID='" . $IdsProvinces[$row]->ID . "'";
            $db->setQuery($QUpdateCities);
            $db->query();
        }
        //update for the citiestemp table with the ids of the provinceTempId in cities table
        //select the same names but with different province ids
        $QSelectdifferentProvinces = "SELECT DISTINCT cstm_sscities.Name,cstm_sscities.ProvinceTempID,cstm_sscities.TempID
                                      FROM cstm_sscities 
                                      INNER JOIN cstm_ssprovinces ON cstm_ssprovinces.ID=cstm_sscities.ProvinceID 
                                      INNER JOIN cstm_ssprovincestemp ON cstm_ssprovincestemp.ID=cstm_ssprovinces.TempID 
                                      WHERE cstm_sscities.Name IN
                                      (SELECT cstm_sscities.Name 
                                      FROM cstm_sscities 
                                      GROUP BY cstm_sscities.Name 
                                      HAVING COUNT(DISTINCT cstm_sscities.ProvinceTempID) > 1 ) ";
        //die($QSelectdifferentProvinces);
        $db->setQuery($QSelectdifferentProvinces);
        $differenceProvinces = $db->loadObjectList();

        for ($row = 0; $row < (count($differenceProvinces) - 1); $row++) {
            //Insert new column in sscities temp with new province id
            $QinsertionCitiesTemp = "INSERT INTO cstm_sscitiestemp (Name,ProvinceID) VALUES ('" . $differenceProvinces[$row]->Name . "','" . $differenceProvinces[$row]->ProvinceTempID . "')";
            $db->setQuery($QinsertionCitiesTemp);
            $db->query();

            //update the cities table of this coloumn with the last id was inserted here 
            $QUpdateCities = "UPDATE cstm_sscities SET TempID=LAST_INSERT_ID()
                              WHERE cstm_sscities.Name='" . $differenceProvinces[$row]->Name . "' AND cstm_sscities.ProvinceTempID='" . $differenceProvinces[$row]->ProvinceTempID . "'";
            $db->setQuery($QUpdateCities);
            $db->query();
        }

        //Update the cities temp table with original ProvinceIds from Province Table
        $UpdateCitiesTemp = "UPDATE cstm_sscitiestemp
                            SET cstm_sscitiestemp.ProvinceID=( SELECT cstm_sscities.ProvinceTempID
                                                            FROM cstm_sscities
                                                            WHERE cstm_sscitiestemp.ID = cstm_sscities.TempID
                                                            group by cstm_sscities.TempID)
                            WHERE EXISTS
                            ( SELECT cstm_sscities.ProvinceTempID
                            FROM cstm_sscities
                            WHERE cstm_sscitiestemp.ID = cstm_sscities.TempID)";
        //print_r($UpdateCitiesTemp);
        $db->setQuery($UpdateCitiesTemp);
        $db->query();
        
        
        //Regions Table
        //Select From Cities tables the ProvinceId and Temp Id and Select from province table the TempId corresponding to it
        //Update the ProvinceId in Cities temp table with the ProvinceTemp ID
        $QSelectIds = "SELECT cstm_ssregions.ID,cstm_ssregions.Name,cstm_ssregions.CityID,cstm_ssregions.TempID,cstm_sscitiestemp.ID AS CityTempID
                       FROM cstm_ssregions 
                       INNER JOIN cstm_sscities ON cstm_sscities.ID=cstm_ssregions.CityID
                       INNER JOIN cstm_sscitiestemp ON cstm_sscitiestemp.ID=cstm_sscities.TempID";
        //WHERE cstm_ssregions.ID LIKE '".$prefix."%'";
        //die($QSelectIds);
        $db->setQuery($QSelectIds);
        $IdsProvinces = $db->loadObjectList();

        for ($row = 0; $row < count($IdsProvinces); $row++) {
            //Update the PrvinceTempID in citiestable with the ProvinceTempId from provincetemp table
            $QUpdateCities = " UPDATE cstm_ssregions SET CityTempID=" . $IdsProvinces[$row]->CityTempID .
                    " WHERE cstm_ssregions.ID='" . $IdsProvinces[$row]->ID . "'";
            //die($QUpdateCities);
            $db->setQuery($QUpdateCities);
            $db->query();
        }

        //select the same names but with different province ids
        $QSelectdifferentProvinces = "SELECT DISTINCT cstm_ssregions.Name,cstm_ssregions.CityTempID,cstm_ssregions.TempID
                                      FROM cstm_ssregions 
                                      INNER JOIN cstm_sscities ON cstm_sscities.ID=cstm_ssregions.CityID 
                                      INNER JOIN cstm_sscitiestemp ON cstm_sscitiestemp.ID=cstm_sscities.TempID 
                                      WHERE cstm_ssregions.Name IN
                                      (SELECT cstm_ssregions.Name 
                                      FROM cstm_ssregions 
                                      GROUP BY cstm_ssregions.Name 
                                      HAVING COUNT(DISTINCT cstm_ssregions.CityTempID) > 1 ) ";
        //die($QSelectdifferentProvinces);
        $db->setQuery($QSelectdifferentProvinces);
        $differenceProvinces = $db->loadObjectList();

        for ($row = 0; $row < (count($differenceProvinces) - 1); $row++) {
            //Insert new column in sscities temp with new province id
            $QinsertionCitiesTemp = "INSERT INTO cstm_ssregionstemp (Name,CityID) VALUES ('" . $differenceProvinces[$row]->Name . "','" . $differenceProvinces[$row]->CityTempID . "')";
            //print_r("Insertion " . $QinsertionCitiesTemp);
            $db->setQuery($QinsertionCitiesTemp);
            $db->query();

            //update the cities table of this coloumn with the last id was inserted here 
            $QUpdateCities = "UPDATE cstm_ssregions SET TempID=LAST_INSERT_ID()
                              WHERE cstm_ssregions.CityTempID='" . $differenceProvinces[$row]->CityTempID . "' AND cstm_ssregions.Name='" . $differenceProvinces[$row]->Name . "'";
            //die($QUpdateCities);
            $db->setQuery($QUpdateCities);
            $db->query();
        }

        //Update the regions temp table with original CitiesIds from Cities Table
        $UpdateRegionsTemp = "UPDATE cstm_ssregionstemp
                            SET cstm_ssregionstemp.CityID=( SELECT cstm_ssregions.CityTempID
                                                            FROM cstm_ssregions
                                                            WHERE cstm_ssregionstemp.ID = cstm_ssregions.TempID
                                                            group by cstm_ssregions.TempID)
                            WHERE EXISTS
                            ( SELECT cstm_ssregions.CityTempID
                              FROM cstm_ssregions
                              WHERE cstm_ssregionstemp.ID = cstm_ssregions.TempID)";
        //die($UpdateRegionsTemp);
        $db->setQuery($UpdateRegionsTemp);
        $db->query();
    }

    function SaveDataSearch($filepath, $file, &$passedContentsChecks, $prefix) {
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $headersArr = $csvFile->headers;
        $HeaderNo = count($headersArr);
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;
        /* Steps:
         *  1- start a DB transaction
         * 1.1- delete all records
         *  2- loop on rows and Insert record
         *  3- if error occurs at any iteration break loop and rollback transaction
         *  7- after loop end commit transaction
         */

        $db = $this->_db;
        $db->BeginTrans();

        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));

        //delete perivous data from the temp tables
        $Qdelete = "Delete FROM " . $tablename . "temp";
        $db->setQuery($Qdelete);
        $db->query();

        $updateStr = "";
        for ($col = 1; $col < $HeaderNo; $col++) {
            $updateStr .= trim($headersArr[$col]) . " = VALUES(" . trim($headersArr[$col]) . "), ";
        }
        $updateStr = substr($updateStr, 0, -2);

        //if ($RecordsNo > 0) {
            for ($row = 0; $row < $RecordsNo; $row++) {
                $dataPrefix = str_split($csvFile->fields[$row][0], 1);

                if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                    $errorPos = -2;
                    break;
                }

                for ($col = 0; $col < $HeaderNo; $col++) {
                    $rowArr[trim($headersArr[$col])] = trim($csvFile->fields[$row][$col]);
                }

                /* $Q = "insert  into $tablename(".substr(utf8_decode(implode(",", $headersArr)),1).")
                  VALUES ('".implode("','", $rowArr)."')"; */
                $Q = "insert into $tablename(" . implode(",", $headersArr) . ") VALUES ('" . implode("','", $rowArr) . "')
                  ON DUPLICATE KEY UPDATE " . $updateStr;
                //die($Q);
                $db->setQuery($Q);
                $db->query();
                if ($db->getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }
            }
            //Check Dupliacte Names in table
            /*
              SELECT `Name`, COUNT(*)
              FROM   brg_ssfloors
              GROUP BY `Name`
              HAVING  COUNT(*) > 1
             */
            $query = "SELECT Name,COUNT(*) FROM " . $tablename . " WHERE 
                  ID NOT LIKE '3000%' GROUP BY Name HAVING COUNT(*)>1";
            //die($query);
            $db->setQuery($query);
            $result = $db->loadObjectList();

            for ($k = 0; $k < count($result); $k++) {
                //insert data in temp table of search
                $Qinsert = "insert into " . $tablename . "temp(Name) VALUES ('" . $result[$k]->Name . "')";
                $db->setQuery($Qinsert);
                $db->query();

                //update the temp Id value in the original table
                $Qupdate = "UPDATE " . $tablename . " SET TempID=LAST_INSERT_ID()  WHERE Name Like '" . $result[$k]->Name . "'";
                $db->setQuery($Qupdate);
                $db->query();
            }
            //check if there is other records but not duplicated data or old data 
            $query = "SELECT Name FROM " . $tablename . "
                  WHERE  ID NOT LIKE 'WebSite%' 
                  AND (TempID NOT IN (Select ID from " . $tablename . "temp ) OR TempID=0)";

            $db->setQuery($query);
            $result = $db->loadObjectList();

            for ($k = 0; $k < count($result); $k++) {
                //Check if there is any other value has the same name 
                $query = "SELECT COUNT(ID) FROM " . $tablename . "temp
                      WHERE Name Like '" . $result[$k]->Name . "'";
                $db->setQuery($query);
                $count = $db->loadResult();

                if ($count >= 1) {
                    //update the temp Id value in the original table
                    $Qupdate = "UPDATE " . $tablename . " SET TempID=(SELECT ID FROM " . $tablename . "temp 
                        WHERE Name LIKE '" . $result[$k]->Name . "')  WHERE Name Like '" . $result[$k]->Name . "'";
                    $db->setQuery($Qupdate);
                    $db->query();
                } else {
                    //insert data in temp table of search
                    $Qinsert = "insert into " . $tablename . "temp(Name) VALUES ('" . $result[$k]->Name . "')";
                    $db->setQuery($Qinsert);
                    $db->query();

                    //update the temp Id value in the original table
                    $Qupdate = "UPDATE " . $tablename . " SET TempID=LAST_INSERT_ID()  WHERE Name Like '" . $result[$k]->Name . "'";
                    $db->setQuery($Qupdate);
                    $db->query();
                }
            }
//        }else
//            return "File is empty";

        if ($errorPos == -1) {
            $db->CommitTrans();
            return "Successfully saved";
        } elseif ($errorPos == -2) {
            $passedContentsChecks = false;
            return "Check Company Name Can't Complete process";
        } else {
            $passedContentsChecks = false;
            return "Insertion failed at record no " . ($errorPos + 1);
        }
    }

    function SaveDatatempProjectUnits($filepath, $file, $prefix) {
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;

        /* Steps:
         *  1- start a DB transaction
         *  2- delete perivous data from temp table
         *  3- insert into temp table existing id from csv file
         *  4- delete any record not in existingIds csv
         */

        //get the prefix between number
        $fromnum = $prefix * pow(10, 9);
        $tonum = ($prefix + 1) * pow(10, 9);

        $db = $this->_db;
        $db->BeginTrans();

        $tablename = "cstm_sstemp";
        //Delete the temp Table
        $Qdel = "DELETE FROM $tablename";

        $db->setQuery($Qdel);
        $db->query();

        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -5;
            return $errorPos; //"Error while deleting temp data";
        }
        
        for ($row = 0; $row < $RecordsNo; $row++) {
            $dataPrefix = str_split($csvFile->fields[$row][0], 1);
            //check if the id of existingIds is the same id of the selected company 
            if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                $errorPos = -2;
                return $errorPos;
            }
            $rowArr[$row] = trim($csvFile->fields[$row][0]);

            $Q = "insert into $tablename  (ID) VALUES ('" . $rowArr[$row] . "')";
            $db->setQuery($Q);
            $db->query();
            
            if ($db->getErrorNum()) {
                print_r($db->getErrorNum());
                $db->RollbackTrans();
                $errorPos = -3;
                return $errorPos;
                //break;
            }
        }

        //Check For values not in existing IDs
        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));
        $Q = "DELETE FROM $tablename WHERE $tablename.ID NOT IN (SELECT cstm_sstemp.ID FROM cstm_sstemp)
        AND $tablename.ID BETWEEN $fromnum AND $tonum AND ID NOT LIKE '30000%'";
        
        $db->setQuery($Q);
        $db->query();
        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -4;
            return $errorPos; //"Error while deleting from existingIds";
        }

        if ($errorPos == -1) {
            $db->CommitTrans();
            return "true"; //"Successfully saved";
        }
    }
    
    function SaveDatatemp($filepath, $file, $prefix) {
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;

        /* Steps:
         *  1- start a DB transaction
         *  2- delete perivous data from temp table
         *  3- insert into temp table existing id from csv file
         *  4- delete any record not in existingIds csv
         */

        //get the prefix between number
        $fromnum = $prefix * pow(10, 9);
        $tonum = ($prefix + 1) * pow(10, 9);

        $db = $this->_db;
        $db->BeginTrans();

        $tablename = "cstm_sstemp";
        //Delete the temp Table
        $Qdel = "DELETE FROM $tablename";

        $db->setQuery($Qdel);
        $db->query();

        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -5;
            return $errorPos; //"Error while deleting temp data";
        }
        
        for ($row = 0; $row < $RecordsNo; $row++) {
            $dataPrefix = str_split($csvFile->fields[$row][0], 1);
            //check if the id of existingIds is the same id of the selected company 
            if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                $errorPos = -2;
                return $errorPos;
            }
            $rowArr[$row] = trim($csvFile->fields[$row][0]);

            $Q = "insert into $tablename  (ID) VALUES ('" . $rowArr[$row] . "')";
            $db->setQuery($Q);
            $db->query();
            
            if ($db->getErrorNum()) {
                print_r($db->getErrorNum());
                $db->RollbackTrans();
                $errorPos = -3;
                return $errorPos;
                //break;
            }
        }

        //Check For values not in existing IDs
        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));
        $Q = "DELETE FROM $tablename WHERE $tablename.ID NOT IN (SELECT cstm_sstemp.ID FROM cstm_sstemp)
        AND $tablename.ID BETWEEN $fromnum AND $tonum AND ID NOT LIKE '30000%'";
        
        $db->setQuery($Q);
        $db->query();
        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -4;
            return $errorPos; //"Error while deleting from existingIds";
        }

        if ($errorPos == -1) {
            $db->CommitTrans();
            return "true"; //"Successfully saved";
        }
    }

    function SelectDataUsers($filepath, $file, $prefix) {
        /* Steps
         *  1- begin database trans
         *  2- insert existing ids of customer into the temp table
         *  3- select the user ids where customer ids not in customer existing table and
         *     its id between the company id and company id+1
         */
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;

        //get the prefix between number
        $fromnum = $prefix * pow(10, 9);
        $tonum = ($prefix + 1) * pow(10, 9);

        $db = $this->_db;
        $db->BeginTrans();

        $tablename = "cstm_sstemp";

        for ($row = 0; $row < $RecordsNo; $row++) {
            $dataPrefix = str_split($csvFile->fields[$row][0], 1);

            if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                $errorPos = -2;
                return $errorPos;
                //break;
            }
            $rowArr[$row] = trim($csvFile->fields[$row][0]);

            $Q = "insert into $tablename  (ID) VALUES ('" . $rowArr[$row] . "')";
            $db->setQuery($Q);
            $db->query();

            if ($db->getErrorNum()) {
                print_r($db->getErrorNum());
                $db->RollbackTrans();
                $errorPos = -3;
                return $errorPos;
            }
        }
        //Check For values not in existing IDs
        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));
        $usersQ = "select userid from $tablename where $tablename.ID NOT IN (SELECT cstm_sstemp.ID FROM cstm_sstemp)
        AND $tablename.ID BETWEEN $fromnum AND $tonum";

        $db->setQuery($usersQ);
        $usersIds = $db->loadResultArray();

        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -4;
            return $errorPos;
            break;
        }

        if ($errorPos == -1) {
            $db->CommitTrans();
            return $usersIds; //"Successfully saved";
        }
    }

    function DeleteDataCustomers($file, $prefix) {
        $errorPos = -1;
        /* Steps:
         *  1- start a DB transaction
         *  2- delete customer records where is not found in existing Ids and 
         *     its id between company id and the company id +1
         *  3- delete data from temp table
         */

        $db = $this->_db;
        $db->BeginTrans();

        //get the prefix between number
        $fromnum = $prefix * pow(10, 9);
        $tonum = ($prefix + 1) * pow(10, 9);

        //Check For values not in existing IDs
        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));
        $delQ = "delete from $tablename where $tablename.ID NOT IN (SELECT cstm_sstemp.ID FROM cstm_sstemp)
        AND $tablename.ID BETWEEN $fromnum AND $tonum";

        $db->setQuery($delQ);
        $db->query();
        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -4;
            return $errorPos;
        }
        //Delete the temp Table
        $Qdel = "DELETE FROM cstm_sstemp";

        $db->setQuery($Qdel);
        $db->query();

        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = -5;
            return $errorPos; //"Error while deleting temp data";
        }
        if ($errorPos == -1) {
            $db->CommitTrans();
            return "true"; //"Successfully saved";
        }
    }

    function SaveData($filepath, $file, &$passedContentsChecks, $prefix) {
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $headersArr = $csvFile->headers;
        $HeaderNo = count($headersArr);
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;
        /* Steps:
         *  1- start a DB transaction
         * 1.1- delete all records
         *  2- loop on rows and Insert record
         *  3- if error occurs at any iteration break loop and rollback transaction
         *  7- after loop end commit transaction
         */

        $db = $this->_db;
        $db->BeginTrans();

        $tablename = "cstm_ss" . strtolower(substr($file, 0, -4));

        $nextPrefix = ($prefix + 1) * pow(10, 9);
        $firestPrefix = $prefix * pow(10, 9);
        //die("before " . $firestPrefix . " After " . $nextPrefix);

        if (strtolower($file) == "pimages.csv") {
            $delQ = "delete from $tablename WHERE ID BETWEEN $firestPrefix AND $nextPrefix";
            $db->setQuery($delQ);
            $db->query();
            if ($db->getErrorNum()) {
                $db->RollbackTrans();
                return "Could not delete previous data";
            }
        }
        
        $updateStr = "";
        for ($col = 1; $col < $HeaderNo; $col++) {
            $updateStr .= trim($headersArr[$col]) . " = VALUES(" . trim($headersArr[$col]) . "), ";
        }
        $updateStr = substr($updateStr, 0, -2);

        if ($RecordsNo > 0) {
            for ($row = 0; $row < $RecordsNo; $row++) {
                $dataPrefix = str_split($csvFile->fields[$row][0], 1);

                if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                    $errorPos = -2;
                    break;
                }

                for ($col = 0; $col < $HeaderNo; $col++) {
                    $rowArr[trim($headersArr[$col])] = trim($csvFile->fields[$row][$col]);
                }

                $Q = "insert into $tablename(" . implode(",", $headersArr) . ") VALUES ('" . implode("','", $rowArr) . "')
                  ON DUPLICATE KEY UPDATE " . $updateStr;

                $db->setQuery($Q);
                $db->query();
                if ($db->getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }
            }
        }
        else
            return "File is empty";

        if ($errorPos == -1) {
            $db->CommitTrans();
            return "Successfully saved";
        } elseif ($errorPos == -2) {
            $passedContentsChecks = false;
            return "Check Company Name Can't Complete process";
        } else {
            $passedContentsChecks = false;
            return "Insertion failed at record no " . ($errorPos + 1);
        }
    }

    function SaveCustomers($filepath, $file, &$passedContentsChecks, $prefix) {
        $csvFile = new CsvParser($filepath . DS . $file, true, ',');
        $headersArr = $csvFile->headers;
        $HeaderNo = count($headersArr);
        $RecordsNo = $csvFile->numRecords;
        $rowArr = array();
        $errorPos = -1;

        /* Steps:
         *  1- start a DB transaction
         *  2- insertion process:
         *      2.1-
         *  3- if error occurs at any iteration break loop and rollback transaction
         *  7- after loop end commit transaction
         */

        $db = $this->_db;
        $db->BeginTrans();
        $ids = array();
        $salt = JUserHelper::genRandomPassword(32);

        if ($RecordsNo > 0) {
            for ($row = 0; $row < $RecordsNo; $row++) {
                $dataPrefix = str_split($csvFile->fields[$row][0], 1);

                if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                    $errorPos = -2;
                    break;
                }
                for ($col = 0; $col < $HeaderNo; $col++) {
                    $rowArr[trim($headersArr[$col])] = trim($csvFile->fields[$row][$col]);
                }
                //insert customer
                $tablename = "cstm_sscustomers";
                $Q = "insert into $tablename(" . implode(",", $headersArr) . ")
                      VALUES ('" . implode("','", $rowArr) . "')
                    ON DUPLICATE KEY UPDATE Name = VALUES(Name),NameInArabic = VALUES(NameInArabic),Email=VALUES(Email)";
                //print_r($Q);
                $db->setQuery($Q);
                $db->query();

                if ($db->getErrorNum()) {
                    //die("err");
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }
                if ($db->getAffectedRows() == 1) {
                    //if new row was inserted
                    //add users and permissions
                    //users
                    $numID = $rowArr["ID"] - ($prefix * pow(10, 9));
                    $tablename = "cstm_users";
					$Q = "insert  into $tablename(username,name,email,password)
                      VALUES (concat(SUBSTRING_INDEX('" . $rowArr["Name"] . "', ' ', 1)," . $numID . "+123),'" . $rowArr["Name"] . "','" . $rowArr["Email"] . "','" . JUserHelper::getCryptedPassword('123456', $salt) . ':' . $salt . "')";

                    $db->setQuery($Q);
                    $db->query();
					$last_id=$db->insertid();
					  $Q2 = "insert  into cstm_user_usergroup_map(user_id,group_id) VALUES ('" . $last_id . "',15)";
					  $db->setQuery($Q2);
                      $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $errorPos = $row;
                        break;
                    }

                    //update customer table set userid field to new inserted user id in users table
                    $updateQ = "update cstm_sscustomers set userid = LAST_INSERT_ID() where ID = " . $rowArr["ID"];

                    $db->setQuery($updateQ);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $errorPos = $row;
                        break;
                    }

                    //$ids[] = mysql_insert_id();
                    //core_acl_aro
                    $tablename = "cstm_core_acl_aro";
                    $Q = "insert  into $tablename(section_value,value,name)
                      VALUES ('users',LAST_INSERT_ID(),'" . $rowArr["Name"] . "')";

                    $db->setQuery($Q);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $errorPos = $row;
                        break;
                    }

                    //_core_acl_groups_aro_map
                    $tablename = "cstm_core_acl_groups_aro_map";
                    $Q = "insert  into $tablename(group_id,aro_id)
                      VALUES (18,LAST_INSERT_ID())";

                    //die($Q);
                    $db->setQuery($Q);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $errorPos = $row;
                        break;
                    }
                } else {//if ($db->getAffectedRows()== 2) // record updated
                    $numID = $rowArr["ID"] - ($prefix * pow(10, 9));
                    $tablename = "cstm_users";
                    $Q = "update $tablename set email = '" . $rowArr["Email"] . "' , name = '" . $rowArr["Name"] . "' where username = concat(SUBSTRING_INDEX('" . $rowArr["Name"] . "', ' ', 1)," . $numID . "+123)";

                    //die($Q);
                    $db->setQuery($Q);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $db->RollbackTrans();
                        $errorPos = $row;
                        break;
                    }
                }
            }
        }else
            return "File is empty";

        if ($errorPos == -1) {
            $db->CommitTrans();
            return "Successfully saved";
        } elseif ($errorPos == -2) {
            $passedContentsChecks = false;
            return "Check Company Name Can't Complete process";
        } else {
            $passedContentsChecks = false;
            return "Insertion failed at record no " . ($errorPos + 1);
        }
    }

    function ExtractImages($filePath, $filename) {
        //unzip file
        jimport(JPATH_COMPONENT . DS . "assets" . DS . "ZipArchive.php");
        $zip = new ZipArchive();
        $res = $zip->open($filePath . DS . $filename . ".zip");
        if ($res === TRUE) {
            $exractedFilesDir = JPATH_COMPONENT . DS . "uploads" . DS . $filename;
            //print_r($exractedFilesDir);
            if ($zip->extractTo($exractedFilesDir . DS)) {
                $zip->close();
                //give files right permissions
                if ($this->chmodr($exractedFilesDir, 0664)) {
                    return $filename . " file was extracted succefully, with permissions";
                }
                else {
                    return $filename . " file was extracted succefully, without permissions";
                }
            }
            else
                return $filename . " file extraction failed";
        } else {
            return $filename . " file opening failed";
        }
    }

    function handleDeletedRows($filepath, $prefix, $passedContentsChecks) {
        //die("hewre");
        //1- extract zip file
        //require_once(JPATH_COMPONENT . DS . "assets" . DS ."ZipArchive.php");
        $zip = new ZipArchive();

        $res = $zip->open($filepath . DS . "existingIDs.zip");
        if ($res === TRUE) {
            $exractedFilesDir = $filepath . DS . "existingIDs";
            if ($zip->extractTo($exractedFilesDir . DS)) {
                $zip->close();
            }
            else
                return "existingIDs file extraction failed";
        } else {
            return "existingIDs file opening failed";
        }

        $db = $this->_db;
        $db->BeginTrans();
        $errorPos = "";

        //2- open extracted directory
        if ($handle = opendir($exractedFilesDir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $csvFile = new CsvParser($exractedFilesDir . DS . $file, false, ',');

                    $RecordsNo = $csvFile->numRecords;
                    //$idstr = "";

                    for ($row = 0; $row < $RecordsNo; $row++) {
                        $dataPrefix = str_split($csvFile->fields[$row][0], 1);

                        if (($dataPrefix[0] * pow(10, 9)) != ($prefix * pow(10, 9))) {
                            $errorPos = -2;
                            break;
                        }
                        //$idstr.= "'" . trim($csvFile->fields[$row][0]) . "',";
                    }

                    //$idstr = substr($idstr, 0, -1);
                    //die($idstr);
                    if (strtolower($file) == "projects.csv" || strtolower($file) == "units.csv") {
                        $error_Pos = $this->SaveDatatempProjectUnits($exractedFilesDir, $file, $prefix);

                        if ($error_Pos == -2 || $errorPos == -3 || $errorPos == -4 || $errorPos == -5) {
                            $errorPos = $file;
                            break;
                        }
                    } elseif (strtolower($file) == "customers.csv") {
                        // get user ids of customers that will be deleted
                        $usersIds = $this->SelectDataUsers($exractedFilesDir, $file, $prefix);
                        if ($usersIds == -2 || $usersIds == -3 || $usersIds == -4) {
                            $errorPos = $file;
                            break;
                        }

                        $error_Pos = $this->DeleteDataCustomers($file, $prefix);
                        if ($error_Pos == -2 || $error_Pos == -3 || $error_Pos == -4 || $error_Pos == -5) {
                            $errorPos = $file;
                            break;
                        }

                        //loop and delete users
                        foreach ($usersIds as $userId) {
                            $user = & JUser::getInstance((int) $userId);

                            if (!$user->delete()) {
                                $db->RollbackTrans();
                                $errorPos = $file;
                                break;
                            }
                        }
                    } else {//if (strtolower($file) != "modificationdetails.csv" && strtolower($file) != "modificationrequest.csv") {
                        $error_Pos = $this->SaveDatatemp($exractedFilesDir, $file, $prefix);

                        if ($error_Pos == -2 || $error_Pos == -3 || $error_Pos == -4) {
                            $errorPos = $file;
                            break;
                        }
                    }
                }
            }
            closedir($handle);

            if ($errorPos == "") {
                $db->CommitTrans();
                return "unsynchronized data were deleted successfully";
            } elseif ($errorPos == -2) {
                return "Check Company Name Can't Complete process";
            } else {
                return "data deletion failed at file: " . $errorPos;
            }
        }
    }

    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->rrmdir($dir . "/" . $object); else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    function clear() {
        $prefix = JRequest::getvar('prefix');
        if ($prefix == 0) {
            return "You should select company";
        }
        $db = $this->_db;
        $db->BeginTrans();

        $tablesArr = array("sscategories", "sscities", "ssconstructionphasedetails", "ssconstructionphases",
            "sscontracts", "ssfinishinglevels", "ssfloors", "ssinstallments", "sspayments",
            "ssprojects", "ssprovinces", "ssregions", "ssreservationstatus", "sssubcategories", "ssunits","ssmodificationdetails"
            ,"ssmodificationrequest","ssmodificationstatus","sspimages");

        $fromnum = $prefix * (pow(10, 9));
        $tonum = ($prefix + 1) * (pow(10, 9));

        for ($i = 0; $i < count($tablesArr); $i++) {
            //$q = "truncate table cstm_" . $tablesArr[$i];
            $q = "DELETE FROM cstm_" . $tablesArr[$i] . " WHERE ID BETWEEN $fromnum AND  $tonum";
            //die($q);
            $db->setQuery($q);
            $db->query();
            if ($db->getErrorNum()) {
                $db->RollbackTrans();
                $errorPos = $row;
                return "deletion failed";
            }
        }
        //"sscustomers",
        $SelecQ = "SELECT userid FROM cstm_sscustomers WHERE ID BETWEEN $fromnum AND  $tonum";
        //die($q);
        $db->setQuery($SelecQ);
        $usersIds = $db->loadResultArray();

        for ($i = 0; $i < count($usersIds); $i++) {

            $delQ = "DELETE FROM cstm_users WHERE ID=$usersIds[$i]";
            $db->setQuery($delQ);
            $db->query();

            if ($db->getErrorNum()) {
                $db->RollbackTrans();
                $errorPos = $row;
                return "deletion failed for users";
            }

            $q = "SELECT  id from cstm_core_acl_aro where value = $usersIds[$i]";
            $db->setQuery($q);
            $core_aro = $db->loadResultArray();

            if (!empty($core_aro[0])) {
                $q = "DELETE  from cstm_core_acl_aro where id = $core_aro[0] ";
                $db->setQuery($q);
                $db->query();

                if ($db->getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    return "deletion failed for core users";
                }

                $q = "delete from cstm_core_acl_groups_aro_map where aro_id = $core_aro[0] ";
                $db->setQuery($q);
                $db->query();

                if ($db->getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    return "deletion failed";
                    ;
                }
            }
        }

        $q = "DELETE FROM cstm_sscustomers WHERE ID BETWEEN $fromnum AND  $tonum";
        $db->setQuery($q);
        $db->query();
        if ($db->getErrorNum()) {
            $db->RollbackTrans();
            $errorPos = $row;
            return "deletion failed for customers";
        }

        $db->CommitTrans();
        return "Successfully cleared";
    }

    function chmodr($path, $filemode) {

        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path . '/' . $file;

                if (chmod($fullpath, $filemode))
                    return TRUE;
                else
                    return FALSE;
            }
        }

        closedir($dh);
    }

}
