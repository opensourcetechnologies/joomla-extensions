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
 * HelloWorld View
 */
class CombosliderViewComboslider extends JViewLegacy
{
	/**
	 * display method of Mondi
	 * @return void
	 */
	 
	public function display($tpl = null) 
	{
	
		
		$form = $this->get('Form');
		$item = $this->get('Data');
		$script = $this->get('Script');
		$article=$this->getArticle();
		$category=$this->getCategory();
		$this->assignRef('article',		$article);
		$this->assignRef('category',		$category);
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
		$this->script = $script;
 
		// Set the toolbar
		$this->addToolBar();
		$this->assignRef('hello',$item);
 
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
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_COMBOSLIDER_MANAGER_COMBOSLIDER_NEW') : JText::_('COM_COMBOSLIDER_MANAGER_COMBOSLIDER_EDIT'), 'comboslider');
		JToolBarHelper::save('comboslider.save');
		JToolBarHelper::cancel('comboslider.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_COMBOSLIDER_COMBOSLIDER_CREATING') : JText::_('COM_COMBOSLIDER_COMBOSLIDER_EDITING'));
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_comboslider/views/comboslider/submitbutton.js");
		JText::script('COM_COMBOSLIDER_COMBOSLIDER_ERROR_UNACCEPTABLE');
	}
	
	
	function getCategory()
	{
	 $mainframe = JFactory::getApplication();
	 $db		 = JFactory::getDBO();
	
	 
	 $sqlCategory="select * from #__categories where 	extension='com_content' AND published='1'";
	$db->setQuery($sqlCategory);
	
	
	//$queryCategory1   = $db->getQuery($sqlCategory);
	
	$category  = $db->loadObjectList();
	
	
	return $category ;
			
	}
	
	function getArticle()
	{
	$db		 =  JFactory::getDBO();
	$sqlArticle="select * from #__content where state='1'";
	$db->setQuery($sqlArticle);
	$article  = $db->loadObjectList();
	return $article ;
			
	}
}
