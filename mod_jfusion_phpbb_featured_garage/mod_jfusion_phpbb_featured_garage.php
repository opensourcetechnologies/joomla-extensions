<?php
/**
 * @package    Joomla.Forum
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
$factory_file =  JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jfusion' . DIRECTORY_SEPARATOR . 'import.php';

try {
	if (file_exists($factory_file)) {
		
	/**
	* require the JFusion libraries
	*/
	require_once $factory_file;
	/**
	     * @ignore
	     * @var $params JRegistry
	     * @var $config array
	*/
	global $config;		 
	$pluginParamValue = $params->get('JFusionPlugin');
	$pluginParamValue = unserialize(base64_decode($pluginParamValue));
	$jname = $pluginParamValue['jfusionplugin'];
	
	$public = JFusionFactory::getPublic($jname);
	
	if($public->isConfigured()) {
		
	$config['forum_dir'] 		= trim($params->get('forum_dir'),"/");
	$config['title']			 = $params->get('title');
	$config['count'] 			 = $params->get('count');
	$config['moduleclass_sfx']	 = htmlspecialchars($params->get('moduleclass_sfx'));
	$config['itemid'] 			 = $params->get('itemid');
	
		
	if (empty($config['itemid'])) {
		throw new RuntimeException(JText::_('NO_ITEMID_SELLECTED'));
	}
	
	if (empty($config['forum_dir'])) {
		throw new RuntimeException(JText::_('NO_FORUM_DIRECTORY'));
	}

	$css = JURI::root().'/modules/mod_jfusion_phpbb_featured_garage/assets/category.css';
	
	
	require_once __DIR__ . '/helper.php';
		
	$document = JFactory::getDocument();
	$document->addStyleSheet($css);
	$lists = new ModGarageFeaturedHelper;
	$Cardata = $lists->getStats();
	$imageData  = $lists->getImage();
	
	require JModuleHelper::getLayoutPath('mod_jfusion_phpbb_featured_garage', $params->get('layout', 'default'));
	}
	else {
		if (empty($jname)) {
			throw new RuntimeException(JText::_('NO_PLUGIN'));
		} else {
			throw new RuntimeException(JText::_('MODULE_NOT_CONFIGURED'));
		}
	}
} 
}catch (Exception $e) {
	JFusionFunction::raiseError($e, 'mod_jfusion_phpbb_featured_garage');
	echo $e->getMessage();
}
