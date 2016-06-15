<?php
/**
* @package		Joomla
* @date			10.03.14
* @copyright	Copyright (C) 2009 - 2014 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modLatestNewsWithIntroHelper
{
	public static function getList(&$params)
	{
		$mainframe =& JFactory::getApplication();

		$db			= JFactory::getDBO();
		$user		= JFactory::getUser();
		$userId		= (int) $user->get('id');
		$intro_limit_base=(int) $params->get('intro_count',0);
		$ilt		= (int) $params->get('intro_text_limit_type',2);
		$intro_img	= (int) $params->get('intro_text_img',0);
		$count		= (int) $params->get('count', 5);
		$catid		= trim( $params->get('catid') );
		$category   = $params->get('category',0);
		$intro_text = $params->get('intro_text',0);
		$show_front	= $params->get('show_front', 1);
		//$aid		= $user->get('aid', 0);
		$groups	= implode(',', $user->getAuthorisedViewLevels());
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$contentConfig = JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date = JFactory::getDate();
		$now = $date->toSQL();

		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;

		// User Filter
		switch ($params->get( 'user_id' ))
		{
			case 'by_me':
				$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
				break;
		}

		// Ordering
		switch ($params->get( 'ordering' ))
		{
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'c_dsc':
			default:
				$ordering		= 'a.created DESC';
				break;
		}

		if ($catid)
		{
			$ids = explode( ',', $catid );
			JArrayHelper::toInteger( $ids );
			$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
		}
		

		if ($intro_text)
		{
 			$introCondition= '';

		}
		// Content Items only
		$query = 'SELECT a.title as at, introtext as it, a.access, cc.title as ct , ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a ' .
			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' WHERE '. $where .
			($access ? ' AND a.access IN ('.$groups.') AND cc.access IN ('.$groups.') ' : '').
			($catid ? $catCondition : '').
			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
			' AND cc.published = 1' .
			' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i		= 0;
		$lists	= array();
		foreach ( $rows as $row )
		{
			$intro_limit=$intro_limit_base;
			if($access || in_array($item->access, $authorised))
			{
				$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
			} else {
				$lists[$i]->link = JRoute::_('index.php?option=com_users&view=login');
			}
			$lists[$i]->text1 = htmlspecialchars( $row->at );
		    $lists[$i]->text2 =	htmlspecialchars( $row->ct );
		    $intotx = $row->it;
		    
		   //Filter Image
			if($intro_img==0)
			{		
				$intotx=preg_replace('/<img [^>]*>/i','',$intotx);
					
			}	
			// Limit IntroText
			if($ilt!=0 && $intro_limit!=0 && strlen($intotx) > $intro_limit)
			{
				preg_match_all('/<img [^>]*>/i', $intotx, $matches);
				$matches=array_filter($matches);
				if($ilt==1)
					{ 
						//Limit the Characters
						if($intro_img!=0 && !empty($matches))
						{
								$intotx=preg_replace('/<img [^>]*>/i',' |IMG| ',$intotx);								
								$matches=array_filter($matches);
								$intro_limit+=sizeof($matches)*6;								
								$intotx=JHTML::_('string.truncate', $intotx, $intro_limit,false,false);
								$exarry=explode('|IMG|',$intotx);
								foreach($matches[0] as $k=>$match)
								{
									$exarry[$k]=$exarry[$k].(empty($exarry[$k])?'':'<br/>').$match.'<br/>';
								}
								$intotx=implode('',$exarry);
						}

						else
						{
							$intotx=JHTML::_('string.truncate', $intotx, $intro_limit,false,false); 
						}			
							$lists[$i]->text3=$intotx;							
					}
					else 
					{ 
					
						if($intro_img!=0 && !empty($matches))
						{
								$intotx=preg_replace('/<img [^>]*>/i',' |IMG| ',$intotx);
								$matches=array_filter($matches);
								$intro_limit+=sizeof($matches);						
								$intotx=strip_tags($intotx);
								$words = preg_split("/[\n\r\t ]+/", $intotx, $intro_limit+1, PREG_SPLIT_NO_EMPTY);
								if ( count($words) > $intro_limit ) 
								{
									array_pop($words);
									$text = implode(' ', $words);
									$text = $text . '...';
								}
								$exarry=explode('|IMG|',$text);
								foreach($matches[0] as $k=>$match)
								{
									$exarry[$k]=$exarry[$k].(empty($exarry[$k])?'':'<br/>').$match.'<br/>';
								}
								$intotx=implode('',$exarry);
						}
						else
						{
								$intotx=strip_tags($intotx);
								$words = preg_split("/[\n\r\t ]+/", $intotx, $intro_limit+1, PREG_SPLIT_NO_EMPTY);
								if ( count($words) > $intro_limit ) 
								{
										array_pop($words);
										$text = implode(' ', $words);
										$intotx = $text . '...';
								}				
					
						}
				
						$lists[$i]->text3=$intotx;
					 }				
				}
				else
				{
					$lists[$i]->text3 = $intotx;
				}				
			$i++;
		}

		return $lists;
	}
}
