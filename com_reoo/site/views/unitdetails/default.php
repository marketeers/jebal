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
<a style="padding-bottom:10px;" name="fb_share" type="box_count" share_url="<?php echo $host . $_SERVER['REQUEST_URI']; ?>" href="http://www.facebook.com/sharer.php">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
<br />
<form action="index.php?option=com_mad4joomla&jid=2" method="post" name="adminForm" id="adminForm">
<div class="col100">

	<table class="adminlist">
        <tr>
			<td width=20%>
				<b><?php echo JText::_( 'Place' ); ?></b>
			</td>
            <td>
				<?php echo $row->province .", " .$row->city . ", ". $row->region; ?>
			</td>
		</tr>
        <tr>
			<td>
				<b><?php echo JText::_( 'Project name' ); ?></b>
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
				<b><?php echo JText::_( 'Area' ); ?></b>
			</td>
            <td>
				<?php echo $row->Area; ?>
			</td>
		</tr>
        <tr>
			<td>
				<b><?php echo JText::_( 'Price' ); ?></b>
			</td>
            <td>
				<?php echo $row->UnitValue ;//. "  (". JText::_( 'including garage value if garage exists' ) .")"; ?>
			</td>
		</tr>
        <tr>
			<td>
				<b><?php echo JText::_( 'Have Garage' ); ?></b>
			</td>
            <td>
				<?php if ($row->HaveGarage) echo JText::_( 'yes' ); else echo JText::_( "No" ); ?>
			</td>
		</tr>
        <tr>
			<td>
				<b><?php echo JText::_( 'Garage value' ); ?></b>
			</td>
            <td>
				<?php echo $row->GarageValue; ?>
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
			<td>
				<b><?php echo JText::_( 'Reservation Status' ); ?></b>
			</td>
            <td>
				<?php echo $row->reserv; ?>
			</td>
		</tr>
         <tr>
			<td>
				<b><?php echo JText::_( 'Initial Delivery Date' ); ?></b>
			</td>
            <td>
				<?php echo $row->IntialDeliveryDate; ?>
			</td>
		</tr>
         <tr>
			<td>
				<b><?php echo JText::_( 'Final Delivery Date' ); ?></b>
			</td>
            <td>
				<?php echo $row->FinalDeliveryDate; ?>
			</td>
		</tr>
       <tr>
			<td valign=top>
				<b><?php echo JText::_( 'Category' ); ?></b>
			</td>
            <td>
				<?php echo $row->cat . "<br />" . $row->subcat; ?>
			</td>
		</tr>
        <tr>
			<td valign=top>
				<b><?php echo JText::_( 'Construction Phase' ); ?></b>
			</td>
            <td>
				<?php echo $row->const. "<br />" . $row->constdetails; ?>
			</td>
		</tr>
         <tr>
			<td valign=top>
				<b><?php echo JText::_( 'Image' ); ?></b>
			</td>
            <td>
				
			</td>
		</tr>
        <tr>
            <td colspan="2">
				<img src="administrator/components/com_reoo/uploads/images/<?php echo $row->uid; ?>.jpg" width="400" height="400" alt="No Image Available"/>
			</td>
		</tr>
		
	</table>
</div>
<div class="clr"></div>

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
<br />
<input type="submit" value="<?php echo JText::_( 'Reserve' ); ?>" class="ssbutton" style="width:150px !important;">
</form>
