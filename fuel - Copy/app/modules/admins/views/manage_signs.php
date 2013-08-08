	
    <div id="manage-sinnatories">
    	
        <div id="content">
        	
            <div class="content">
            	
                <h1>MANAGE SIGNATORIES</h1>
                
                <div class="box_1">
		    
                    <div class="col-1">
                    	<h2>NMI SIGNATORIES<strong>( double click to remove )</strong></h2>
							<?php echo \Form::select('nmi', '', $nmi, array('class' => 'select-1 list', 'size' => '40', 'data-manage' => 'NMI')); ?>
                    </div>
                    <div class="col-2">
			
                    	<h2>AVAILABLE STAFF<strong>( double click to select )</strong></h2>
						
                        <input type="button" class="leftbtn" href="" />
						<?php echo \Form::select('staff', '', $staff, array('class' => 'select-1', 'size' => '40')); ?>
                        <input type="button" class="rightbtn" />

                    </div>
                    <div class="col-3">
                    	<h2>NATA SIGNATORIES<strong>( double click to remove )</strong></h2>
						<?php echo \Form::select('nata', '', $nata, array('class' => 'select-1 list', 'size' => '40', 'data-manage' => 'NATA')); ?>

                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
    
    <script type="text/javascript">
	(function(){
		
		
		
		var type = 'nmi';
		$('.col-1').css('border', '2px solid #000');
		
		$('.leftbtn').click(function(){
			type = 'nmi';
			$('.col-3').css('border', '0');
			$('.col-1').css('border', '2px solid #000');
		});
		
		$('.rightbtn').click(function(){
			type = 'nata';
			$('.col-1').css('border', '0');
			$('.col-3').css('border', '2px solid #000');
		});
		
		$('select.list').dblclick(function(){
			var iEM1_EmployeeID_pk = $(this).val();
			var dir = $(this).data('manage');
			
			$.ajax({
				url : "<?php echo \Uri::create('admins/manage_sign');?>",
				method : "POST",
				data : {'s_mode':dir, 'b_is_signatory':false, 'iEM1_EmployeeID_pk': iEM1_EmployeeID_pk },
			});
			
			$(this).find("option[value="+iEM1_EmployeeID_pk+"]").remove();
			
			
		});
		
		$('select[name=staff]').dblclick(function(){
			
			var iEM1_EmployeeID_pk = $(this).val();
			var iEM1_EmployeeID_pk_text = $('select[name=staff] option:selected').text();
			
			if (iEM1_EmployeeID_pk_text != 'select') {
				
				$.ajax({
					url : "<?php echo \Uri::create('admins/manage_sign');?>",
					method : "POST",
					data : {'s_mode':type, 'b_is_signatory':true, 'iEM1_EmployeeID_pk': iEM1_EmployeeID_pk },
				});
				
				$('select[name='+type+']').append('<option value='+iEM1_EmployeeID_pk+'>'+iEM1_EmployeeID_pk_text+'<option>');
			
				$('select[name='+type+']').html($('select[name='+type+'] option').sort(function (a, b) {
					return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
				}));
				
				$('select[name='+type+']').find("option[value='']").remove();
				
			}
		});
		
	}());
    </script>
    
    
