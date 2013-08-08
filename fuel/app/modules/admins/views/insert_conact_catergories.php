<?php echo $form->open(); ?>
	
    <div id="insert-conact-catergories" style="min-width:400px">
        	
            <div class="content">
            	
                <h1>INSERT CONTACT CATEGORY</h1>
                
                <div class="box_1">
               	  <div class="r1">
                    	<h4>1.NUMBER <span>(Sort order):</span></h4>
                        <?php echo $form->build_field('sort_order'); ?><br />
						<?php echo $form->build_field('sort_order_value'); ?>
                        <h5>( Number between 9999.99 and 0, with a maximum of 2 dec. places )</h5>
                  </div>
                    
                    <h4>2. CATEGORY NAME</h4>
                    <?php echo $form->build_field('category_name'); ?>
                    
                </div>
                
                <div class="box_2">
                	<div class="rightside">
                    	<div class="fl"><?php echo $form->build_field('submit'); ?></div>
                        <div class="fl"><input type="button" class="button1 cb iframe close cboxElement" value="CANCEL / CLOSE" /></div>
       				</div>
                </div>
                
            </div>
            
    </div>

<?php echo $form->close(); ?>