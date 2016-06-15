<?php
/**
* @copyright	Copyright (C) 2012 OpenSource Technologies Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
include_once (JPATH_BASE.DS.'modules'.DS.'mod_sobi2twitter'.DS.'api'.DS.'TwitterAPIExchange.php');
global $mainframe;
$document =JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_sobi2twitter/';

$css	= $params->get( 'css', '1' );
$moduleID	= $params->get( 'moduleID', '1' );
$type	= $params->get( 'type', 'query' );
$twitterBird	= $params->get( 'twitterBird', 'bird1' );
$joinText	= $params->get( 'joinText', 'auto' );
$tweetSource		= $params->get('tweetSource','yes');
$twitterName = $params->get('twitterName','yes');
$noReplies = $params->get('noReplies','no');
$tweetTemplate = $params->get('tweetTemplate','1');
$fieldname = $params->get( 'fieldname' );
$userName = '';
$user = JFactory::getUser();
$userid = $user->id;

if((isset($_REQUEST['option']) && $_REQUEST['option']  == 'com_sobipro') && isset($userid)!='')
{
			
		$sobi2Id =(int) $_REQUEST['sid'];
	    
	
	    $db = JFactory::getDbo();
 

		$query = $db->getQuery(true);
		 

		$query->select($db->quoteName(array('fid')));
		$query->from($db->quoteName('#__sobipro_field'));
		$query->where($db->quoteName('nid') . ' = '. $db->quote($fieldname));
		
		$db->setQuery($query);
		 
		$id = $db->loadObjectList();
	
	    if(!empty($id)){
		  
		foreach($id as $idkey=>$idval){
			$fieldid[]= $idval->fid;
			}
		}
	
	 //  print_r($fieldid);die;	
	    
	    
	     
		if(count($id)){
	    foreach($fieldid as $fldkey=>$fldval){
			
	    $getQuery = $db->getQuery(true);
		$getQuery->select($db->quoteName(array('baseData')));
		$getQuery->from($db->quoteName('#__sobipro_field_data'));
		$getQuery->where($db->quoteName('fid') . ' = '. $db->quote($fldval));
		$getQuery->where($db->quoteName('sid') . ' = '. $db->quote($sobi2Id));
		$db->setQuery($getQuery);
		$baseData = $db->loadObject();		
		if(!empty($baseData)){
		$userName = $baseData->baseData;	
			}
		 }
     }
}
 
if($userName=='')
{
   $userName= $params->get( 'userName');
}

$userName = str_replace(" ","",$userName);




$avatar	= $params->get( 'avatar', 'no' );
$avatarSize	= $params->get( 'avatarSize', '48' );
$count	= $params->get( 'count', 5 );
$autoDefault	= $params->get( 'autoDefault', 1 );
$autoEd	= $params->get( 'autoEd', 1 );
$autoIng	= $params->get( 'autoIng', 1 );
$autoReply	= $params->get( 'autoReply', 1 );
$autoUrl	= $params->get( 'autoUrl', 1 );
$loadingText	= $params->get( 'loadingText', 1 );
$introText	= htmlspecialchars($params->get( 'introText', 1 ),ENT_QUOTES);
$popup = $params->get('popup','yes');
$popupIntro = htmlspecialchars($params->get('popupIntro','I am on Twitter!'),ENT_QUOTES);
$moreInfo = htmlspecialchars($params->get('moreInfo','More Info'),ENT_QUOTES);
$follow	= $params->get( 'follow', 'yes' );
$followMeText	= $params->get( 'followText', "Follow me on twitter" );
$twitterAction = htmlspecialchars($params->get('twitterAction','tweeted'),ENT_QUOTES);
$sourcePre = htmlspecialchars($params->get('sourcePre','from'),ENT_QUOTES);


//get twiiter tokens

$oauthAccessToken	= $params->get( 'oauthAccessToken', 1 );
$oauthAccessTokenSecret	= $params->get( 'oauthAccessTokenSecret', 1 );
$consumerKey	= $params->get( 'consumerKey', 1 );
$consumerKeySecret	= $params->get( 'consumerKeySecret', 1 );




/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => $oauthAccessToken,
    'oauth_access_token_secret' => $oauthAccessTokenSecret,
    'consumer_key' => $consumerKey,
    'consumer_secret' => $consumerKeySecret
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response **/
$twitter = new TwitterAPIExchange($settings);
 $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';//https://api.twitter.com/1.1/followers/ids.json';
