<?php
/**
 * @copyright	@copyright	Copyright (c) 2014 OPENSOURCE TECHNOLOGIES. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *      Author:     Akash Nand
 *      Email:      akash@opensourcetechnologies.com
 *      Version:    1.0
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';


$class_sfx = htmlspecialchars($params->get('class_sfx'));
$company_id	= $params->get('company_id', '');

require(JModuleHelper::getLayoutPath('mod_linkedinfeed', $params->get('layout', 'default')));