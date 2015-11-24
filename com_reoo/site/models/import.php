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

jimport( 'joomla.application.component.model' );
jimport( 'joomla.user.helper' );
/**
 * subscriptionfees Model
 *
 * @package    subscriptionfees
 * @subpackage Models
 */
class importModelimport extends JModelLegacy
{

    function import($file,&$passedContentsChecks)
    {
        //echo "ss";
        //echo phpinfo();
        //die('post_max_size'.ini_get("post_max_size")."  "."max_input_time". ini_get("max_input_time")."  "."max_execution_time".ini_get("max_execution_time"));
        $msg = "<b>Import process log:</b><br />==================<br />";
        jimport('joomla.filesystem.file');

        /*old implementation
        //Clean up filename to get rid of strange characters like spaces etc
        $filename = JFile::makeSafe($file['name']);

        //Set up the source and destination of the file
        $src = $file['tmp_name'];
        $dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;

        $max_filesize = substr(ini_get("upload_max_filesize"), 0, -1)*1024*1024 ;

        //do some checks
        
        //check file size
        if ($file['size']>$max_filesize)
        return "file exceeds allowed size";
        
        //First check if the file has the right extension, we need zip only
        if ( strtolower(JFile::getExt($filename) ) == 'zip') {
            if ( ! JFile::upload($src, $dest) )
            return "upload error";
            //else
            //die("uploaded");
        }
        else {
            return "bad extension";
        }
        end old implemetation*/

        //new implementation
        //copy zip file from tmp folder
        //h$filename = "export.zip";
        //h$src = JPATH_COMPONENT . DS . "tmp" . DS . $filename;
        //h$dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;
        //hif (!JFile::copy($src,$dest))
        //hreturn "error while getting exported file";
        //end new implementation
        //checks end
        //file passed all checks

        //read file contents
        $passedContentsChecks = true;

        //unzip file
        //hrequire_once(JPATH_COMPONENT . DS . "assets" . DS ."ZipArchive.php");
        //h$zip = new ZipArchive();
        //h$res = $zip->open($dest);
        //hif ($res === TRUE) {
            //h$exractedFilesDir = JPATH_COMPONENT . DS . "uploads" . DS  .substr($filename,0,-4);
            //h$zip->extractTo($exractedFilesDir.DS);
            //h$zip->close();

            //h$msg .= "Imported file was extracted succefully";
            //die($msg);
        //h} else {
           //h $msg.= "Imorted file extraction failed";
            //delete file
            //JFile::delete($dest); //back
            //hreturn $msg;
        //h}

        //delete file
        //JFile::delete($dest);//back
       $exractedFilesDir = JPATH_COMPONENT . DS . "tmp" . DS  . "export"; //h
       
        $msg .= $this->handleFileContents($exractedFilesDir,$passedContentsChecks);

        //$this->rrmdir($exractedFilesDir);

        return $msg;

    }

    function handleFileContents($filePath,&$passedContentsChecks)
    {
        require_once(JPATH_COMPONENT . DS . "assets" . DS ."CsvParser.php");

        //loop through files
        //for each file:
        // 1- create csvparser
        // 2- call validaterows and sendcsvparser instane
        // assumptions:
        // file names are same as table names but tables has additional "ss" in z beginning

        $msg="";
        //die(JPATH_COMPONENT);
        /*if(is_dir(JPATH_COMPONENT . "/tmp"))
            die ("hhhhhhhhhhhiiiiiiiiiiii");
        else die ("failed");*/
        if ($handle = opendir($filePath)) {

            while (false !== ($file = readdir($handle)))
            {
                if ($file != "." && $file !=".." )
                {
                    if(strtolower($file) == "customers.csv")
                    $msg.=  "<br /><br /> ".$file . "<br />". $this->SaveCustomers($filePath,$file,$passedContentsChecks);
                    elseif ($file != "customers.csv" && strtolower(JFile::getExt($file) ) == 'csv')
                    $msg.=  "<br /><br /> ".$file . "<br />". $this->SaveData($filePath,$file,$passedContentsChecks);
                    //helseif(strtolower($file) == "uimages.zip")
                    //h$msg.=  "<br /><br /> ". $this->ExtractImages($filePath,"uimages");
                    //helseif(strtolower($file) == "pimages.zip")
                    //h$msg.=  "<br /><br /> ". $this->ExtractImages($filePath,"pimages");
                }
            }


            closedir($handle);
        }
        return $msg;
    }

