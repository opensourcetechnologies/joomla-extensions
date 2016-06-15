<?php 
/**
* @package		Joomla
* @date			10.03.14
* @copyright	Copyright (C) 2009 - 2014 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
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
