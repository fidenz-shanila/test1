
    <div id="section_form">
    	
        <div class="content">
        	
            <h1>SECTION FORM</h1>
            
            
            <div class="box-0">
            	<input type="text" class="textbox-1" value="<?php echo $name; ?>"/>
            </div>
            
            
            
            <div class="mainbox">
            	
                <div class="box-1">
                	
                    <h2>Projects within '<?php echo $name; ?>'</h2>
                
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
			
			<?php foreach ($projects as $proj) {?>
                        <tr>
                            <td width="3%" align="center"><button href="<?php echo \Uri::create('admins/structures/project_form?P_ProjectID_pk='.$proj['P_ProjectID_pk'].'&name='. $proj['P_Name_ind']); ?>" class=button1>..</button></td>
			    <td><input type="text" class="textbox-1" value="<?php echo $proj['P_Name_ind']; ?>"/></td>
                            <td><input type="button" value="DELETE" data-object="<?php echo $proj['P_Name_ind']; ?>" class="button2 action-delete" href="<?php echo \Uri::create('admins/structures/delete_section?P_ProjectID_pk='.$proj['P_ProjectID_pk'].'&S_SectionID_pk='.$S_SectionID_pk.'&name='.urlencode($name)); ?>" /></td>
                        </tr>
			<?php } ?>
                        
                    </table>
                    
                    <div class="rightside">
                    	<div class="blk2">
                        	<p>section code:</p>
                            <input type="text" class="textbox-1" value="<?php echo $s_code; ?>" />
                        </div>
                        <div class="blk1">
			<button href="<?php echo \Uri::create('admins/structures/insert_project?S_SectionID_pk='.$S_SectionID_pk); ?>" class=button1>INSERT PROJECT</button></div>
                    </div>
                    
                </div>	
                
                <div class="box-2">
                	
                    <h2>Staff within '<?php echo $name; ?>'</h2>
					
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
			<?php foreach ($staff as $st) {?>
                        <tr>
                            <td width="8%" align="center" class="forsttd"><button href="<?php echo \Uri::create('admins/structures/employee_form'); ?>" class=button1>..</button></td>
                            <td width="75%"><input type="text" class="textbox-1" value="<?php echo $st['EM1_FullNameNoTitle']?>"/></td>
                            <td><input type="button" value="REMOVE" class="button2 action-delete" data-object="<?php echo $st['EM1_FullNameNoTitle']?>" href="<?php echo \Uri::create('admins/structures/delete_staff?SE_SectionEmployeeID_pk='. $st['SE_SectionEmployeeID_pk'].'&S_SectionID_pk='.$S_SectionID_pk.'&name='.urlencode($name)) ?>" /></td>
                        </tr>
			<?php } ?>
                    </table>
                
                    <div class="rightside">
                        <div class="blk1"><button href="<?php echo \Uri::create('admins/structures/manage_staff_section_form?S_SectionID_pk='.$S_SectionID_pk ); ?>" class=button1>MANAGE SECTION STUFF</button></div>
                    </div>
                </div>
                
                <div class="laststrip">
                	<input type="button" class="button1" value="CLOSE" />
                </div>
            
            </div>
            
        </div>
        
    </div>


