<?php echo $form->open();?>

<div id="insertworkgroup">
    	
        <div class="content">
        	
            <h1>INSERT 'WORK GROUP'</h1>
            
            
            <div class="box-0">
            	<div class="c3">
                	
                    <div class="blk">
                    <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    	<tbody><tr>
                        	<td width="30%"><p>NMI Branch:</p></td>
                            <td><?php echo $form->build_field('branches'); ?><?php echo $form->build_field('xbranches'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Section:</p></td>
                            <td><?php echo $form->build_field('sections'); ?><?php echo $form->build_field('xsections'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Project:</p></td>
                            <td><?php echo $form->build_field('projects'); ?><?php echo $form->build_field('xprojects'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Area:</p></td>
                            <td><?php echo $form->build_field('area'); ?><?php echo $form->build_field('xarea'); ?></td>
                        </tr>
                        <tr bgcolor="#d9b7ff">
                        	<td><p>Test Officer:<input type="button" value="" class="button2"></p></td>
                            <td><?php echo \Helper_Form::list_employees('employees'); ?></td>
                        </tr>
                    </tbody></table>
                    </div>
                </div>
            </div>
             <?php echo $form->build_field('WDB_YearSeq_fk_ind'); ?>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><?php echo $form->build_field('submit'); ?></div>
                	<div class="blk"><input type="button" class="button2 cb iframe close" value="cancel/close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php echo $form->close();?>

<script type="text/javascript">
    
		$('#work_branches, #work_sections, #work_projects').bind('keyup change', function(){
				var wb = $(this);
			$.ajax({
				url: "<?php echo \Uri::create('quotes/w_drop_down'); ?>",
				type: "GET",
				dataType: 'json',
				data: wb,
				success: function(data){
				   $.each(data, function(dd_name, dd_options){
						$.each(dd_options, function(key, value){
							$('*[name='+dd_name+']').append('<option value="'+key+'">'+value+'</option>');
						});
				   });
				}
			});
			
		});
	
	
		$('select').on('change', function(){
				var value = $("option:selected", this).text();
				var hidden_class = $(this).data('id');
				$('.'+ hidden_class).val(value);
		});
		
		$('#form_submit').click(function(){
				if ($('.employee_select').val() == '') {
						alert('Please select an Employee');
						return false;
				}else{
						return true;
				}
		});


    
</script>