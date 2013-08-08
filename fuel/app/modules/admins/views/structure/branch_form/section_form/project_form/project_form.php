	
    <div id="project_form">
    	
        <div class="content">
        	
            <h1>PROJECT FORM</h1>
            
            
            <div class="box-0">
            	<p>PROJECT:</p><input type="text" class="textbox-1" value="<?php echo $name; ?>"/>
            </div>
            
            
            
            <div class="mainbox">
            	
                <div class="box-1">
                	
                    <h2>Area within 'Length'</h2>
                
                	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
			    
			<?php foreach ( $areas as $area ) {?>    
			    <tr>
				<td width="3%"><button href="<?php echo \Uri::create('admins/structures/area_form?A_AreaID_pk='.$area['A_AreaID_pk'].'&A_Name_ind='.$area['A_Name_ind']); ?>" class=button1>..</button></td>
				<td width="90%"><input type="text" class="textbox-1" value="<?php echo $area['A_Name_ind']?>"/></td>
				<td><input type="button" value="DELETE" class="button2" /></td>
			    </tr>
                       <?php } ?>
                        
                    </table>
                    
                    <div class="rightside">
                    	<button href="<?php echo \Uri::create('admins/structures/insert_area'); ?>" class=button1>INSERT AREA</button>
                    </div>
                    
                </div>	
                
                <div class="box-2">
                	
                    <h2>Staff within 'Length'</h2>
                
                	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
			<?php foreach ($staff as $s){ ?>
			    <tr>
				<td width="8%" align="center" class="forsttd"><button href="<?php echo \Uri::create('admins/structures/employee_form?EM1_EmployeeID_pk='.$s['EM1_EmployeeID_pk']); ?>" class=button1>..</button></td>
				<td width="75%"><input type="text" class="textbox-1" value="<?php echo $s['EM1_FullNameNoTitle']?>"/></td>
				<td><input type="button" value="REMOVE" class="button2" /></td>
			    </tr>
			<?php } ?>
                        
                    </table>
                
                    <div class="rightside">
                        <button href="<?php echo \Uri::create('admins/structures/manage_staff_section_form'); ?>" class=button1>MANAGE PROJECT STAFF</button>
                    </div>
                </div>
                
                <div class="laststrip">
                	<div class="leftbuttons">
                    	<div class="blk2">
                        	<p>project code:</p>
                            <div class="tbox"><input type="text" class="textbox-1" /></div>
                            <h6><input type="checkbox" /> &nbsp;Hour Entry Required</h6>
                        </div>
                    </div>
                	<div class="rightbuttons"><input type="button" class="button1" value="CLOSE" /></div>
                </div>
            
            </div>
            
        </div>
        
    </div>