    function SaveData($filepath,$file,&$passedContentsChecks)
    {
        $csvFile = new CsvParser($filepath.DS.$file,true, ',');
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

        $tablename = "#__ss".strtolower(substr($file, 0, -4));
        $delQ = "delete from $tablename where ID < 500000";

        $db->setQuery($delQ);
        $db->query();
        if ($db -> getErrorNum()) {
            $db->RollbackTrans();
            return "Could not delete previous data";
        }

        for($row=0; $row <$RecordsNo;$row++)
        {
            for ($col = 0; $col<$HeaderNo; $col++)
            {
                $rowArr[trim($headersArr[$col])]= trim($csvFile->fields[$row][$col]);
            }


            /*$Q = "insert  into $tablename(".substr(utf8_decode(implode(",", $headersArr)),1).")
                      VALUES ('".implode("','", $rowArr)."')";*/
            $Q = "insert into $tablename(".implode(",", $headersArr).")
                      VALUES ('".implode("','", $rowArr)."')";

            $db->setQuery($Q);
            $db->query();
            if ($db -> getErrorNum()) {
                $db->RollbackTrans();
                $errorPos = $row;
                break;
            }

        }
        if ($errorPos == -1)
        {
            $db->CommitTrans();
            return "Successfully saved";
        }
        else
        {
            $passedContentsChecks = false;
            return "Insertion failed at record no " . ($errorPos + 1);
        }

    }

    function SaveCustomers($filepath,$file,&$passedContentsChecks)
    {
        $csvFile = new CsvParser($filepath.DS.$file,true, ',');
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
        $salt = JUserHelper::genRandomPassword( 32 );

        for($row=0; $row <$RecordsNo;$row++)
        {
            for ($col = 0; $col<$HeaderNo; $col++)
            {
                $rowArr[trim($headersArr[$col])]= trim($csvFile->fields[$row][$col]);
            }

            //insert customer
            $tablename = "#__sscustomers";
            $Q = "insert into $tablename(".implode(",", $headersArr).")
                      VALUES ('".implode("','", $rowArr)."')
                    ON DUPLICATE KEY UPDATE Name = VALUES(Name),NameInArabic = VALUES(NameInArabic),Email=VALUES(Email)";
            //die($Q);
            $db->setQuery($Q);
            $db->query();
            if ($db -> getErrorNum()) {
                $db->RollbackTrans();
                $errorPos = $row;
                break;
            }
            //die($db->getAffectedRows());
            if ($db->getAffectedRows()==1) //if new row was inserted
            {
                //add users and permissions
                //
                //users
                $tablename = "#__users";
                $Q = "insert  into $tablename(username,name,email,password,gid,usertype)
                      VALUES (concat(SUBSTRING_INDEX('".$rowArr["Name"]."', ' ', 1),".$rowArr[ID]."+123),'".$rowArr["Name"]."','".$rowArr["Email"]."','".JUserHelper::getCryptedPassword('123456',$salt).':'.$salt."',18,'Registered')";

                //die($Q);
                $db->setQuery($Q);
                $db->query();
                if ($db -> getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }


                //update customer table set userid field to new inserted user id in users table
                $updateQ = "update #__sscustomers set userid = LAST_INSERT_ID() where ID = " . $rowArr[ID];
                //die ($updateQ);
                $db->setQuery($updateQ);
                $db->query();
                if ($db -> getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }

                //$ids[] = mysql_insert_id();

                //core_acl_aro
                $tablename = "#__core_acl_aro";
                $Q = "insert  into $tablename(section_value,value,name)
                      VALUES ('users',LAST_INSERT_ID(),'".$rowArr["Name"]."')";

                //die($Q);
                $db->setQuery($Q);
                $db->query();
                if ($db -> getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }

                //_core_acl_groups_aro_map
                $tablename = "#__core_acl_groups_aro_map";
                $Q = "insert  into $tablename(group_id,aro_id)
                      VALUES (18,LAST_INSERT_ID())";

                //die($Q);
                $db->setQuery($Q);
                $db->query();
                if ($db -> getErrorNum()) {
                    $db->RollbackTrans();
                    $errorPos = $row;
                    break;
                }

            }
        }


        /*if ($errorPos == -1)
        {
            $Q = "update #__users set username= concat(SUBSTRING_INDEX(name, ' ', 1),id+123) where id in (".implode(",", $ids).")";

            //die($Q);
            $db->setQuery($Q);
            $db->query();
            if ($db -> getErrorNum()) {
                $db->RollbackTrans();
            }
        }*/

        if ($errorPos == -1)
        {
            $db->CommitTrans();
            return "Successfully saved";
        }
        else
        {
            $passedContentsChecks = false;
            return "Insertion failed at record no " . ($errorPos + 1);
        }

    }

    function ExtractImages($filePath,$filename)
    {
        //unzip file
        require_once(JPATH_COMPONENT . DS . "assets" . DS ."ZipArchive.php");
        $zip = new ZipArchive();
        $res = $zip->open($filePath.DS.$filename.".zip");
        if ($res === TRUE) {
            $exractedFilesDir = JPATH_COMPONENT . DS . "uploads" . DS  . $filename;
            if($zip->extractTo($exractedFilesDir.DS))
            {
                $zip->close();
                return $filename." file was extracted succefully";
            }
            else
            return $filename." file extraction failed";

        } else {
            return $filename." file opening failed";
        }
    }

    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
