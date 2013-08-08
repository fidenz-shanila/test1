<?php echo $form->open(); ?>
	
    <div id="insert_orga">
    	
        <div class="content">
        	
            <h1>INSERT ORGANISATION CATEGORY</h1>
            
            <div class="box-1">
            	
                <div class="r1">
                	
                    <p>1. NUMBER (sort order):</p>
                    	<?php echo $form->build_field('sort_order'); ?><br />
						<?php echo $form->build_field('sort_order_value'); ?>
                    <h6>( Number between 1000 and 9999.99, with a maximum of 2 dec. places)</h6>
                    
                </div>
                
                <p>2. CATEGORY NAME</p>
                <?php echo $form->build_field('organisation_name'); ?>
                
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="fl"><?php echo $form->build_field('submit'); ?></div>
                    <div class="fl"><input type="button" class="button1" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php echo $form->close(); ?>