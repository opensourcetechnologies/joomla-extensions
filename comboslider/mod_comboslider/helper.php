<?php
/**
 * Joomla! 2.5 and 3.x module mod_slider
 * @author Ost
 * @package Joomla
 * @subpackage Slider
 * Module helper
 * @license GNU/GPL

 */
// no direct access
defined('_JEXEC') or die('Restricted access');   

class modCombosliderHelper
{

   public static function getHello( $params )
    {
        $mainframe = JFactory::getApplication();

		$db			= JFactory::getDBO();
		
	   $onlineUser= modCombosliderHelper::OnlineUser();  // return number of user which are online
		if($onlineUser)
		 {
		  $username=" Welcome ".$onlineUser."...";
		 }
		 $sliderLimit		= (int) $params->get('slider_limit', 10);
		 $sliderWidth1		= ((int) $params->get('width', 615)-246);
         $sliderHeight1		= (int) $params->get('height', 330);
		 $articleTitleLimit=(int) $params->get('slider_articletitle_limit', 25);
		 $margin_top=(($sliderHeight1)-70)."px;";
		 $readMore=$params->get('slider_read', "YES");
		 $sliderStrip=$params->get('slider_strip', "YES");
		 
		 $sliderStrip_backgroundColor=$params->get('slider_stripbackground_color',"FFF");
		 $sliderStriptextColor=$params->get('slider_striptext_color',"0063AD");
		 
		 
		 $sliderArticleBackgroundColor=$params->get('slider_articlebackground_color',"fff");
		  if($sliderArticleBackgroundColor)
		   {
		    $articleBackgroundColor="background-color:#".$sliderArticleBackgroundColor.";";
		   }
		   
		   /* if($sliderArticletextColor)
		  {
		   $articletextColor="color:#".$sliderArticletextColor.";";
		  }
		 */
		  if($sliderStrip_backgroundColor)
		  {
		     $backgroundColor="background-color:#".$sliderStrip_backgroundColor.";";
		  }
	      if($sliderStriptextColor)
		  {
		   $textColor="color:#".$sliderStriptextColor.";";
		  }
		
		
		$query="select * from #__comboslider where published='1' order by ordering asc ";
		$db->setQuery($query, 0, $sliderLimit);
		$rows = $db->loadObjectList();
        $i		= 0;
		$lists	= array();
		foreach ( $rows as $row )
		{
		 
		 if($row->type=="static")  // for static image or text
			{
			  
			 $lists[$i]->content='<div  clas="0">'.stripslashes($row->edcontent).'</div>';
			}else if($row->type=="article")  // for select perticular article
			{
			 $query_article="select * from #__content where id=".$row->article." AND state ='1' "; 
			 $db->setQuery($query_article);
		     $res_article = $db->loadObject();
			 $image_cat=modCombosliderHelper::str_img_src_new_Image($res_article->introtext);
			 $content_text = preg_replace("/<img[^>]+\>/i", " ", $res_article->introtext); 
			 
			 $linkUrl=JURI::base()."index.php?option=com_content&view=article&id=".$res_article->id."&catid=".$res_article->catid."&Itemid=115";
			 $lists[$i]->content='';
			 
			 $lists[$i]->content .='<div  clas="1">';
			 if(count($res_article)>0)
				  {
				   if($sliderStrip=="YES")
				    {
						$lists[$i]->content .=' <div style="margin-top:'.$margin_top. '   opacity: 0.7;width:612px; height:30px; position:absolute; z-index:9999; font-family:Arial, Helvetica, sans-serif;font-size:14px; font-weight:bold; '.$textColor.' padding-top:15px; padding-left:10px;'.$backgroundColor.' ">'.date("M d,Y",strtotime($res_article->created)).' | '.modCombosliderHelper::countOnlineuser().$username.'</div>';
			       }
			   }
			 if($image_cat)  // check image exit
				  {
                $lists[$i]->content .=' <img src="'.$image_cat.'" alt="Eddie" class="eddie" width="'.$sliderWidth1.'" height="'.$sliderHeight1.'" />';
				$width="width:220px;";
				$height="height:200px;";
				$content_limit="200";
				$min_height="min-height:310px;";
				  }
				  else
				   {
				   $width="width:580px;";
				   $height="height:310px;";
				   $content_limit="500";
				   $min_height="min-height:310px;";
				   }
                 $lists[$i]->content .='<div class="amit" style="  float:right;'.$width. $min_height.' margin-top:15px; '.$height.' margin-right:13px; '.$articleBackgroundColor.' ">
                <h2>'.modCombosliderHelper::getStringWithLimitChar($res_article->title,$articleTitleLimit).'</h2><p>'.modCombosliderHelper::getStringWithLimitChar($content_text,$content_limit).'</p>';
				 if(count($res_article)>0)
				  {
				  if($readMore=="YES") // for read more link
				   {
					$lists[$i]->content .='<p><a href="'.$linkUrl.'">Read More &#8250;</a></p>';
				   }
				 }
				$lists[$i]->content .=' </div></div>';
			}//print_r($lists[$i]);die;
			else if($row->type=="category")  // when you select category
			{
			  if($row->layout=="Rand")  // if you select random
			  {
			  $Where='';
			  // this function is used for automatically check time for a perticular article
			  $art=modCombosliderHelper::checkarticleWithTime($row->category,$row->id,$row->rantime); 
			//  echo $art;
			  if((int)$art>0)
			  {
			     $Where=" AND jc.id='".(int)$art."'";
				
			  }
			  
	   $query_category="select jc.title,introtext as intro,created,catid,jc.id 	 from #__content jc INNER JOIN #__categories jcat ON jc.catid=jcat.id  where jcat.id=".$row->category." AND state ='1' ".$Where." order by rand()  limit 0,1"; 
		$db->setQuery($query_category);
		 $db->getQuery($query_category);
		$res_category = $db->loadObject();
		if($art=="No")
			  {
			   modCombosliderHelper::InsertSliderArticle($res_category->id,$row->category,$row->id);
			  }
			 }
			 else if($row->layout=="Most Viewed") 
			  {
			   $query_category="select jc.title,introtext as intro,created,catid,jc.id 	 from #__content jc INNER JOIN #__categories jcat ON jc.catid=jcat.id  where jcat.id=".$row->category." AND state ='1'  order by jc.hits desc limit 0,1"; 
				$db->setQuery($query_category);
				$db->getQuery($query_category);
				$res_category = $db->loadObject();
			  }
			  else
			   { // latest
			    $query_category="select jc.title,introtext as intro,created,catid,jc.id 	 from #__content jc INNER JOIN #__categories jcat ON jc.catid=jcat.id  where jcat.id=".$row->category." AND state ='1'  order by jc.id desc limit 0,1"; 
				$db->setQuery($query_category);
			   $db->getQuery($query_category);
		       $res_category = $db->loadObject();
			   }
			   
			   
			   
		
			 
			 $image_cat=modCombosliderHelper::str_img_src_new_Image($res_category->intro);
			 $content_text = preg_replace("/<img[^>]+\>/i", " ", $res_category->intro); 
			 $linkUrl=JURI::base()."index.php?option=com_content&view=article&id=".$res_category->id."&catid=".$res_category->catid."&Itemid=115";
			//die;
			$lists[$i]->content='';
			 
			 $lists[$i]->content .='<div clas="2">';
			 if(count($res_category)>0)
				  {
				  if($sliderStrip=="YES")
				    {
						$lists[$i]->content .=' <div style="margin-top:'.$margin_top.' opacity: 0.7;width:612px; height:30px; position:absolute; z-index:9999; font-family:Arial, Helvetica, sans-serif;font-size:14px; font-weight:bold; '.$textColor.' padding-top:15px; padding-left:10px; '.$backgroundColor.' ">'.date("M d,Y",strtotime($res_category->created)).' | '.modCombosliderHelper::countOnlineuser().$username.'</div>';
			         }
			  }
			     if($image_cat) // if image exits.
				  {
                $lists[$i]->content .='<img src="'.$image_cat.'" alt="Eddie" class="eddie " width="'.$sliderWidth1.'" height="'.$sliderHeight1.'" />';
				$width="width:220px;";
				$height="height:200px;";
				$content_limit="200";
				$min_height="min-height:310px;";
				  }
				   else
				   {
				   $width="width:580px;";
				   $height="height:310px;";
				   $content_limit="500";
				   $min_height="min-height:310px;";
				   }
                $lists[$i]->content .='<div style="float:right; '.$width. $min_height.' margin-top:15px; '.$height.' margin-right:13px; '.$articleBackgroundColor.' ">
                <h2>'.modCombosliderHelper::getStringWithLimitChar($res_category->title,$articleTitleLimit).'</h2><p>'.modCombosliderHelper::getStringWithLimitChar($content_text,$content_limit).'</p>';
				 if(count($res_category)>0)
				  {
				  if($readMore=="YES")  // for read more link
				   {
					 $lists[$i]->content .='<p><a href="'.$linkUrl.'">Read More &#8250;</a></p>';
				   }
				 }
				
				$lists[$i]->content .=' </div></div>';
			}	
				
			$i++;
		}
		
		
		return $lists;
    }
	
	
	public static function getStringWithLimitChar($String,$limit)
	{
     $result = substr(substr($String, 0, $limit), 0, strrpos(substr($String, 0, $limit), ' '));
	 return $result;
	}
	
