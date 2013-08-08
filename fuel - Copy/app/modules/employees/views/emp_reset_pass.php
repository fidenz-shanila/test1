<?php echo $form->open();?>
	
    <div id="reset_user_pass">
    	
        <div class="content">
        	
            <h1>RESET USER PASSWORD</h1>
          <h2><?php echo $topic ?></h2>
            <?php /*?><img src="<?php echo $profile_image; ?>" width="30px" height="30px" /><?php */?>
            <div class="box-1">
            	
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    <tr>
                        <td width="20%" valign="top"><p>Password:</p></td>
                        <td valign="top"><?php echo $form->build_field('resetpass'); ?></td>
                    </tr>
                
                    
                </table>
  
                
            </div>
            
            <div class="box-2">
            	<div class="rightside">
           			 <div class="blk"><?php echo $form->build_field('save'); ?></div>
                    <div class="blk"><?php echo $form->build_field('cancel'); ?></div>
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo $form->close();?>

</body>
</html>
