<?php
/**
* @copyright	Copyright (C) 2013 Open Source Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die;

$height = $params->get('height');
$width = $params->get('width');
$multyurls = trim($params->get('multyurls'));
if(!empty($multyurls)){
$urlarray = explode(",",$multyurls);
$urlno = count($urlarray);
$rand=array_rand($urlarray);
$exacturl=$urlarray[$rand];
	if(!empty($exacturl)){
	  $youtubeValue = explode('?v=',$exacturl);
	    }else{
	  $youtubeValue = explode('?v=',$urlarray[0]);	
		}
		
if($youtubeValue[1]){
$ID = $youtubeValue[1];
?>
<iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="https://www.youtube.com/embed/<?php echo $ID; ?>" frameborder="0" allowfullscreen></iframe>
<?php 
			}else{
			echo "There is no youtube link";
	}
 
}else{
	    echo "There is no youtube link";
	}	
?>
