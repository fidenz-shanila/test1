
    <div id="site_detail">
    	
        <div class="content">
        	
            <h1>SITE DETAIL LISTING</h1>
	    
	    
            
            <div class="box-1">
		
		
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
		    
		    <?php foreach ($details as $detail) {?>
		    
                	<tr>
                    	<td>
                        	<div class="r1">
                            	<div class="topbox"><?php echo $detail['SD_SiteName_pk']; ?></div>
                                <div class="secbox">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                            <td align="center"><p>main phone</p></td>
                                            <td align="center"><input type="text" class="textbox-1" value="<?php echo $detail['SD_MainPhone']; ?>"/></td>
                                            <td align="center"><p>main fax</p></td>
                                            <td align="center"><input type="text" class="textbox-1" value="<?php echo $detail['SD_MainFax']; ?>"/></td>
                                            <td align="center"><p>quote fax</p></td>
                                            <td align="center"><input type="text" class="textbox-1" value="<?php echo $detail['SD_QuoteFax']; ?>"/></td>
                                        </tr>
                                	</table>
                                </div>
                                <div class="thbox">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<td width="50%" valign="top">
                                        	<div class="c1">
                                            	<h4>physical address</h4>
                                                <textarea cols="" rows="" class="textarea-1"><?php echo $detail['SD_PhysicalAddress1'].'&#10'?><?php echo $detail['SD_PhysicalAddress2'].'&#10' ?><?php echo $detail['SD_PhysicalAddress3'] ?></textarea>
                                            </div>
                                        </td>
                                        <td valign="top">
                                        	<div class="c1">
                                            	<h4>postal address</h4>
                                                <textarea cols="" rows="" class="textarea-1"><?php echo $detail['SD_PostalAddress1'].'&#10' ?><?php echo $detail['SD_PostalAddress2'].'&#10' ?><?php echo $detail['SD_PostalAddress3']; ?></textarea>
                                            </div>
                                        </td>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
			
			<?php } ?>
                   
                </table>
            </div>
            
            <div class="box-2">
            	<div class="blk"><input href="<?php echo \Uri::create('admins/add_new_details');?>" type="button" class="button1" value="Add New" />
            	<input type="button" class="button1" value="close" /></div>
            </div>
            
        </div>
        
    </div>

