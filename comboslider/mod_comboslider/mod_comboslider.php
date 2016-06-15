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
// Include the syndicate functions only once
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}
require_once( dirname(__FILE__).DS.'helper.php' );
 
$hello = modCombosliderHelper::getHello( $params );
require( JModuleHelper::getLayoutPath( 'mod_comboslider' ) );
?> 
