<?php
/**
 * @copyright	Copyright (c) 2014 OPENSOURCE TECHNOLOGIES. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *      Author:     Akash Nand
 *      Email:      akash@opensourcetechnologies.com
 *      Version:    1.0
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="ost_linkdinfeed">
	 <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
    <?php if($company_id){ ?>
	     <script type="IN/JYMBII" data-companyid="<?php echo $company_id; ?>" data-format="inline"></script>
     <?php }else{ ?>
          <script type="IN/JYMBII" data-format="inline"></script>
      <?php } ?>
 </div>