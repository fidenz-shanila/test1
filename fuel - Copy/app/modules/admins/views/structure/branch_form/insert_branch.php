<?php echo $form->open(); ?>
	
    <div id="insert_branch">
    	
        <div class="content">
        	
            <h1>INSERT BRANCH</h1>
            
            
            <div class="box-0">
            	<p>BRANCH (max. = 80 characters)</p>
                <?php echo $form->build_field('branch'); ?>
            </div>
            
            
            
            <div class="box-2">
            	<div class="rightside">
                    <div class="blk1"><input type="submit" value="INSERT" class="button1" /></div>
                    <div class="blk1"><input type="button" value="CANCEL / CLOSE" class="button1 cb iframe close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo $form->close(); ?>