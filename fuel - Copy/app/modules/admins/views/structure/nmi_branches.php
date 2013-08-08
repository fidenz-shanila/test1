	
    <div id="nmi-branch">
    	
        <div class="content">
        	
            <h1>NMI BRANCHES</h1>
            
            <div class="box-1">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    
                    <?php foreach ($branches as $key => $value) { ?>
		    <tr>
                    	<td width="3%" align="center">
			<button href="<?php echo \Uri::create('admins/structures/branch_form?B_BranchID_pk='.$key.'&name='.urlencode($value)); ?>" class=button1>..</button>
			</td>
                        <td width="90%"><input type="text" class="textbox-1" value="<?php echo $value?>" /></td>
                        <td><input type="button" value="DELETE" class="button2 action-delete" data-object="Branch" href="<?php echo \Uri::create('admins/structures/delete_branch?B_BranchID_pk='.$key); ?>"/></td>
                    </tr>
                   <?php } ?>
                    
                </table>
            </div>
            
            <div class="box-2">
            	<div class="rightside">
		    <button href="<?php echo \Uri::create('admins/structures/insert_branch'); ?>" class=button1>INSERT</button>
                    <div class="blk1"><input type="button" value="CLOSE" class="button1 cb iframe close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
