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
defined('_JEXEC') or die('Restricted access');
if(!defined('DS'))
{
   define('DS',DIRECTORY_SEPARATOR);
}

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modLatestNewsWithIntroHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_latestnewswithintro'));
