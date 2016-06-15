<?php
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modRandomQuotesHelper
{
	public static function renderItem(&$item, &$params)
	{
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');

		$results = $mainframe->triggerEvent('onAfterDisplayTitle', array (&$item, &$params, 1));
		//$item->afterDisplayTitle = trim(implode("\n", $results));

		$results = $mainframe->triggerEvent('onBeforeDisplayContent', array (&$item, &$params, 1));
		//$item->beforeDisplayContent = trim(implode("\n", $results));

		require(JModuleHelper::getLayoutPath('mod_randomquotes', '_item'));
	}

	public static function getList(&$params, &$access)
	{
	$randomquotesPath = "modules/mod_randomquotes/quotes/";
	// Name of the randomquotes text file
	$randomquotesFile = "randomquotes.txt";

	$GLOBAL["randomquotesPath"] = $randomquotesPath;
	$lineSep = "\n";
	$quoteFile = fopen( implode("/", array ( $randomquotesPath , $randomquotesFile)) , "r") or DIE("Unable to find $randomquotesFile in $randomquotesPath") ;
	while (!feof($quoteFile)) {
	  $tquote = trim(fgets($quoteFile, 1024)); 
	  if (strlen($tquote) > 0) {
			$quotes[] = $tquote;
			}
		}
		return $quotes;
	}
	
}
