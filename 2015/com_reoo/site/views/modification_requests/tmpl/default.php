<?php
//-- No direct access
defined('_JEXEC') or die('=;)');
?>
<style>
    .row0
    {
        background-color:#f2f2f2;
    }
    .sstable
    {
       border:solid 1px silver;
    }
    .sstable td
    {
       padding-left:4px;
        padding-right:4px;
        padding-top:1px;
        border-right:1px solid silver;
    }
    .sstable th
    {
       padding-left:4px;
        padding-right:4px;
        padding-top:1px;
        border-right:1px solid silver;
        border-bottom: solid 1px silver;
    }
    .sstable thead
    {
        border-bottom: solid 1px silver;
    }
</style>
<div  align="center">
	<table class="sstable" width="80%" cellspacing="0" cellpadding="0">
	
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->requests ); $i < $n; $i++)
	{
		$row = &$this->requests[$i];

		?>
		<tr class="<?php echo "row$k"; ?>">

			<td align="center">
				<?php echo $row->Subject; ?>
			</td>
            <td align="center">
				<?php echo $row->ModificationData; ?>
			</td>
            <td align="center">
				<?php echo $row->PossibiltyToDo; ?>
            </td>
             <td align="center">
				<?php echo $row->Name; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<div  style="margin-top:10px;">
    <?php echo JText::_( 'REQUESTS ARE BEING UPDATED' ); ?>
</div>
<div class="clr"></div>
