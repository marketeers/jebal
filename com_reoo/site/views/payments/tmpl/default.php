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
 line-height: 2em;
 font-size: 16px;
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
        padding-left:7px;
        padding-right:6px;
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
	<table class="sstable" cellspacing="5" cellpadding="5">
	<thead>
		<tr>
			<th>
				<b><?php echo JText::_( 'Total Amount' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Paid Amount' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Remaining Amount' ); ?></b>
			</th>
            <th>
				<b><?php echo JText::_( 'Type' ); ?></b>
			</th>
            
            <th>
				<b><?php echo JText::_( 'Date' ); ?></b>
			</th>
		</tr>	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->installments ); $i < $n; $i++)
	{
		$row = &$this->installments[$i];

		?>
		<tr class="<?php echo "row$k"; ?>">

            <td align="center">
				<?php echo $row->Amount ; ?>
			</td>
            <td align="center">
				<?php echo $row->pamount ; ?>
			</td>
			<td align="center">
				<?php echo $row->Amount - $row->pamount ; ?>
			</td>
            <td align="center" width="15%">
				<?php echo $row->Type; ?>
			</td>
            
            <td align="center">
				<?php echo $row->idate; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>
<div  style="margin-top:10px;">
    <?php echo JText::_( 'Payments And Installments Data Is Being Updated' ); ?>
</div>
<!--
 <input type="button" value="<?php echo JText::_( 'BACK' ); ?>" class="ssbutton" style="width:150px !important;" onclick="javascript:history.go(-1);">
 -->
<div class="clr"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#rt-top-surround").hide();
        $("#rt-footer-surround").hide();
    });
</script>
