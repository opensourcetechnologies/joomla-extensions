<?php
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

$document = JFactory::getDocument();

$document->addStyleSheet(JURI::base()."modules/mod_articles_latest_extended/css/newsfeed.css");

abstract class modArticlesLatestExtendedHelper
{
	public static function getList(&$params)
	{
		// Get the dbo
		$db = JFactory::getDbo();
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('count', 5));
		$model->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));

		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;

			case '0':
				break;

			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}

		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());

		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}

		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = 'DESC';

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);

		$items = $model->getItems();

		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;

			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
		}
//Get Category Parent Category
        
		return $items;
	}
public static function getParents(&$params)
{
    if($params->get("category")==2)
    {
    $categoriesModel = JCategories::getInstance('content');
    $selected_cat=$params->get('catid', array());
    if(count($selected_cat)==1 && $selected_cat[0]==null)
    {
    $selected_cat=null;
    $db=JFactory::getDbo();
    $query	= $db->getQuery(true);    
    $query->select('id');
    $query->from('#__categories');
    $query->where('id!=1 and title!="ROOT" && published=1 && extension="com_content"' );
    $db->setQuery($query);
    $result=$db->loadObjectList();
    foreach($result as $row)
    {
        $selected_cat[]=$row->id;
    }
    
    }
    //echo "<pre/>";print_r($selected_cat);die;
    foreach($selected_cat as $key=>$cat)
    {
       $category = $categoriesModel->get($cat); 
       $count=0;
       while($parent=$category->getParent())
       {
        if($parent->id!=="root" && $parent->title!=="ROOT")
        {
        $parents[$cat][$count]["id"]=$parent->id;
        $parents[$cat][$count]["title"]=$parent->title;
        $category = $categoriesModel->get($parent->id);
        $count++;
        }
        else
        {
        $category = $categoriesModel->get($parent->id);
        }
       }
    }
    }
     //echo "<pre/>";print_r($parents);die;
    return isset($parents)?$parents:null;
        
}
}
