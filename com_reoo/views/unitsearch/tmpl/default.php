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

?>
<style>
    
    
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div style="padding-top: 15px;">
	<table class="sstable" >
	<thead>
		<tr>
			
			<th>
				<b><?php echo JText::_( 'Plot Number' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Project name' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Price' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Area' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'City' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Region' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'View' ); ?></b>
			</th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->results ); $i < $n; $i++)
	{
		$row = &$this->results[$i];
		$link 		= JRoute::_( 'index.php?option=com_unitsearch&view=unitdetails&Itemid=24&uid='. $row->ID );

		?>
		<tr class="<?php echo "row$k"; ?>">
			
			<td>
				<!--{modal url=<?php echo $link ?> }<?php echo $row->PlotNumber; ?>{/modal}-->
                <a href=<?php echo $link ?> ><?php echo $row->PlotNumber; ?></a>
			</td>
            <td>
				<?php echo $row->Name; ?>
			</td>
            <td>
				<?php echo $row->TotalValue; ?>
			</td>
            <td>
				<?php echo $row->Area; ?>
			</td>
            <td>
				<?php echo $row->cname; ?>
			</td>
            <td>
				<?php echo $row->rname; ?>
			</td>
            <td>
                <?php if (file_exists("administrator/components/com_reoo/uploads/uimages/".$row->ID.".jpg")) : ?>
                    {modal url=administrator/components/com_reoo/uploads/uimages/<?php echo $row->ID; ?>.jpg}<img src="images/stories/1303403033_camera.png">{/modal}
                <?php else: ?>
                    <img src="images/stories/1303405376_no.png">
                <?php endif ?>

			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_unitsearch" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="unitsearch" />
</form>