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
$document =& JFactory::getDocument();
$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');
?>

<form action="index.php" method="post" name="adminForm">
    <div id="editcell" style="width:70%">
        <table class="adminlist">
            <tr>
                <td>
                    <?php echo JText::_( 'PROVINCE' ); ?>
                </td>
                <td>
                    <?php echo $this->provinces; ?>
                </td>
                
            </tr>
            <tr>
                <td>
                    <?php echo JText::_( 'CITY' ); ?>
                </td>
                <td>
                    <?php echo $this->cities; ?>
                </td>
               
            </tr>
            <tr>
                <td>
                    <?php echo JText::_( 'REGION' ); ?>
                </td>
                <td>
                    <?php echo $this->regions; ?>
                </td>
                
            </tr>
            <!--<tr>
                <td>
                    <?php echo JText::_( 'PROJECT' ); ?>
                </td>
                <td>
                    <?php echo $this->projects; ?>
                </td>
                
            </tr>-->
            <tr>
                <td>
                    <?php echo JText::_( 'CATEGORY' ); ?>
                </td>
                <td>
                    <?php echo $this->categories; ?>
                </td>
                
            </tr>
            <!--<tr>
                <td>
                    <?php echo JText::_( 'FINISHING LEVEL' ); ?>
                </td>
                <td>
                    <?php echo $this->finishinglevels; ?>
                </td>
                
            </tr>
            <tr>
                <td>
                    <?php echo JText::_( 'CONSTRUCTION PHASE' ); ?>
                </td>
                <td>
                    <?php echo $this->constructionPhases; ?>
                </td>
                
            </tr>-->
            <tr>
                <td>
                    <?php echo JText::_( 'FLOOR' ); ?>
                </td>
                <td>
                    <?php echo $this->floors; ?>
                </td>
               
            </tr>
            <tr>
                <td>
                    <?php echo JText::_( 'PRICE' ); ?>
                </td>
                <td >
                    <?php echo JText::_('FROM:'); ?> <input class="text_area" type="text" name="PriceFrom" id="PriceFrom" size="12" maxlength="250"  /> <?php echo JText::_( 'ONLY INTEGER VALUES ARE ALLOWED' ); ?>
                </td>
                
            </tr>
            <tr>
                <td>

                </td>

                <td>
                    <?php echo JText::_('TO:'); ?> <input class="text_area" type="text" name="PriceTo" id="PriceTo" size="12" maxlength="250"  />
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo JText::_( 'AREA' ); ?>
                </td>
                <td>
                    <?php echo JText::_('FROM:'); ?><input class="text_area" type="text" name="AreaFrom" id="AreaFrom" size="12" maxlength="250"/> <?php echo JText::_( 'ONLY INTEGER VALUES ARE ALLOWED' ); ?>
                </td>
                
            </tr>
            <tr>
                <td>

                </td>
                
                <td>
                    <?php echo JText::_('TO:'); ?> <input class="text_area" type="text" name="AreaTo" id="AreaTo" size="12" maxlength="250"  />
                </td>
            </tr>
        </table>

        <input type=submit value="<?php echo JText::_('SEARCH'); ?>">
    </div>
    
    <input type="hidden" name="option" value="com_unitsearch" />
    <input type="hidden" name="task" value="search" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="unitsearch" />
</form>
