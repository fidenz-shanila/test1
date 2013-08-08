	
    <div id="insert_fee">
    	
        <div class="content">
        	
            <h1>INSERT FEE</h1>
            
            <form action="<?php echo Uri::create('admins/structures/insert_fees?A_AreaID_pk='.$A_AreaID_pk);?>" method="post">
	    
            <div class="box-0">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td valign="top" align="center" width="10%"><p>CODE</p><input type="text" class="textbox-1" name="F_Code"/></td>
                        <td valign="top" align="center" width="80%"><p>DESCRIPTION (max. = 140 charactors)</p><textarea cols="" rows="" class="textarea-1" name="F_Description"></textarea></td>
                        <td valign="top" align="center"><p>FEE (SUGGESTED)</p><input type="text" class="textbox-1" name="F_Fee"/></td>
                    </tr>
                </table>
            </div>
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk1"><input type="submit" value="INSERT" class="button1" /></div>
                    <div class="blk1"><input type="reset" value="CANCEL / CLOSE" class="button1" /></div>
                </div>
            </div>
	    
	    </form>
            
        </div>
        
    </div>

