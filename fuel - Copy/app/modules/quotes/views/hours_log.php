	<?php echo $form->open(); ?>
    <div id="hours">
		
        <div class="content">
        	
            <h1>HOURS</h1>
            
            
            
            <div class="mainbox">
            	
                <div class="topbox">
                	<p>INSTRUMENT / ARTEFACT DESCRIPTION</p>
                    
                    <?php echo $form->build_field('A_description'); ?>
                </div>
                
                <div class="div_1">
                    
                    <div class="blk1">
                        <div class="c1">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center"><h6>TYPE OF HOUR</h6></td>
                                </tr>
                                <tr>
                                    <td align="center">
	                                    <?php echo $form->build_field('type'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"><h6>DATE</h6></td>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $form->build_field('date'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="c2">
                            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                                <tr>
                                    <td width="50%" align="center" class="one">
                                    	<p>ENTERED BY</p>
                                    </td>
                                </tr>
                                <tr>
                                	<td class="one" align="center"><?php echo $form->build_field('employee'); ?></td>
                                </tr>
                                <tr>
                                	<td class="one" align="center">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <div class="c3">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td colspan="6"><p>TIME</p></td>
                                </tr>
                                <tr>
                                	<td colspan="3"><p>HOURS</p></td>
                                    <td colspan="3"><p>MINUTES</p></td>
                                </tr>
                                <tr>
									<td><?php echo $form->build_field('hours'); ?></td>
									<td><input type="button" class="button1 spaced" id="hours_up" value="+" /></td>
									<td><input type="button" class="button1 spaced" id="hours_down" value="-" /></td>
									<td><?php echo $form->build_field('minutes'); ?></td>
									<td><input type="button" class="button1 spaced" id="mins_up" value="+" /></td>
									<td><input type="button" class="button1 spaced" id="mins_down" value="-" /></td>
                                </tr>
                            </table>
                        </div>
																								
                        <div class="c4">
                           <input type="submit" value="" id="log_hours" class="button1">
                        </div>
                    </div>
                    
                    <div class="blk2">
                        <h2>HOUR LOG</h2>
			
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tr>
                                <td width="25%" valign="top"><p>date</p></td>
                                <td width="30%" valign="top"><p>NAME</p></td>
                                <td width="20%" valign="top"><p>(hh:mm)</p></td>
                                <td valign="top"><p>hour type</p></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td valign="top" colspan="5">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table-2">
					
					
					<?php foreach($log as $l) {?>
                                        <tr>
                                            <td width="25%" align="center"><input type="text" class="textbox-1" value="<?php echo date("m.d.y", strtotime($l['H_HoursDate'])); ?>"></td>
                                            <td width="30%" align="center"><input type="text" class="textbox-1" value="<?php echo $l['EmployeeFullName']; ?>"></td>
                                            <td width="20%" align="center"><input type="text" class="textbox-1" value="<?php echo $l['H_HoursInHhMm']; ?>"></td>
                                            <td align="center"><input type="text" class="textbox-1" value="<?php echo $l['H_HoursType']; ?>"></td>
                                            <td><input type="button" value="Delete" href="<?php echo \Uri::create('quotes/delete_work_log/'.$l['H_HoursID_pk']."/?WDB_P_Name={$WDB_P_Name}&WDB_WorkDoneBy_pk={$WDB_WorkDoneBy_pk}"); ?>"/></td>
                                        </tr>
					<?php } ?>
					
                                    </table>
                                </td>
                            </tr>
                        </table>
			
                    </div>
                    
                </div>
                
            </div>
            
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        	<tr>
                            	<td><p>TOTAL HOURS:</p></td>
                                <td><input type="text" class="textbox-1" value="<?php echo $WDB_HoursInHhMm ?>" /></td>
                                <td><p>(hh:mm)</p></td>
                            </tr>
                        </table>
                    </div>
                	<div class="blk"><input type="button" class="button2 cb iframe close" value="close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php 
echo $form->build_field('WDB_WorkDoneBy_pk');
echo $form->build_field('WDB_P_Name');
echo $form->close();
?>




<script type="text/javascript">
	(function(){
		$('#hours_up').click(function(){
			var hours  = $('#form_hours').val();

			if(hours != '') {
				hours++;
			}else{
				$('#form_hours').val(0)
				return false
			}
			$('#form_hours').val(hours);
		});
		
		$('#hours_down').click(function(){
			var hours  = $('#form_hours').val();
			
			if(hours <= 0 ){
				$('#form_hours').val(0);
				return false;
			}
			
			if(hours != '') {
				hours--;
			}
			$('#form_hours').val(hours);
		});
		
		$('#mins_up').click(function(){
			var mins = $('#form_minutes').val();
			
			if(mins >= 45) {
				$('#form_minutes').val(0);
				var hours = $('#form_hours').val();
				$('#form_hours').val(parseInt(hours)+1 || 0);
				return false;
			}
			
			if(mins != '') {
				mins = parseInt(mins) + 15;
			}else{
				$('#form_minutes').val(0);
				return false;
			}
			$('#form_minutes').val(mins);
		});
		
		$('#mins_down').click(function(){
			var mins = $('#form_minutes').val();
			
			if(mins == 0) {
				$('#form_minutes').val(45);
				var hours = $('#form_hours').val();
				if(hours <= 0 ){
					$('#form_hours').val(0);
					return false;
				}
				$('#form_hours').val(hours-1);
				return false;
			}
			if(mins != '') {
				mins = parseInt(mins) - 15;
			}else{
				$('#form_minutes').val(45);
			}
			
			$('#form_minutes').val(mins);
			
		});
		
		$('#log_hours').click(function(){
			if ($('#form_type').val() == '') {
				alert('Please select a Type of Hour');
				return false;
			}else if($('#form_employee').val() == '') {
				alert('Please select a employee');
				return false;
			}
		});
		
		

	})();
	
</script>
