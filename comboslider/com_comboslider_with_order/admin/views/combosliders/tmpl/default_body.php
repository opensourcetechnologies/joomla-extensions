<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
 $listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'ordering';
?>
<?php /*foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->type; ?>
		</td>
	</tr>
<?php endforeach;*/ ?>
<style>
.jgrid span.uparrow					{  background-repeat:no-repeat;height:12px; }

.jgrid span.downarrow				{ background-repeat:no-repeat; height:12px;}

</style>

<form action="#" method="post" id="adminform" name="adminForm">
<div id="editcell">
	<table class="adminlist table table-strip">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				
			</th>			
			<th align="left">
				<?php echo JText::_( 'Type' ); ?>
			</th>
			<th align="left"><?php echo JText::_( 'Published' ); ?></th>
			  <th width="50" align="left" ><?php echo JText::_('REORDER'); ?></th>
			<th align="left">
			<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
					
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'combosliders.saveorder'); ?>
					
			</th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_comboslider&controller=comboslider&task=comboslider.edit&cid[]='. $row->id );
		//$published 	= JHTML::_('grid.published', $row, $i );
		$canChange	= $user->authorise('core.edit.state',	'com_comboslider.comboslider.'.$row->id);
		
		$published=JHtml::_('jgrid.published', $row->published, $i, 'comboslider.', $canChange, 'cb'); 
		
		    // $ordering	= ($listOrder == 'a.ordering');
			
			
		
		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="left">
				<?php echo $row->id; ?>
			</td>
			<td align="left">
				<?php echo $checked; ?>
			</td>
			<td align="left">
				<a href="<?php echo $link; ?>"><?php echo ucfirst($row->type); ?></a>
			</td>
			<td align="left"><?php echo $published;?></td>
			  <td width="50" align="left"><?php echo $this->pageNav->orderUpIcon( $i, $n,'comboslider.orderup' ); ?>&nbsp;
		
			 
			  <?php echo $this->pageNav->orderDownIcon( $i, $n,'comboslider.orderdown','comboslider.orderdown' ); ?></td>
       
        <td align="left"><input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" /></td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_comboslider" />
<input type="hidden" name="task" value="comboslider" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="comboslider" />

  <?php echo JHTML::_( 'form.token' ); ?>
</form>
