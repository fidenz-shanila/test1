	
    <div id="area_form">
    	
        <div class="content">
        	
            <h1>AREA FORM</h1>
            
            <div class="box-0">
            	<p>AREA:</p>
                <input type="text" class="textbox-1" value="<?php echo $A_Name_ind; ?>"/>
            </div>
            
            <div class="mainbox">
            	
                <div class="box-1">
                	<h2>Fee for 'Ball Plates and Hole Plates' area</h2>
                    <div class="r1">
                    	<div class="tableblock">
                            <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                                <tr>
                                    <td valign="top" align="center" width="15%"><p>CODE</p></td>
                                    <td valign="top" align="center" width="65%"><p>DESCRIPTION (Max. = 140 charactors)</p></td>
                                    <td valign="top" align="center"><p>FEE (SUGGESTED)</p></td>
                                </tr>
				
				<?php foreach ($area as $a) {?>
                                <tr>
                                    <td valign="top" align="center"><input type="text" class="textbox-1" value="<?php echo $a['F_Code']; ?>"/></td>
                                    <td valign="top" align="center"><textarea cols="" rows="" class="textarea-1"><?php echo $a['F_Description']; ?></textarea></td>
                                    <td valign="top" align="center"><input type="text" class="textbox-1" value="<?php echo $a['F_Fee']; ?>"/>
				    <input type="button" class="button1" value="DELETE" href="<?php echo \Uri::create('admins/structures/delete_fee?F_FeeID_pk='.$a['F_FeeID_pk']);?>"/></td>
                                </tr>
				<?php } ?>
                                
                            </table>
                        
                        </div>
                    </div>
                    <div class="lastbutton">
                        <button href="<?php echo \Uri::create('admins/structures/insert_fee?A_AreaID_pk='.$A_AreaID_pk ); ?>" class=button1>INSERT FEE</button></td>
                    </div>
                </div>
                
                <div class="box-2">
                	<h2>Inst. types for 'Bell Plates and Hole Plates' area</h2>
                    <div class="col1">
                    	<h4>SELECTED TYPES<br />(Double click delete)</h4>
                        	 <?php echo \Form::select('selected_types', '', $selected_types, array('class' => 'select-1', 'size' => 31, 'id' => 's_types'));?>
                        <div class="blk">
                            <input type="button" class="button1" id="edit_available_type" value="EDIT"/>
                            <input type="button" class="button2" id="delete_available_type" value="DELETE <<" />
                            <input type="button" class="button3" href="<?php echo Uri::create('admins/structures/insert_instrument_type_form?A_AreaID_pk='.$A_AreaID_pk); ?>" value="INSERT >>" />
                        </div>
                    </div>
                    <div class="col2">
                    	<h4>AVAILABLE TYPES<br />(Double click select)</h4>
			    <?php echo \Form::select('available_types', '', $available_types, array('class' => 'select-1', 'size' => 40, 'id' => 'a_types'));?>
                    </div>
                </div>
                
            </div>
            
            <div class="box-3">
            	<div class="blk1"><input type="button" class="button1" value="CLOSE" /></div>
                <div class="blk2">
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                        	<td width="88%" valign="top" align="center"><p>PATH TO INFO. (option)</p><input type="text" class="textbox-1" /></td>
                            <td valign="top"><input type="button" class="button1" value="BROWSE" /><input type="button" class="button1" value="GO" /></td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <script type="text/javascript">
	$('#a_types').dblclick(function(){
	    var selected_val = $(this).val();
	    
	    $.ajax({
		url : "<?php echo \Uri::create('admins/structures/add_selected_type');?>",
		data : {'A_AreaID_pk':'<?php echo $A_AreaID_pk; ?>', 'lstAvailableInstruments':selected_val},
		method : "POST",
		success : function(data){
		    $.each(data, function(key, val){
			$('#s_types').append('<option value='+key+'>'+val+'</option>');
			console.log('<option value='+key+'>'+val+'</option>');
		    });
		    
		},
		
	    });
	});
	
	$('#s_types').dblclick(function(){
	    var selected_val = $(this).val();
	    
	    $.ajax({
		url : "<?php echo \Uri::create('admins/structures/delete_from_selected');?>",
		data : {'AIT_AreaInstumentTypeID_pk': selected_val },
		method : "POST",
	    });
	});
	
	$('#edit_available_type').click(function(){
	    var selected_val = $('#a_types').val();
	    var selected_text = $('#a_types option:selected').text();
	    var edited_text = prompt("Please enter new value", selected_text);
	    
	    $.ajax({
		url : "<?php echo \Uri::create('admins/structures/edit_available_type');?>",
		data : {'IT_Name_ind': edited_text, 'IT_InstrumentTypeID_pk':selected_val},
		method : "POST",
	    });
	});
	
	$('#delete_available_type').click(function(){
	    var selected_val = $('#a_types').val();
	    
	    $.ajax({
		url : "<?php echo \Uri::create('admins/structures/delete_available_type');?>",
		data : {'IT_InstrumentTypeID_pk': selected_val},
		method : "POST",
		success : function(){
		    alert('Delete Success');
		}
	    });
	});
	
	
    </script>
    
    
    
