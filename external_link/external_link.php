<?php
/**
 * @package     Plugin for for Joomla! 3.x
 * @date: 2015-11-03
 * @version	3.0
 * @author	opensourcetechnologies.com
 * @copyright	(C) 2009-2015 OPENSOURCETECHNOLOGIES. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;

class plgSystemexternal_link extends JPlugin
{
	function onBeforeRender()
	{	
		$app = JFactory::getApplication();
		if($app->isSite())
     		{

		$document = JFactory::getDocument();
		
		$site_name = $app->getCfg('sitename');
		$document->addScriptDeclaration('
			var sitename = "'.$site_name.'";
			var sitepath = "'. JURI::base().'";
		');
		$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		$document->addScript('plugins/system/external_link/js/jquery.leaveNotice.min.js');
		$document->addScript('plugins/system/external_link/js/addpopup.js');
		$document->addStyleSheet('plugins/system/external_link/css/jquery.leaveNotice.css');
		//$document->addStyleSheet('plugins/system/external_link/css/leaveNoticeDocs.css');
	  	}
	}
}
?>
