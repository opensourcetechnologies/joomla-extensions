<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Mondi Form Field class for the Mondi component
 */
class JFormFieldComboslider extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Comboslider';
	

 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__categories');
		$db->setQuery((string)$query);
		$db->getQuery((string)$query);
		$products = $db->loadObjectList();
		$options = array();
		if ($products)
		{
			foreach($products as $product) 
			{
				$options[] = JHtml::_('select.option', $product->id, $product->product_name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}


