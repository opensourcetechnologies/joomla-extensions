<?php
/**
 * @package    Joomla.Forum
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.txt
 */
 
defined('_JEXEC') or die;
 ?>
<a href="<?php echo $config['count']; ?>" class="garage-member" style="text-decoration:none;  color:inherit;"><h3><?php echo $module->title; ?></h3></a>
<div class="s-featured"> 
<table class="forumline">
	<tbody>
		<tr class="">
			<th class="thHead"><a href="<?php echo $config['count']; ?>"><?php echo $config['title']; ?></a></th>
		</tr>
		<?php if(!empty($imageData)){ ?>
		<tr>
			<td class=""><span class="genmed" >
			 
			<?php if(!empty($imageData['feature_img'])) { echo $imageData['feature_img']; } ?><br><a href="<?php echo $imageData['imglink']; ?>"><?php if(!empty($imageData['vehicle'])) {  echo $imageData['vehicle']; } ?><br></a> Owner:<a href="<?php echo $imageData['userlink']; ?>"><?php  if(!empty($imageData['username'])) { echo $imageData['username']; } ?></a></span>
			
			</td>
		</tr>
		<?php } ?>
		<tr>
		<td>
			<table>
				<tbody>
					<tr>
						<td  width="50%">
							<?php foreach($Cardata['total_cars'] as $data)  { echo "Vehicles: <b>". number_format ($data->total_cars); } ?></b>
						</td>
						<td width="50%">
							<?php foreach($Cardata['total_mods'] as $mods)  { echo "Modifications: <b>".number_format($mods->total_mods); } ?></b>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table>
				<tbody>
					<tr>
						<td width="50%">
							<?php foreach($Cardata['total_comments'] as $comm)  { echo "Comments: <b>". number_format($comm->total_comments); } ?></b>
						</td>
						<td width="50%">
							<?php foreach($Cardata['total_cars'] as $cars)  { echo "Views: <b>".number_format($cars->total_views); } ?></b>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
</div>
