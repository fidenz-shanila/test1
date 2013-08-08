<?php echo $form->open(); ?>

	
    <div id="insert_instrmunt">
	
        <div class="content">
        	
            <h1>INSERT INSTRUMENT TYPE</h1>
            
            
            <div class="box-0">
            	<p>TYPE (max. = 70 charactors)</p>
            	<?php echo $form->build_field('IT_Name_ind'); ?>
            	<?php echo $form->build_field('A_AreaID_pk'); ?>
            </div>
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk1"><input type="submit" value="INSERT" class="button1" /></div>
                    <div class="blk1"><input type="reset" value="CANCEL / CLOSE" class="button1" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php echo $form->close(); ?>