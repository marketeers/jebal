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
$row = $this->results[0];
$uri		= JFactory::getURI();
$host		= $uri->toString( array ('scheme', 'host', 'port' ) );
?>
<br />
<form action="index.php?option=com_reservationlead&view=reservationlead" method="post" name="adminForm" id="adminForm">
    <div class="col100">

        <table class="adminlist table">
            <tr>
                <td width=25%>
                    <b><?php echo JText::_( 'Location' ); ?></b>
                </td>
                <td>
                    <?php echo $row->province .", " .$row->city; ?>
                </td>
            </tr>
			  <tr>
                <td>
                    <b><?php echo JText::_( 'Phase Name' ); ?></b>
                </td>
                <td>
                    <?php echo $row->const; ?>
                </td>
            </tr>
			
            <tr>
                <td>
                    <b><?php echo JText::_( 'Building No' ); ?></b>
                </td>
                <td>
                    <?php echo $row->Name; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><b><?php echo JText::_( 'Plot Number' ); ?></b>
                </td>
                <td>
                    <?php echo $row->PlotNumber; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo JText::_( 'Unit Area' ); ?></b>
                </td>
                <td>
                    <?php echo $row->Area; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo JText::_( 'Market Price' ); ?></b>
                </td>
                <td>
                    <?php echo $row->UnitValue ;//. "  (". JText::_( 'including garage value if garage exists' ) .")"; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo JText::_( 'Floor' ); ?></b>
                </td>
                <td>
                    <?php echo $row->floor; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo JText::_( 'Finishing Level' ); ?></b>
                </td>
                <td>
                    <?php echo $row->flevel; ?>
                </td>
            </tr>
            <tr>
                <td valign=top>
                    <b><?php echo JText::_( 'Chalet Type' ); ?></b>
                </td>
                <td>
                    <?php echo $row->cat; ?>
                </td>
            </tr>
            <?php if(isset($_GET['res'])) : ?>
            <tr>
                <td valign=top>
                    <b><?php echo JText::_( 'Unit type' ); ?></b>
                </td>
                <td>
                    <?php echo $row->subcat;?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td valign=top>
                    <b><?php echo JText::_( 'Unit borders' ); ?></b>
                </td>
                <td>
                    <?php echo $row->PlotBoundaries; ?>
                </td>
            </tr>
            <tr>
                <td valign=top>
                    <b><?php echo JText::_( 'Unit Design' ); ?></b>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php if (file_exists("administrator/components/com_reoo/uploads/uimages/".$row->uid.".jpg")) : ?>
                    <img src="administrator/components/com_reoo/uploads/uimages/<?php echo $row->uid; ?>.jpg" width="400" height="400"/>
                    <?php else: ?>
                    <img src="images/no_photo_result.gif">
                    <?php endif ?>

                </td>
            </tr>

            <?php $user =& JFactory::getUser();
            if($user->id && isset($_GET['res'])): ?>
            <tr>
                <td valign=top>
                    <b><?php echo JText::_( 'project progress' ); ?></b>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    if (count($this->pimages) > 0) {
                        for($i=0; $i < count($this->pimages) ; $i++)
                        {
                            echo '<img src="administrator/components/com_reoo/uploads/pimages/'.$this->pimages[$i].'.jpg" width="400" height="400"/><br />';
                        }
                    }
                    else
                    echo '<img src="images/no_photo_result.gif"><br />';
                    ?>
                </td>
            </tr>
            <?php endif; ?>

        </table>
    </div>
    
    
    <!-- reservation hidden fields -->
    <input type="hidden" name="project" value="<?php echo $row->Name; ?>" />
    <input type="hidden" name="PlotNumber" value="<?php echo $row->PlotNumber; ?>" />
    <input type="hidden" name="Area" value="<?php echo $row->Area; ?>" />
    <input type="hidden" name="floor" value="<?php echo $row->floor; ?>" />
    <input type="hidden" name="UnitValue" value="<?php echo $row->UnitValue; ?>" />


    <!--<input type="hidden" name="option" value="com_unitsearch" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="unitsearch" />-->
    <br />
    <?php if(!isset($_GET['res'])) : ?>
    <input type="submit" value="<?php echo JText::_( 'Reserve' ); ?>" class="ssbutton" style="width:150px !important;">
    <?php endif; ?>
    <input type="button" value="<?php echo JText::_( 'BACK' ); ?>" class="ssbutton" style="width:150px !important;" onclick="javascript:history.go(-1);">
</form>