 public static function str_img_src_new_Image($html) {
        if (stripos($html, '<img') !== false) {
            $imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
            preg_match($imgsrc_regex, $html, $matches);
            unset($imgsrc_regex);
            unset($html);
            if (is_array($matches) && !empty($matches)) {
                return $matches[2];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	
 public static function OnlineUser()
	{

		        $mainframe = JFactory::getApplication();

		$db	= JFactory::getDBO();
		
		 $user="select username from #__session where username !='' limit 0,3";
		$db->setQuery($user);
		$res_user = $db->loadObjectList();
		//$userRecord=array();
		foreach($res_user as $user_res)
		{
		    if($user_res->username)
			 {
			   $userRecord[]=$user_res->username;
			 }
		}
		
		return @implode(", ",$userRecord);
		
	 
	}
	
 public static function countOnlineuser()
	{
 $mainframe = JFactory::getApplication();

		$db	= JFactory::getDBO();
		
		 $userCount="select count(username) as cuser from #__session where username !='' limit 0,3";
		 $db->setQuery($userCount);
		 $res_count = $db->loadObject();
		 return $res_count->cuser." Tracking |";
	}
	/*function myTruncate($string, $limit, $break=".", $pad="...") { 
	// return with no change if string is shorter than $limit 
	if(strlen($string) <= $limit) return $string; // is $break present between $limit and the end of the string?
	 if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } } return $string; }*/
	 
 public static function checkarticleWithTime($categoryId,$sliderId,$time)
	 {
 $mainframe = JFactory::getApplication();

		$db	= JFactory::getDBO();
	  $articleTime="SELECT * FROM #__comboslider_article jsa  Where jsa.slider_id='".$sliderId."' AND category_id='".$categoryId."'";
	 $db->setQuery($articleTime);
	 $res_article = $db->loadObject();
	 if(count($res_article))
	  {
	  
	 
	  $currentTime=strtotime(date('Y-m-d H:i:s'));
	//  echo "<br>";
	   $articleTime=strtotime($res_article->time);
	//  echo "<br>";
	  $asTime=($time*3600);
	  
	   $time_diff=($currentTime-$articleTime);
	   if($time_diff>=$asTime)
	   {
	     $delete="DELETE FROM #__comboslider_article WHERE id='".$res_article->id."' ";
		  $db->setQuery($delete);
		  $db->query();
		   return "Yes";
	   }
	   else
	    {
		  return $res_article->article_id;
		}
	  

	  
	   
	  }
	  else
	   {
	     return "No";
	   }
		
	  
	 }
	 
 public static function InsertSliderArticle($articleId,$categoryId,$sliderId)
	  {
 $mainframe = JFactory::getApplication();

		$db	= JFactory::getDBO();
		$Insert="INSERT INTO #__comboslider_article SET slider_id='".$sliderId."', category_id='".$categoryId."',article_id='".$articleId."',time=now()";
		 $db->setQuery($Insert);
		  $db->query();
	  }
}
?>
