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

$baseurl = JURI::base();
$document = &JFactory::getDocument();
$document->addScript( $baseurl.'/components/com_reoo/views/import/tmpl/jquery-1.7.2.js' );

//$session = JFactory::getSession();
## Erase cart session data
//$session->clear('chunk_count');
//$chunk_count = $session->get('chunk_count');

//if(isset($chunk_count)) die($chunk_count);

?>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
<!-- <form action="" method="post" name="adminForm" enctype="multipart/form-data"> -->
    <div id="editcell">
	 <div id='message'></div>
        <table class="adminlist">
            <tr>
                <td>Please select company
                    <select name="prefix" id="prefix">
                        <option value="0"></option>
                        <?php foreach ($this->companies as $company) { ?>
                        <option value="<?php echo $company->ID; ?>"  ><?php echo $company->Name; ?></option>
                        <?php } ?>
                    </select>
                    
                </td>
            </tr>
            <tr>
                <td width="80%">
                    <!-- <input type=submit class="submit" onclick="submitClick()" value="Import"> -->
                    <button type="button" id="btnImport" class="submit" onclick="submitClick()" >Import</button>
                    <script type="text/javascript">
                        
			function PerformTask()
                        {
                            for(var i=0; i<44;i++)
                              {
                                 submitClick();

                                 if($("#prefix option:selected").val() == 0)
                                      break;
                              }    
                        }

			function submitClick()
                        {
                         var xmlhttp;
                        
                         if (window.XMLHttpRequest)
                          { // code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp=new XMLHttpRequest();
                          }
                          else
                          { // code for IE6, IE5
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                          }

                          xmlhttp.onreadystatechange=function()
                          {
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                if($("#prefix option:selected").val() == 0){
                                    document.getElementById("message").innerHTML = xmlhttp.responseText ;
                                }
                                else{
                                    document.getElementById("message").innerHTML+=xmlhttp.responseText ;

                                    if(xmlhttp.responseText.indexOf("Check Company Name Can't Complete process") != -1){
                                        alert("You select a wrong company, import process will be terminated");
                                        //var r=confirm("You select a wrong company, do you want to terminate the import process?");
                                        //if ( r == true ){
                                            $("#prefix").removeAttr("disabled");
                                            $("input#current").val("ExtractImportedFile");
                                            $("#btnImport").text('Import');
                                            document.getElementById("message").innerHTML+= "<h3>Import process has been terminated</h3>";
                                            $("#prefix option:selected").val(0);
					    $("select#prefix")[0].selectedIndex = 0;
					//}
                                        //else{
                                        //    alert("You pressed Cancel!");
                                        //}
                                    }
                                    if(xmlhttp.responseText.indexOf("step") != -1){
                                        var startIndex = xmlhttp.responseText.lastIndexOf("in [");
                                        var endIndex = xmlhttp.responseText.lastIndexOf("] step");
                                        var chunksCount = xmlhttp.responseText.slice(startIndex+4,endIndex);
                                        $("input#chunk_count").val(chunksCount);
                                    }
                                    $("#btnImport").removeAttr("disabled");

                                    /*
                                    var fileExtension = "";
                                    var lastDotIndex = $("input#current").val().lastIndexOf(".");
                                    if(lastDotIndex != -1) {    // Common case
                                        fileExtension = $("input#current").val().slice(lastDotIndex+1);
                                    }
                                    */

                                    if($("input#current").val() == "ConstructionPhaseDetails.csv" ||
                                        $("input#current").val() == "ConstructionPhases.csv" ||
                                        $("input#current").val() == "Contracts.csv" ||
                                        $("input#current").val() == "FinishingLevels.csv" ||
                                        $("input#current").val() == "Installments.csv" ||
                                        $("input#current").val() == "ModificationDetails.csv" ||
                                        $("input#current").val() == "ModificationRequest.csv" ||
                                        $("input#current").val() == "ModificationStatus.csv" ||
                                        $("input#current").val() == "Payments.csv" ||
                                        $("input#current").val() == "pimages.csv" ||
                                        $("input#current").val() == "Projects.csv" ||
                                        $("input#current").val() == "ReservationStatus.csv" ||
                                        $("input#current").val() == "SubCategories.csv" ||
                                        $("input#current").val() == "Units.csv")
                                    {
                                        //alert(Number($("input#chunk_no").val()) + " --- " +  Number($("input#chunk_count").val()));
                                         if(Number($("input#chunk_no").val()) >= Number($("input#chunk_count").val())){
                                           $("input#chunk_no").val('0');
                                           MoveNext();
                                        }
                                        else
                                        {
                                            //alert($("input#chunk_no").val());
                                            $("input#chunk_no").val(Number($("input#chunk_no").val()) + 1) ;
                                             submitClick();
                                        }
                                    }
                                    else{
                                        MoveNext();
                                    }
                                }
                                
                             }
                          }

                          var url = "<?php echo $baseurl.'/components/com_reoo/views/import/tmpl/import.php?'?>";
                              url += "prefix=" + $("#prefix option:selected").val();
                              url += "&current=" + $("input#current").val();
                              url += "&existingids_sub=" + $("input#existingids_sub").val();
                              url += "&chunk_no=" + $("input#chunk_no").val();
                          
                          xmlhttp.open("GET",url ,false);
                          xmlhttp.send();
                          //$("#btnImport").attr("disabled", "disabled");
                          //if($("#prefix option:selected").val() > 0)
                          //    MoveNext();

                          return false;
                        }

                        function MoveNext()
                        {
                            var move = true;
                            //alert($("input#chunk_count").val());
			     //$("#btnImport").attr("disabled", "disabled");
                             var current = $("input#current").val();
                              switch(current)
                              {
                                    case 'Begin': 
                                        $("input#current").val("ExtractImportedFile");
                                        $("#btnImport").text('Next');
                                        $("#prefix").attr("disabled", "disabled");
                                        break;
                                    case 'ExtractImportedFile':
                                        $("input#current").val("Customers.csv");
                                        break;
                                    case 'Customers.csv':
                                        $("input#current").val("Floors.csv");
                                        //$("#btnImport").text('Next');
                                        break;
                                    case 'Floors.csv':
                                        $("input#current").val("Categories.csv");
                                        break;
                                    case 'Categories.csv':
                                        $("input#current").val("Provinces.csv");
                                        break;
                                    case 'Provinces.csv':
                                        $("input#current").val("Cities.csv");
                                        break;
                                    case 'Cities.csv':
                                        $("input#current").val("Regions.csv");
                                        break;
                                    case 'Regions.csv':
                                        $("input#current").val("ConstructionPhaseDetails.csv");
                                        break;
                                    case 'ConstructionPhaseDetails.csv':
                                        $("input#current").val("ConstructionPhases.csv");
                                        break;
                                    case 'ConstructionPhases.csv':
                                        $("input#current").val("Contracts.csv");
                                        break;
                                    case 'Contracts.csv':
                                        $("input#current").val("FinishingLevels.csv");
                                        break;
                                    case 'FinishingLevels.csv':
                                        $("input#current").val("Installments.csv");
                                        break;
                                    case 'Installments.csv':
                                        $("input#current").val("ModificationDetails.csv");
                                        break;
                                    case 'ModificationDetails.csv':
                                        $("input#current").val("ModificationRequest.csv");
                                        break;
                                    case 'ModificationRequest.csv':
                                        $("input#current").val("ModificationStatus.csv");
                                        break;
                                    case 'ModificationStatus.csv':
                                        $("input#current").val("Payments.csv");
                                        break;
                                    case 'Payments.csv':
                                        $("input#current").val("pimages.csv");
                                        break;
                                    case 'pimages.csv':
                                        $("input#current").val("Projects.csv");
                                        break;
                                    case 'Projects.csv':
                                        $("input#current").val("ReservationStatus.csv");
                                        break;
                                    case 'ReservationStatus.csv':
                                        $("input#current").val("SubCategories.csv");
                                        break;
                                    case 'SubCategories.csv':
                                        $("input#current").val("Units.csv");
                                        break;
                                    case 'Units.csv':
                                        $("input#current").val("uimages.zip");
                                        break;

                                    case 'uimages.zip':
                                        $("input#current").val("pimages.zip");
                                        break;
                                    case 'pimages.zip':
                                        $("input#current").val("existingIDs.zip");
                                        break;    
                                    case 'existingIDs.zip':
                                         var existingids_sub = $("input#existingids_sub").val();
                                         switch(existingids_sub)
                                         {
                                                case 'ExtractExistingIDs':
                                                     $("input#existingids_sub").val("Customers.csv");
                                                    break;
                                                case 'Customers.csv':
                                                    $("input#existingids_sub").val("Floors.csv");
                                                    break;
                                                case 'Floors.csv':
                                                    $("input#existingids_sub").val("Categories.csv");
                                                    break;
                                                case 'Categories.csv':
                                                    $("input#existingids_sub").val("Provinces.csv");
                                                    break;
                                                case 'Provinces.csv':
                                                    $("input#existingids_sub").val("Cities.csv");
                                                    break;
                                                case 'Cities.csv':
                                                    $("input#existingids_sub").val("Regions.csv");
                                                    break;
                                                case 'Regions.csv':
                                                    $("input#existingids_sub").val("ConstructionPhaseDetails.csv");
                                                    break;
                                                case 'ConstructionPhaseDetails.csv':
                                                    $("input#existingids_sub").val("ConstructionPhases.csv");
                                                    break;
                                                case 'ConstructionPhases.csv':
                                                    $("input#existingids_sub").val("Contracts.csv");
                                                    break;
                                                case 'Contracts.csv':
                                                    $("input#existingids_sub").val("FinishingLevels.csv");
                                                    break;
                                                case 'FinishingLevels.csv':
                                                    $("input#existingids_sub").val("Installments.csv");
                                                    break;
                                                case 'Installments.csv':
                                                    $("input#existingids_sub").val("ModificationDetails.csv");
                                                    break;
                                                case 'ModificationDetails.csv':
                                                    $("input#existingids_sub").val("ModificationRequest.csv");
                                                    break;
                                                case 'ModificationRequest.csv':
                                                    $("input#existingids_sub").val("ModificationStatus.csv");
                                                    break;
                                                case 'ModificationStatus.csv':
                                                    $("input#existingids_sub").val("Payments.csv");
                                                    break;
                                                case 'Payments.csv':
                                                    $("input#existingids_sub").val("Projects.csv");
                                                    break;
                                                case 'Projects.csv':
                                                    $("input#existingids_sub").val("ReservationStatus.csv");
                                                    break;
                                                case 'ReservationStatus.csv':
                                                    $("input#existingids_sub").val("SubCategories.csv");
                                                    break;
                                                case 'SubCategories.csv':
                                                    $("input#existingids_sub").val("Units.csv");
                                                    break;
                                                case 'Units.csv':
                                                    $("input#current").val("Finish");
                                                    $("input#existingids_sub").val('ExtractExistingIDs');
                                                    break;
                                        }
                                        break;
                                    case 'Finish':
                                        move = false;
                                        $("#prefix").removeAttr("disabled");
					                    $("#btnImport").removeAttr("disabled");
                                        $("input#current").val("ExtractImportedFile");
                                        $("#btnImport").text('Import');
                                    default:
                                        break;
                              }
                              
                              if(move)
                                  submitClick();
                                  //$("#btnImport").click();
                        }
                    </script>
                </td>
            </tr>
    <!--<tr><td></td><td><font color="red">max file size is <?php echo ini_get("upload_max_filesize") ?></font></td></tr>-->
        </table>
    </div>
    <?php //echo 'post_max_size'.ini_get("post_max_size")."  "."max_input_time". ini_get("max_input_time")."  "."max_execution_time".ini_get("max_execution_time");  ?>
    <input type="hidden" name="option" value="com_reoo" />
    <!-- <input type="hidden" name="prefix" value="prefix"/> -->
    <!-- <input type="hidden" name="task" value="import" /> -->
    <input type="hidden" name="boxchecked" value="0" />
    <!-- <input type="hidden" name="controller" value="import" /> -->
    <input type="hidden" name="current" id="current" class="hidden" value="Begin" />
    <input type="hidden" name="chunk_count" id="chunk_count" class="hidden" value="1" />
    <input type="hidden" name="chunk_no" id="chunk_no" class="hidden" value="0" />
    <input type="hidden" name="existingids_sub" id="existingids_sub" class="hidden" value="ExtractExistingIDs" />
    <!-- <input type="hidden" name="view" value="importfiles" /> -->

   
</form>

<script>
    function confirmAction()
    {
        answer = confirm("This action will remove all previous data, including created users. Are you sure that you want to perform this action??");
        if (answer == true)
        {
            answer2 = confirm("You selected to clear all imported data. Continue??");
            return answer2;
        }
        else
            return answer;
    }
</script>
<form action="index.php" method="post" name="adminForm" onsubmit="return confirmAction()">
    <div id="editcell">
        <table class="adminlist">
            <tr>
                <td>Please enter the name of company you want to delete its data
                    <select name="prefix" id="prefix">
                         <option value="0"></option>
                        <?php foreach ($this->companies as $company) { ?>
                            <option value="<?php echo $company->ID; ?>"><?php echo $company->Name; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="80%">
                    <input type=submit value="Clear Data">
                </td>
            </tr>
        </table>
    </div>
    <?php //echo 'post_max_size'.ini_get("post_max_size")."  "."max_input_time". ini_get("max_input_time")."  "."max_execution_time".ini_get("max_execution_time");  ?>
    <input type="hidden" name="option" value="com_reoo" />
    <input type="hidden" name="task" value="clear" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="import" />
</form>
