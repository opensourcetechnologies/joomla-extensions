<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Mondi View
 */
class CombosliderViewCombosliders extends JViewLegacy
{
	/**
	 * Mondi view display method
	 * @return void
	 */
	 
	public function display($tpl = null) 
	{

		// Get data from the model
		
		JToolBarHelper::title(   JText::_( 'Combo Slider Manager' ), 'generic.png' );
	//	JToolBarHelper::deleteList();
	//	JToolBarHelper::editListX();
	//	JToolBarHelper::addNewX();
		
		

		// Get data from the model
		//$items		= & $this->get( 'Data');
		
	//	$total		= &$this->get('total');	
	///	$pageNav 	= & $this->get( 'Pagination' );		
		
	   
	//	$this->assignRef('items',		$items);
		
		//$this->assignRef('pageNav' , $pageNav);
	//	$this->assign('total',			$total);

		//parent::display($tpl);
		
		
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->state		= $this->get('State');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pageNav = $pagination;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
		
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{

		JToolBarHelper::title(JText::_('COM_COMBOSLIDER_MANAGER_COMBOSLIDERS'), 'comboslider');
		JToolBarHelper::deleteList('', 'combosliders.delete');
		JToolBarHelper::editList('comboslider.edit');
		JToolBarHelper::addNew('comboslider.add');
														   
														   
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_COMBOSLIDER_ADMINISTRATION'));
	}

}


