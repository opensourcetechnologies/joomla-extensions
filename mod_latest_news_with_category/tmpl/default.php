<?php
/**
* @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die;
?>
<?php
$intro_enable=$params->get("intro",0);
?>
<div class="extended<?php echo $moduleclass_sfx; ?>">
<ul class="latestnews">
<?php foreach ($list as $item) :  ?>
	<li>
		<h1><a href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?></a></h1>
            <?php
            if($params->get("category",0))
            {
            ?>
            <div class="data"><i class="ost_category">
            <?php
            echo JText::_('MOD_LATEST_NEWS_WITH_CATEGORY_CATEGORY').":</i>";
            if(isset($parents))
            {
                if(isset($parents[$item->catid]))
                {
                foreach(array_reverse($parents[$item->catid]) as $key=>$parent)
                {
                    if($params->get("linkcat",0))
                    {
                ?>
                <span><a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_content&view=category&id={$parent['id']}"); ?>"><?php echo $parent["title"];  ?></a>&gt;&gt;</span>
                <?php    
                    }
                    elseif(!$params->get("linkcat",0))
                    {
                ?>
                <span><?php echo $parent["title"];  ?>&gt;&gt;</span>
                <?php    
                    }
                    ?>
                <?php 
                }
                }
                if($params->get("linkcat",0))
                    {
                    $app = JFactory::getApplication();
                    $menu = $app->getMenu()->getActive()->id;
                    if(isset($menu))
                    {
                        $itemid="&Itemid=$menu";
                    }
                    else
                    {
                        $itemid="";
                    }  
                ?>
                <span><a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_content&view=category&id={$item->catid}{$itemid}"); ?>"><?php echo $item->category_title;  ?></a></span>
                <?php    
                    }
                    elseif(!$params->get("linkcat",0))
                    {
                ?>
                <span><?php echo $item->category_title; ?></span>
                <?php    
                    }
                
            }
            else
            {
                 
                if($params->get("linkcat",0))
                    {
                    $app = JFactory::getApplication();
                    $menu = $app->getMenu()->getActive()->id;
                    if(isset($menu))
                    {
                        $itemid="&Itemid=$menu";
                    }
                    else
                    {
                        $itemid="";
                    }                                               
                ?>
                <span><a href="<?php echo JRoute::_(JURI::base()."index.php?option=com_content&view=category&id={$item->catid}{$itemid}"); ?>"><?php echo $item->category_title;  ?></a></span>
                <?php    
                    }
                    elseif(!$params->get("linkcat",0))
                    {
                ?>
                </span><?php echo $item->category_title; ?></span>
                <?php    
                    }
                
            }
            echo "</div>";
            }
            ?>
            
            <?php
            if($intro_enable)
            {
             echo "<div class=\"readmore\">".substr(strip_tags($item->introtext),0,$params->get("words",20))."...";
             if($params->get("readmore",0)){
             echo "<span><a href=\"$item->link\">".JText::_('MOD_LATEST_NEWS_WITH_CATEGORY_READ_MORE')."</a></span>"; 
             } 
             echo "</div>"; 
            }
            ?>
	</li>
<?php endforeach; ?>
</ul>
</div>
