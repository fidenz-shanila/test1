<div id="manage_staff">
        <div class="content">
        	
            <h1>MANAGE SECTION STAFF FORM</h1>
            
            
            <div class="box-0">
            	<input type="text" class="textbox-1" value="Lenght, Time and Optical Standerds" />
            </div>
            
            
            
            <div class="mainbox">
            	
                <div class="box-1">
                	
                    <h2>SECTION STAFF</h2>
                	
                    <div class="r1">
                    
                        <table cellpadding="0" cellspacing="0" border="0" class="table-1">
			    <?php foreach ($section_staff as $staff) { ?>
                            <tr>
                                <td width="5%" align="center"><button href="<?php echo \Uri::create('admins/structures/employee_form'); ?>" class=button1>..</button></td>
                                <td width="85%"><input type="text" class="textbox-1" value="<?php echo $staff['EM1_FullNameNoTitle'] ?>"/></td>
                                <td><input type="button" value="REMOVE" class="button2" href="<?php echo \Uri::create('admins/structures/remove_section_staff?SE_EmployeeID_fk='.$staff['SE_SectionEmployeeID_pk']); ?>" /></td>
                            </tr>
			    <?php } ?>
                           
                        </table>
                    
                    </div>
                    
                </div>	
                
                <div class="box-2">
                	
                    <h2>AVAILABLE STAFF<br />(double click to select)</h2>
		    
		    <?php echo \Form::select('employees','', $employees, array('size' => '40', 'class' => 'select-1', 'id' => 'add_staff'));?>
                	
                    
                </div>
                
                <div class="laststrip">
                	<div class="blk1"><input type="button" class="button1" value="CLOSE" /></div>
                </div>
            
            </div>
            
        </div>
    </div>

<script type="text/javascript">
    $('#add_staff').on('dblclick', function(){
	    var emp = $(this).val();
	    
	    $.ajax({
		url : "<?php echo \Uri::create('admins/structures/add_staff');?>",
		method : "POST",
		data : { 'S_SectionID_pk':'<?php echo \Input::param('S_SectionID_pk');?>', 'SE_EmployeeID_fk': emp },
	    });
	});
</script>
