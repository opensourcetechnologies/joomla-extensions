<?php
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modfeaturedNewsHelper
{
 public static function getList(&$params)
	{
		$mainframe = JFactory::getApplication();

		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$userId		= (int) $user->get('id');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$contentConfig = JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');
		
		$count		= (int) $params->get('count', 5);		
		$modParams = $params->toArray();
		$idx = 0;
		while (true)
		{
			++$idx;
			if (!array_key_exists('article_' . $idx, $modParams))
				break;
		
			$articleId 		= @intval($params->get('article_' . $idx, 0), 10);
			if ($articleId < 1 )
				continue;	
				
			$articleIdList[] = $articleId;
		}
		

		$contentConfig = JComponentHelper::getParams( 'com_content' );
	
		
	
	 $lists	= array();
	 $i		= 0;
	 if(isset($articleIdList)){
		 $articlesLists = count($articleIdList);
		 }
		 else{
			 $articlesLists = 0;
			 }
	 
	 if($count < $articlesLists)
		for($k=0;$i<$count;$k++)	
		{
			// Content Items only
			$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
			' WHERE 1=1 AND a.id ='.$articleIdList[$k].' ';
		
		$db->setQuery($query);
		
		$rows = $db->loadObjectList();
		$lists[$i] = new ArrayObject();
		if($access || in_array($rows[0]->access, $authorised))
			{
				$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($rows[0]->slug, $rows[0]->catslug));
			}
			else 
			{
				$lists[$i]->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$lists[$i]->text = htmlspecialchars( $rows[0]->title );
			$i++;
		}
	 else
		for($k=0;$i < $articlesLists;$k++)	
		{
			// Content Items only
			$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
			' WHERE 1=1 AND a.id ='.$articleIdList[$k].' ';
		
		$db->setQuery($query);
		
		$rows = $db->loadObjectList();
		$lists[$i] = new ArrayObject();
		if($access || in_array($rows[0]->access, $authorised))
			{
				$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($rows[0]->slug, $rows[0]->catslug));
			}
			else 
			{
				$lists[$i]->link = JRoute::_('index.php?option=com_user&view=login');
			}
			$lists[$i]->text = htmlspecialchars( $rows[0]->title );
			$i++;
	 }

		return $lists;
	}
}
