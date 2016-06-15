<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla formrule library
jimport('joomla.form.formrule');
 
 /**
 * Form Rule class for the Joomla Framework.
 */
class JFormRuleProduct extends JFormRule
{
	/**
	 * The regular expression.
	 *
	 * @access	protected
	 * @var		string
	 * @since	1.7
	 */
	//protected $regex = '^[^0-9]+$';
	protected $regex = '';
}
