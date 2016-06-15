<?php
/**
 * @package    Joomla.Forum
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.txt
 */
defined('_JEXEC') or die;

class ModGarageFeaturedHelper
{
	 public $con;
	 
	 
	 
	 public function __construct()
     {
		global $config;
		$finclude = JPATH_SITE."/".$config['forum_dir']."/config.php";
		try {
			if (file_exists($finclude)) {
			/**
			* require the JFusion libraries
			*/
			include($finclude);
			$option = array(); //prevent problems
			$option['driver']   = 'mysql';          // Database driver name
			$option['host']     = $dbhost;    	// Database host name
			$option['user']     = $dbuser;       	// User for database authentication
			$option['password'] = $dbpasswd;  		// Password for database authentication
			$option['database'] = $dbname;  	// Database name
			$option['prefix']   = $table_prefix;         // Database prefix (may be empty)
	 
			$this->con = JDatabaseDriver::getInstance( $option );
		}
		else {
			throw new RuntimeException(JText::_('NO_COMPONENT'));
		}
		} catch (Exception $e) {
			JFusionFunction::raiseError($e, 'mod_jfusion_phpbb_featured_garage');
			echo $e->getMessage();
		}
			
	}
	
	public function getStats()
	{   
		$db = $this->con;
		$query_posts = $db->getQuery(true);
		$query_posts ="SELECT count(*) AS total_cars, SUM(views) AS total_views FROM phpbb_garage";
		$db->setQuery($query_posts);
		$total_cars = $db->loadObjectList();
		
		$query_posts = "SELECT count(*) AS total_mods FROM phpbb_garage_mods";
		$db->setQuery($query_posts);
		$total_mods = $db->loadObjectList();
		
		$query_posts = "SELECT count(*) AS total_comments FROM phpbb_garage_guestbooks";
		$db->setQuery($query_posts);
		$total_comments = $db->loadObjectList();
		
		$allArray = array("total_cars" => $total_cars, "total_mods" => $total_mods, "total_comments" => $total_comments );
		return $allArray;
		
	}
	
	public function getImage()
	{  
		global $config;
		 $db = $this->con;
		 $username  ='';
		 $userlink ='';
		 $imglink = '';
		 $vehicle = '';
		 $featured_image = '';
		 $allData ='';
		
		$query_posts_config = "SELECT config_name, config_value FROM phpbb_garage_config";
		$db->setQuery($query_posts_config);
		$result_data = $db->loadAssocList();
		
		foreach($result_data as $result) 
		{
			$garage_config_name = $result['config_name'];
			$garage_config_value = $result['config_value'];
			$garage_config[$garage_config_name] = $garage_config_value;
		}
		
		$sql = "SELECT g.id FROM phpbb_garage g
					LEFT JOIN phpbb_garage_makes AS makes ON g.make_id = makes.id 
					LEFT JOIN phpbb_garage_models AS models ON g.model_id = models.id 
					WHERE makes.pending = 0 and models.pending = 0 and image_id IS NOT NULL 
					ORDER BY rand() LIMIT 1";
		$db->setQuery($sql);
		$vehicle_data = $db->loadObjectList();
		
		if(!empty($vehicle_data)){
			
		 $featured_vehicle_id = $vehicle_data['0']->id;
		
		 $sql1 = "SELECT id FROM phpbb_garage WHERE id='". $featured_vehicle_id ."'";
		 $db->setQuery($sql1);
		 $vehicle_fea = $db->loadObjectList();
		
		
		 $where = "WHERE g.id='".$vehicle_fea['0']->id."' GROUP BY g.id";
		if ( (count($vehicle_fea)) > 0 OR (!empty($garage_config['featured_vehicle_from_block'])) )
		{
			$sql1 = "SELECT g.id, g.made_year, g.image_id, g.member_id, makes.make, models.model, 
						images.attach_id, images.attach_hits, images.attach_thumb_location, m.username, 
						images.attach_is_image, images.attach_location, COUNT(mods.id) AS mod_count,
						CONCAT_WS(' ', g.made_year, makes.make, models.model) AS vehicle,
						(SUM(mods.install_price) + SUM(mods.price)) AS money_spent, sum( r.rating ) AS rating
							FROM phpbb_garage AS g 
							LEFT JOIN phpbb_garage_makes AS makes ON g.make_id = makes.id 
							LEFT JOIN phpbb_garage_images AS images ON images.attach_id = g.image_id
							LEFT JOIN phpbb_garage_models AS models ON g.model_id = models.id 
							LEFT JOIN phpbb_garage_mods AS mods ON g.id = mods.garage_id 
							LEFT JOIN phpbb_garage_rating AS r ON g.id = r.garage_id 
							LEFT JOIN phpbb_users AS m ON g.member_id = m.user_id  $where"; 
				$db->setQuery($sql1);
				$vehicle_data_new = $db->loadObjectList();
			
				
		}
		$img_loc = JPATH_ROOT ."/".$config['forum_dir']."/garage/upload/"; 
		$img_link = JURI::root().$config['forum_dir']."/garage/upload/";
		if ( (!empty($vehicle_data_new['0']->image_id)) AND (!empty($vehicle_data_new['0']->attach_is_image) == 1) ) 
		{
			if ( (!empty($vehicle_data_new['0']->attach_thumb_location)) AND ($vehicle_data_new['0']->attach_thumb_location != $vehicle_data_new['0']->attach_location) AND (@file_exists($img_loc.$vehicle_data_new['0']->attach_thumb_location)))
			{
				// Yippie, our thumbnail is already made for us :)
					$thumb_image = $img_link. $vehicle_data_new['0']->attach_thumb_location;
					$featured_image = '<a href="index.php?modes=view_gallery_item&amp;type=garage_mod&amp;image_id='. $vehicle_data_new['0']->attach_id .'" title="" target="_blank" ><img src="' . $thumb_image .'" class="attach"  alt=""/></a>';
				} 
		}
		$vehicle = $vehicle_data_new['0']->vehicle;
		$username = $vehicle_data_new['0']->username;
		$userlink = JURI::root().$config['forum_dir']."/memberlist.php?mode=viewprofile&u=".$vehicle_data_new['0']->member_id;
		$imglink =  JURI::root().$config['forum_dir']."/index.php?modes=view_vehicle&CID=".$vehicle_data_new['0']->id;
		$allData = array("username" => $username , "userlink" => $userlink, "imglink" => $imglink,  "vehicle" => $vehicle, "feature_img" => $featured_image );
	}
		
		return $allData;
	}
	
}
