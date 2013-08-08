
<form action="quotes/create_batch" method="post">


    <div id="create_batch">
    	
        <div class="content">
        	
            <h1>CREATE BATCH OF QUOTES BASED ON Q120002</h1>
            
            <div class="box-1">
            	
                <p>ENTER NUMBER OF EXTRA QUOTES REQUIRED</p>
                
                <input type="text" class="textbox-1" name="QuotesToBatch"/>
                
                <h6>(Maximum = 9)</h6>
                
            </div>
	    
            <?php
                echo $form->build_field('Q_YearSeq_pk');
                echo $form->build_field('Q_FullNumber');
            ?>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button1" value="create quotes" /></div>
                	<div class="blk"><input type="button" class="cb iframe close button1" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
    
</form>
