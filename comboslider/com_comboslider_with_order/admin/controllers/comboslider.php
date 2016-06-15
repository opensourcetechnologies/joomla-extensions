<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * Mondi Controller
 */

class CombosliderControllerComboslider extends JControllerForm
{
function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 'edit');
	}
	
	/**
	 * display the edit form
	 * @return void
	 */
	function edit($key = NULL, $urlVar = NULL)
	{
		JRequest::setVar( 'view', 'comboslider' );
		JRequest::setVar( 'layout', 'edit'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}
	public function getTable($type = 'Comboslider', $prefix = 'CombosliderTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save($key = NULL, $urlVar = NULL)
	{
		$model = $this->getModel('comboslider');
	     
		if ($model->store($post)) {
			$msg = JText::_( ' Saved!' );
		} else {
			$msg = JText::_( 'Error Saving ' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_comboslider';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('comboslider');
		if(!$model->delete()) {
			$msg = JText::_( 'Error:   Could not be Deleted' );
		} else {
			$msg = JText::_( ' Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_comboslider', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel($key = NULL)
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_comboslider', $msg );
	}
	
	function saveorder()
	{
	$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    JArrayHelper::toInteger($cid, array(0));
	
	 $this->saveOrder_1( $cid, 'com_comboslider' );
	}
	
	function orderdown()
	{
	$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    JArrayHelper::toInteger($cid, array(0));
	$this->orderSlide( $cid[0], 1, 'com_comboslider' );
	}
	function orderup()
	{
	$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    JArrayHelper::toInteger($cid, array(0));
	$this->orderSlide( $cid[0], -1, 'com_comboslider' );
	}
	
	function publish()
	{
	
	 $cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
     //JArrayHelper::toInteger($cid, array(0));
	 global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db		=& JFactory::getDBO();
	$user	=& JFactory::getUser();
	$uid	= $user->get('id');

	JArrayHelper::toInteger($cid);
	

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		JError::raiseError(500, JText::_( 'Error '.$action, true ) );
	}

	$cids = implode( ',', $cid );

	 $query = 'UPDATE #__comboslider'
	. ' SET published ="1"' 
	. ' WHERE id IN ( '.$cids.' )'
	
	;

	$db->setQuery( $query );
	if (!$db->query()) {
		JError::raiseError(500, $db->getErrorMsg() );
	}

	/*if (count( $cid ) == 1) {
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_comboslider'.DS.'tables');
	$row = & JTable::getInstance('comboslider', 'Table');
		//$row =& JTable::getInstance('slider');
		//$row->checkin( $cid[0] );
	}*/
$this->setRedirect('index.php?option=com_comboslider');
	//$mainframe->redirect( 'index.php?option=com_comboslider' );
	 
	}
	
function unpublish()
	{
	 $cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
     //JArrayHelper::toInteger($cid, array(0));
	 global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db		=& JFactory::getDBO();
	$user	=& JFactory::getUser();
	$uid	= $user->get('id');

	JArrayHelper::toInteger($cid);
	

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		JError::raiseError(500, JText::_( 'Error '.$action, true ) );
	}

	$cids = implode( ',', $cid );

	 $query = 'UPDATE #__comboslider'
	. ' SET published ="0"' 
	. ' WHERE id IN ( '.$cids.' )'
	
	;

	$db->setQuery( $query );
	if (!$db->query()) {
		JError::raiseError(500, $db->getErrorMsg() );
	}

	/*if (count( $cid ) == 1) {
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_comboslider'.DS.'tables');
	$row = & JTable::getInstance('comboslider', 'Table');*/
		//$row =& JTable::getInstance('slider');
		//$row->checkin( $cid[0] );
	//}

$this->setRedirect('index.php?option=com_comboslider');
	 
	}
	
	
	function orderSlide( $uid, $inc, $option ) {
	global $mainframe, $option;
	
	$ss= JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_comboslider'.DS.'tables');
	

	// Check for request forgeries
	JRequest::checkToken() or die( 'Invalid Token' );

	// Initialize variables
	$db		= & JFactory::getDBO();

	//$row =  JTable::getInstance('comboslider');
	
	$row =& $this->getTable();
	
	
	
	$row->load( (int) $uid );
	$row->move( $inc );

	$cache = & JFactory::getCache($option);
	$cache->clean();

$this->setRedirect('index.php?option=com_comboslider&task=comboslider');
	//$mainframe->redirect('index.php?option='.$option.'&task=comboslider');

}
function saveOrder_1( &$cid, $option ) 
{

	global $mainframe, $option;

	// Check for request forgeries
	JRequest::checkToken() or die( 'Invalid Token' );

	// Initialize variables
	$db			= & JFactory::getDBO();
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_comboslider'.DS.'tables');

	$cid		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$order		= JRequest::getVar( 'order', array (0), 'post', 'array' );
	$total		= count($cid);
	$conditions	= array ();

	JArrayHelper::toInteger($cid, array(0));
	JArrayHelper::toInteger($order, array(0));

	// Instantiate an slide table object
	$row = & JTable::getInstance('comboslider', 'Table');

	// Update the ordering for items in the cid array
	for ($i = 0; $i < $total; $i ++)
	{
		$row->load( (int) $cid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				JError::raiseError( 500, $db->getErrorMsg() );
				return false;
			}
			// remember to updateOrder this group
			$condition = '';
			$found = false;
			foreach ($conditions as $cond)
			if ($cond[1] == $condition) {
				$found = true;
				break;
			}
			if (!$found)
			$conditions[] = array ($row->id, $condition);
		}
	}

	// execute updateOrder for each group
	foreach ($conditions as $cond)
	{
		$row->load($cond[0]);
		$row->reorder($cond[1]);
	}

	$cache = & JFactory::getCache($option);
	$cache->clean();

	$msg = JText::_('FPSS_IMAGES_FULLREORDERING_DONE');
	$this->setRedirect('index.php?option='.$option.'&task=comboslider', $msg);
	/*index.php?option='.$option.'&task=comboslider
	$mainframe->redirect('index.php?option='.$option.'&task=comboslider', $msg);*/

}
	

}
