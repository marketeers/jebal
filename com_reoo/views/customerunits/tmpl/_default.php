<?php
//-- No direct access
defined('_JEXEC') or die('=;)');


$document = JFactory::getDocument();

/* Added By Abdo Mohamed 2015-11-14 For Modal box view Start*/
$url= JUri::base() ."plugins/fancybox/source/jquery.fancybox.css";
$document->addStyleSheet($url);
$url=JUri::base() . 'plugins/fancybox/source/jquery.fancybox.js';
$document->addScript($url);
$url=JUri::base() . 'plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js';
$document->addScript($url);
/* Added By Abdo Mohamed 2015-11-14 For Modal box view End*/
?>

<style>
.datagrid table {
border-collapse:collapse;
text-align:right;
width:100%;
}

.datagrid {
font:normal 12px/150% Arial, Helvetica, sans-serif;
background:#fff;
overflow:hidden;
border:1px solid #8C8C8C;
-webkit-border-radius:3px;
-moz-border-radius:3px;
border-radius:3px;
}

.datagrid table td{
	    text-align: center;
}
.datagrid table th {
    width: 245px;
    text-align: center;
    padding: 10px;
    line-height: 30px;
}

.datagrid table thead th {
background:0;
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C',endColorstr='#7D7D7D');
background-color:#8C8C8C;
color:#FFF;
font-size:15px;
font-weight:700;
border-left:1px solid #A3A3A3;
}

.datagrid table thead th:first-child {
border:none;
}
.datagrid table tbody  {
    border-bottom: 1px solid #8C8C8C;
	}
.datagrid table tbody td {
color:#7D7D7D;
border-left:1px solid #DBDBDB;
font-size:16px;
font-weight:bold;
}

.datagrid table tbody .alt td {
background:#EBEBEB;
color:#7D7D7D;
}

.datagrid table tbody td:first-child {
border-left:none;
}

.datagrid table tbody tr:last-child td {
border-bottom:none;
}

.datagrid table tfoot td div {
border-top:1px solid #8C8C8C;
background:#EBEBEB;
padding:2px;
direction: rtl;
}

.datagrid table tfoot td {
font-size:12px;
padding:0;
}

.datagrid table tfoot td ul {
list-style:none;
text-align:right;
margin:0;
padding:0;
}

.datagrid table tfoot li {
display:inline;
}

.datagrid table tfoot li a {
text-decoration:none;
display:inline-block;
color:#F5F5F5;
border:1px solid #8C8C8C;
-webkit-border-radius:3px;
-moz-border-radius:3px;
border-radius:3px;
background:0;
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C',endColorstr='#7D7D7D');
background-color:#8C8C8C;
margin:1px;
padding:2px 8px;
}

.datagrid table tfoot ul.active,.datagrid table tfoot ul a:hover {
text-decoration:none;
color:#F5F5F5;
background:none;
background-color:#8C8C8C;
border-color:#7D7D7D;
}

div.dhtmlx_window_active,div.dhx_modal_cover_dv {
position:fixed!important;
}


</style>


<script type="text/javascript">
/* Added By Abdo Mohamed 2015-11-14 For Modal box view*/
jQuery(document).ready(function($) {
            /*
             *  Simple image gallery. Uses default settings
             */
        var options = 
        {
               'padding':0,
               'autoScale': false,
               'transitionIn':'none',
               'transitionOut':'none',
               'width':'100%',
               'scrolling':'yes'
        }
        $('.fancybox').fancybox(options);
});
/* Added By Abdo Mohamed 2015-11-14 Close*/
</script>
<div class="datagrid">
   <table>
            <thead>
            <tr style="color: #000;">
                <th>
                    <b><?php echo JText::_('Project Name'); ?></b>
                </th>
                <th>
                    <b><?php echo JText::_('Plot Number'); ?></b>
                </th>
                <th>
                    <b><?php echo JText::_('Phase Name'); ?></b>
                </th>
                <th>
                    <b><?php echo JText::_('Price'); ?></b>
                </th>
                <th>
                    <b><?php echo JText::_('Market Value'); ?></b>
                </th>
                <th>
                    <b><?php echo JText::_('Installments'); ?></b>
                </th>

            </tr>
        </thead>
        <?php
        $k = 0;
        for ($i = 0, $n = count($this->units); $i < $n; $i++) {
            $row = &$this->units[$i];

            $link = JRoute::_('index.php?option=com_reoo&view=payments&id=' . $row->CID);
            $ulink = JRoute::_('index.php?option=com_reoo&view=unitdetails&uid=' . $row->ID . '&res=0');
            //$reqlink    = JRoute::_( 'index.php?option=com_reoo&view=modification_requests&uid='. $row->ID );
            ?>
			<tbody>
            <tr class="<?php echo "row$k"; ?>">
                <td>
                    <?php echo $row->Name; ?>
                </td>
                <td>
                    <?php echo $row->PlotNumber; ?> (
                    <a class="fancybox fancybox.iframe" style="font-weight: normal/*bold*/;font-size: 14px;" href=<?php echo $ulink ?> ><?php echo JText::_('Plot Details')?></a> )
                </td>
                <td>
                    <?php echo $row->ConstructionPhase; ?>
                </td>
                <td>
                    <?php echo $row->TotalValue; ?>
                </td>
                <td>
                    <?php echo $row->paid; ?>
                </td>
                <td>
                    <?php 
                        echo "{$row->inst} ".JText::_('Installment')." (<a href='{$link}&ml=1' class='fancybox fancybox.iframe'>View</a>)";   
                    ?>            
			   </td>

            </tr>
            <?php
            $k = 1 - $k;
        }
        ?>
		</tbody>
    </table>
</div>

<div style="margin-top:10px;">
    <?php echo JText::_('Payments And Installments Data Is Being Updated'); ?>
</div>
<div class="clr"></div>



