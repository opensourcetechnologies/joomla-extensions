<?php
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
defined('JPATH_PLATFORM') or die;

use Joomla\String\StringHelper;
include_once(JPATH_BASE.'/libraries/joomla/input/input.php');
$obj = new JFilterInput();
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modRandomQuotesHelper::getList($params, $access);

// check if any results returned
$items = count($list);
if (!$items) {
	return;
}
$layout = $params->get('layout', 'default');
$layout = $obj->clean($layout, 'word');
$path = JModuleHelper::getLayoutPath('mod_randomquotes', $layout);
if (file_exists($path)) {
	require($path);
}
