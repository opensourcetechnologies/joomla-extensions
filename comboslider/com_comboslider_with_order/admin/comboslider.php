<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
 
// Set some global property
$document = JFactory::getDocument();
//$document->addStyleDeclaration('.icon-48-mondi {background-image: url(../media/com_mondi/images/tux-48x48.png);}');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by Mondi
$controller = JControllerLegacy::getInstance('Comboslider');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
