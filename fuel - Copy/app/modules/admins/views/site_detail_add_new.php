<?php echo $form->open(); ?>
    <div id="site_detail">
    	
        <div class="content">
        	
            <h1>ADD NEW DETAIL</h1>
            
            <div class="box-1">
		
		
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
		    
                	<tr>
                    	<td>
                        	<div class="r1">
                            	<div class="topbox"><?php echo $form->build_field('site_name'); ?></div>
                                <div class="secbox">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                            <td align="center"><p>main phone</p></td>
                                            <td align="center"><?php echo $form->build_field('main_phone'); ?></td>
                                            <td align="center"><p>main fax</p></td>
                                            <td align="center"><?php echo $form->build_field('main_fax'); ?></td>
                                            <td align="center"><p>quote fax</p></td>
                                            <td align="center"><?php echo $form->build_field('quote'); ?></td>
                                        </tr>
                                	</table>
                                </div>
                                <div class="thbox">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<td width="50%" valign="top">
                                        	<div class="c1">
                                            	<h4>physical address</h4>
                                                <?php echo $form->build_field('physical_addess_1'); ?>
                                                <?php echo $form->build_field('physical_addess_2'); ?>
                                                <?php echo $form->build_field('physical_addess_3'); ?>
                                            </div>
                                        </td>
                                        <td valign="top">
                                        	<div class="c1">
                                            	<h4>postal address</h4>
                                               <?php echo $form->build_field('postal_addess_1'); ?>
                                               <?php echo $form->build_field('postal_addess_2'); ?>
                                               <?php echo $form->build_field('postal_addess_3'); ?>
                                            </div>
                                        </td>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
			
                </table>
            </div>
            
            <div class="box-2">
            	<div class="blk"><input type="submit" class="button1" value="Add" />
            	<input type="button" class="button1 cb iframe close spaced" value="close" /></div>
            </div>
            
        </div>
        
    </div>

<?php echo $form->close(); ?>