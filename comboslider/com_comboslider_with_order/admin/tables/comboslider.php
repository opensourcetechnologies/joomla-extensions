<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Hello Table class
 */
 
class CombosliderTableComboslider extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 	var $id = null;

	/**
	 * @var string
	 */
	var $greeting = null;
	var $article = null;
	var $category = null;
	var $edcontent = null;
	var $type = null;
	var $layout = null;
	var $ordering=null;
	var $rantime=null;
	function __construct(&$db) 
	{
		parent::__construct('#__comboslider', 'id', $db);
	}
	
}
