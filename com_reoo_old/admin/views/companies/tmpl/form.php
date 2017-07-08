<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="company">
					<?php echo JText::_( 'Company' ); ?>:
				</label>
			</td>
			<td>
			<input class="text_area" type="text" name="Name" id="Name" size="32" maxlength="250" value="<?php echo $this->company->Name;?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_reoo" />
<input type="hidden" name="ID" value="<?php echo $this->company->ID; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="companies" />
</form>
