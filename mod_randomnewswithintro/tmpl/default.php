<?php 
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<ul class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
		<a href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php echo $item->text1; ?>			
		</a><br/>
		<?php if ( $params->get('category')==1)
				echo '<i>Category: '.$item->text2.'</i>';
			  if ( $params->get('intro_text')==1)
				echo '<br/>'.$item->text3; 
		?>
	</li>
<?php endforeach; ?>
</ul>
