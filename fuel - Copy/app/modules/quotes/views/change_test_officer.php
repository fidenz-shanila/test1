
<form action="<?php echo \Uri::create('quotes/change_test_officers/'); ?>" method="post" >

	
    <div id="change_test_officer">
    	
        <div class="content">
        	
            <h1>CHANGE TEST OFFICER</h1>
            
            <div class="box-1">
            	
                <div class="c1">
                	<h3>Test Officer</h3>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                        	<td align="center"><?php echo $form->WDB_TestOfficerEmployeeID;?><?php echo $form->WDB_WorkDoneBy_pk;?></td>
                        </tr>
                    </table>
                </div>
                
                
                
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button1" value="apply"  onclick=""  /></div>
                	<div class="blk"><input type="button" class="button2" value="cancel / close" onclick="javascript:parent.jQuery.fn.colorbox.close();" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

</form>