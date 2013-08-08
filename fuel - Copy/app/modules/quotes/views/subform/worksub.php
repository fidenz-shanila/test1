<?php
/**
 * Same as main worklog area, but goes in header.
 */
?>
<div id="worklogsub">
	<div class="entries">
		<?php
		
		foreach($work_log as $entry):
		extract($entry);
		?>
		<div class="worklog">
			<div class="c1">
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	        	<tbody><tr>
	            	<td><h2><?php echo $WDB_WorkGroupNumberString; ?></h2></td>
	            </tr>
	        </tbody></table>
	    </div>
	    <div class="c2">
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	        	<tbody><tr>
	            	<td><p>sect:</p></td>
	                <td align="center"><input type="text" value="<?php echo $WDB_S_Name; ?>" readonly class="textbox-1"></td>
	            </tr>
	            <tr>
	            	<td><p>proj:</p></td>
	                <td align="center"><input type="text" value="<?php echo $WDB_P_Name; ?>" readonly class="textbox-1"></td>
	            </tr>
	            <tr>
	            	<td><p>area:</p></td>
	                <td align="center"><input type="text" value="<?php echo $WDB_A_Name; ?>" readonly class="textbox-1"></td>
	            </tr>
	        </tbody></table>
	    </div>
	    <div class="c3">
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	        	<tbody><tr>
	            	<td width="30%"><p>group hours:</p></td>
	                <td align="center"><input type="text" class="textbox-1" value="<?php echo $WDB_HoursInHhMm; ?>" readonly></td>
	                <td><span>(hh:mm)</span></td>
	                <td><input type="button" href="<?php echo \Uri::create('quotes/hours_log?quote_id='.\Input::get('quote_id').'&WDB_P_Name='.urlencode($WDB_P_Name).'&WDB_WorkDoneBy_pk='.urlencode($WDB_WorkDoneBy_pk)); ?>"  class="cb iframe" value="Hours log"/></td>
			
	            </tr>
	        </tbody></table>
	    </div>
	    <div class="c4">
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	        	<tbody><tr>
	            	<td width="20%"><p>test off:</p></td>
	                <td align="center"><input id="employee_sel" type="text" value="<?php echo $Employee; ?>" readonly class="textbox-1"></td><?php //echo \Helper_Form::list_employees('WDB_TestOfficerEmployeeID', $WDB_TestOfficerEmployeeID, array('class'=>'select-1 employees')); ?>
	                <td><input type="button" class="cb iframe button1" value="..." href="<?php echo \Uri::create('employees/edit/'.$WDB_TestOfficerEmployeeID) ?>?form=form&"></td>
	                <!--<td><input type="button" class="button1 cb" value="change" href="#employee_select"></td>-->
					<!--<td><button class="cb inline" href="#employee_select">change</button></td>-->
                                        <td><input type="button" class="cb iframe" value="change" href=" <?php echo \Uri::create('quotes/load_test_officers/?WDB_TestOfficerEmployeeID=' . $WDB_TestOfficerEmployeeID . '&WDB_P_Name=' . $WDB_P_Name.'&WDB_WorkDoneBy_pk='.$WDB_WorkDoneBy_pk);?>"></td>
	            </tr>
	        </tbody></table>
	    </div>	
		</div><!-- entry -->
	<?php endforeach; ?>
	</div><!-- entries container -->
	</div><!-- worklog sub -->
	
	<div style="display: none;">
		<div id="employee_select" class="clr_org"  style="width: 20%; height: 50px;">
				<?php echo \Form::select('employees', '', $employees ); ?>
				<button class="cb close">close</button>
		</div>
		
	</div>
	
	
	
<script type="text/javascript">
	$("#worklogsub").carousel({ direction: "vertical", nextBtnInsert: 'insertBefore' });
	
	$('#edit').click(function(){
		var emp_id = $('select[name=WDB_TestOfficerEmployeeID]').val();
		alert(APP.base_url + '/employees/edit/' + emp_id + '/?modal=true');
		$('#edit').attr('href', APP.base_url+'employees/edit/'+emp_id+'/?modal=true');
		return true;
	});
	
	$('#employee_select button').click(function(){
				var emp = $('#employee_select option:selected').text();
				if( $('#employee_select option:selected').val() == '') {
						alert('Please select an Employee');
						return false;
				}
				$('#employee_sel').val(emp);
		});
	
	
</script>