<?php
/**
 * Joomla! 2.5 and 3.x component com_comboslider
 * @author Opensource Technologies
 * @copyright	Copyright (C) 2014 OpenSource Technologies Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script language="javascript">
function Openbox(val)
{
if(val=="article")
{

document.getElementById("ar_id").style.display="block";
document.getElementById("cat_id").style.display="none";
document.getElementById("sat_id").style.display="none";
/////code added by sonam//////
document.getElementById("orderid").style.display="block";
///////end code////////////
}
else if(val=="category")
{
document.getElementById("cat_id").style.display="block";
document.getElementById("ar_id").style.display="none";
document.getElementById("sat_id").style.display="none";
/////code added by sonam//////
document.getElementById("orderid").style.display="block";
///////end code////////////
}
else if(val=="static")
{
document.getElementById("sat_id").style.display="block";
document.getElementById("ar_id").style.display="none";
document.getElementById("cat_id").style.display="none";
/////code added by sonam//////
document.getElementById("orderid").style.display="block";
///////end code////////////
}
else
 {
 document.getElementById("sat_id").style.display="none";
document.getElementById("ar_id").style.display="none";
document.getElementById("cat_id").style.display="none";
/////code added by sonam//////
document.getElementById("orderid").style.display="none";
///////end code////////////
 }

}

function submitbutton(pressbutton)
		{
			var form = document.adminForm;

			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			
			if (form.type.value == ""){
				alert( "Please select article type"  );
				return false;
			}
			submitform( pressbutton );
}


function Validate()
{

if(document.getElementById("type").value=='')
  {
     alert("Please select type");
	 document.getElementById("type").focus();
	  return false;
  }
 if(document.getElementById("ar_id").style.display=='block')
  {
   
   if(document.getElementById("article").value=="")
    {
      alert("Please select article");
	  return false;
    }
  }
  return true;
}

function showDropdown(rval)
{
if(rval=="Rand")
 {
 document.getElementById("ranId").style.display="block";
 }
 else
  {
   document.getElementById("ranId").style.display="none";
  }
}

</script>
<style>
.adminlist td {
    border: medium none !important;
}
</style>
<form action="" method="post" name="adminForm"   id="adminForm" class="form-validate">
	
	<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
		<table class="adminlist table table-strip">
		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'Type' ); ?>:
				</label>
			</td>
			<td>
			<?php
			
			  if($this->hello->type=="article")
			  {
			   $block1='style="display:block"';
			   $block2='style="display:none"';
			   $block3='style="display:none"';
			   /////code added by sonam/////
			   $block6='style="display:block"';
				///////end code////////////
			  }
			  elseif($this->hello->type=="static")
			  {
			   $block1='style="display:none"';
			   $block2='style="display:none"';
			    $block3='style="display:block"';
				/////code added by sonam/////
				$block6='style="display:block"';
			   ///////end code////////////
			  }
			   elseif($this->hello->type=="category")
			  {
			   $block1='style="display:none"';
			    $block2='style="display:block"';
			   $block3='style="display:none"';
			   /////code added by sonam/////
			   $block6='style="display:block"';
			   ///////end code////////////
			  }
			  else
			   {
			    $block1='style="display:none"';
				 $block2='style="display:none"';
				  $block3='style="display:none"';
				  /////code added by sonam/////
				   $block6='style="display:none"';
				  ///////end code////////////
			   }
			   
			?>
				<select name="type" onchange="Openbox(this.value);" id="type">
				<option value="" >Select</option>
				<option value="article" <?php if($this->hello->type=="article"){?> selected="selected"<?php } ?>>Article</option>
				<option value="static" <?php if($this->hello->type=="static"){?> selected="selected"<?php } ?>>Static</option>
				<option value="category" <?php if($this->hello->type=="category"){?> selected="selected"<?php } ?>>Category</option>
				</select>
			</td>
		</tr>
			<tr><td colspan="2" >
				<table id="ar_id" <?php echo $block1;?>>
					<tr>
						<td width="100" align="right" class="key_list" >
						<label for="greeting">
						<?php echo JText::_( 'Article' ); ?>:
						</label>
						</td>
						<td>
						<select name="article" id="article">
						<option value="">Select</option>
						<?php
						 foreach($this->article as $article)
						  {
						   
						   ?>
						   <option value="<?php echo $article->id?>" <?php  if($this->hello->article ==$article->id){?> selected="selected"<?php }?>><?php echo $article->title?></option>
						   <?php
						   
						  }
						?>
						</select>
						</td>
					</tr>
				</table>
		</td></tr>
		<tr><td colspan="2" >
			<table id="cat_id" <?php echo $block2;?>>
				<tr >
					<td width="100" align="right" class="key">
						<label for="greeting">
						<?php echo JText::_( 'Category' ); ?>:
						</label>
					</td>
				<td>
					<select name="category" id="category">
					<option value="">Select</option>
					<?php
						 foreach($this->category as $category)
						  {
						   ?>
						   <option value="<?php echo $category->id?>" <?php  if($this->hello->category  ==$category->id){?> selected="selected"<?php }?>><?php echo $category->title?></option>
						   <?php
						   
						  }
						?>
					</select>
				</td>
				</tr>
			<tr >
				<td width="100" align="right" class="key">
					<label for="greeting">
					<?php echo JText::_( 'Layout' ); ?>:
					</label>
				</td>
			<td>
				<select name="layout" id="layout" onchange="showDropdown(this.value);">
				<option value="">Select</option>
				<option value="Rand" <?php  if($this->hello->layout   =="Rand"){?> selected="selected"<?php }?> >Random</option>
				<option value="Latest" <?php  if($this->hello->layout   =="Latest"){?> selected="selected"<?php }?>>Latest</option>
				<option value="Most Viewed" <?php  if($this->hello->layout   =="Most Viewed"){?> selected="selected"<?php }?>>Most Viewed</option>
				</select>
			</td>
			</tr>
		</table>
	 </td></tr>
	<tr><td colspan="2" >
		<table id="sat_id" <?php echo $block3;?>>
			<tr>
				<td width="100" align="right" class="key" valign="top">
					<label for="greeting">
						<?php echo JText::_( 'Editor' ); ?>:
					</label>
				</td>
				<td>
				<?php 
				//$editor = JFactory::getEditor();
				$editor = JFactory::getEditor();
//$this->assignRef( 'editor', $editor );
				echo $editor->display( 'edcontent',  htmlspecialchars($this->hello->edcontent, ENT_QUOTES), '700', '300', '60', '20', array('pagebreak', 'readmore') ) ;
				?>
				<!--<textarea name="content" id="content" cols="60" rows="7"><?php //cho $this->hello->content;?></textarea>-->
				</td>
			</tr>
		</table>
	 </td></tr>
	  <?php
	  if($this->hello->rantime)
	   {
	    $block4='style="display:block"';
	   }
	   else
	   {
	   $block4='style="display:none"';
	   }
	 ?>
	    <tr><td colspan="2">
	    <table id="ranId" <?php echo $block4;?>>
		<tr>
				<td width="100" align="right" class="key" valign="top">
					<label for="greeting">
						<?php echo JText::_( 'Article Interval' ); ?>:
					</label>
				</td>
				<td>
				<select name="rantime" id="rantime" >
				<option value="">Select</option>
				<option value="every" <?php if($this->hello->rantime   =="every"){?> selected="selected"<?php }?>>Every Time</option>
				<option value="6"  <?php if($this->hello->rantime   =="6"){?> selected="selected"<?php }?> >Display for 6 hours</option>
				<option value="12"<?php if($this->hello->rantime   =="12"){?> selected="selected"<?php }?>>Display for 12 hours</option>
				<option value="24"<?php if($this->hello->rantime   =="24"){?> selected="selected"<?php }?>>Display for 24 hours</option>
				<option value="48"<?php if($this->hello->rantime   =="48"){?> selected="selected"<?php }?>>Display for 48 hours</option>
				</select>
				
				</td>
			</tr>
		</table>
	   </td></tr>
	   
	    <!--------code added by sonam for ordering------->
  <tr><td colspan="2">
	   <table id="orderid" <?php echo $block6;?>>
	   <tr  >
				<td width="100" align="right" class="key">
					Ordering:	
				</td>
				<td>
				<select name="ordering" id="ordering"  >
				<option value="">Select</option>
				<?php  for($i=1;$i<=20;$i++) { 
			       if($this->hello->ordering   ==$i)
				   {
				    $selected='selected="selected"';
				   }
				   else
				   {
				    $selected='';
				   }
				   ?>
				 
			
				<option value="<?php echo $i;?>" <?php echo  $selected;?> > <?php echo $i;?></option>
				<?php }?> 
				</select>
			   </td>
		      </tr>
	   </table>
	  </td></tr>
 <!--------end code added by sonam for ordering------->
	   
	</table>
	</fieldset>
</div>
	<div>
	<div class="clr"></div>

<input type="hidden" name="option" value="com_comboslider" />
<input type="hidden" name="id" value="<?php echo $this->hello->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="comboslider" />

		<!--<input type="hidden" name="task" value="comboslider.edit" />-->
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