$getfield = '?screen_name='.$userName .'&count='.$count;
$requestMethod = 'GET';


$twitter = new TwitterAPIExchange($settings);
$jsonData= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
                   
  $tweets = json_decode( $jsonData );
  
?>

<div class="jTweet">
	<?php if ($popup == "yes") :?>
	<div class="jTweetInfo">
		<div class="bubbleInfo">
			<div class="trigger">
					<?php if(!($twitterBird == "none")) :?>
						<img src="modules/mod_sobi2twitter/images/<?php echo $twitterBird ?>.png" alt="twitter Bird" />
					<?php endif;?>
					<span class="triggerDetail"><?php echo $moreInfo ?></span>
			</div>
			<div class="popup"></div>
		</div>
	</div>
	<?php endif;?>
		
	<div class="tweet tweet<?php echo $moduleID;?>">
	</div>
	<?php if (!($popup == "yes")) :?>
		<div class="noPopup">
			<?php if(!($twitterBird == "none")) :?>
			<img src="modules/mod_sobi2twitter/images/<?php echo $twitterBird ?>.png" alt="twitter Bird" />
			<?php endif;?>
			<?php if($follow == "yes") :?>
				<span class="triggerDetail"><a target="_blank" href="http://twitter.com/<?php echo $userName ?>/"><?php echo $followMeText ?></a></span>
			<?php endif;?>
		</div>
		<?php endif;?>
</div>
<?php
echo'<style>span.tw strong {color: #0B78A1 !important;}</style>';


if(! isset($tweets->errors)):
foreach($tweets as $tweet):  

$showtext = $tweet->text;  

$showtext = utf8_decode($showtext); 

$showtext = url2link($showtext); 

$status_timestamp = strtotime($tweet->created_at); 

$status_locdate = date("Y-m-d (H:i:s)",$status_timestamp); 

echo "<p style=\"text-align:left; width:auto; clear:both;background:none repeat scroll 0 0 #F5F5F5; color:#666666;padding:0.5%\">\r\n"; 

echo "<a href=\"http://twitter.com/".$tweet->user->screen_name."\" title=\"".$tweet->user->name."\" target=\"_blank\"><img src=\"".$tweet->user->profile_image_url."\" alt=\"".$tweet->user->name."\" align=\"left\" width=\"".$avatarSize."\" height=\"".$avatarSize."\" border=\"0\" style=\"padding:10px 8px 2px 0px;\" /></a>\r\n"; 
echo "<span class='tw'>".$showtext."</span>\r\n"; 
echo "<br />&nbsp;\r\n"; 
echo "<small style=\"padding:0px 12px 0px 0px; float:right;\">".$status_locdate."</small>\r\n"; 
echo "</p>\r\n"; 
endforeach; 
		else :
        echo "<P>Sorry, Twitter cannot be contacted. Try again soon.</P>"; 
	  endif; 
	  
	  function url2link ($string, $target="_blank") { 

preg_match_all('|(http://[^\s]+)|', $string, $matches1);

if($matches1) { 

foreach($matches1[0] as $match1) { 

$hypertext = "<a href=\"".$match1."\" target=\"".$target."\"><strong>".$match1."</strong></a>";

$string = str_replace($match1, $hypertext, $string);

}

}

preg_match_all('|(@[^\s]+)|', $string, $matches2);

if($matches2) { 

foreach($matches2[0] as $match2) { 

$hypertext = "<a href=\"http://twitter.com/".$match2."\" target=\"".$target."\"><strong>".$match2."</strong></a>";

$string = str_replace($match2, $hypertext, $string);

}

}

return $string;

}

?>
<div class="jTweetClear"></div>
