<script language="javascript">
	dt = $('.datatable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bFilter" : false,
			"aoColumnDefs": [ 
		      { "bSortable": false, "aTargets": [ 0, 3, 4 ] }
		    ],
			"sAjaxSource": "<?php echo \Uri::create('contacts/listing_data?is_selectable=true'); ?>",
			"fnServerParams": function ( aoData ) {
				
				var df = $('.grid_filter .filter_field');
				var ds = $('.advance_search .filter_field');
				
				var filter = {};

				$.each(df, function(index, val){

					if($(this).val() !== null) {
						aoData.push( {"name": "extra_search_"+$(this).attr('name'), "value": $(this).val()} );
						filter['extra_search_'+$(this).attr('name')] = $(this).val();
					}
	
				});

				$.each(ds, function(index, val){
					
					if($(this).val() !== null) {
						aoData.push( {"name": "advance_search_"+$(this).attr('name'), "value": $(this).val()} );
					}

				});

				$.ajax({
				 	url: "<?php echo \Uri::create('contacts/dropdown_data'); ?>",
				 	type: "GET",
				 	dataType: 'json',
					data: filter,
					success: function(data){
						$('#a_type, #wdb_branch, #wdb_section, #wdb_project, #wdb_area').html('<option value="">Select</option>');

						$.each(data, function(index, value){
							$.each(data[index], function(key, val){
								$('#'+index).append('<option value="'+key+'">'+val+'</option>');
							});
							$('#'+index).val(filter['extra_search_'+$('#'+index).attr('name')]);
						});

					}
				});
	        }
		});
		
		$('.grid_filter .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

		$('#search_clear').click(function(){
			$('.advance_search .filter_field').val('');
			$('#search_clear, #search').toggle();
			dt.fnDraw();
		});

		$('#advance_search').click(function(){

			var ds = $('.advance_search .filter_field.basic_search');
			var das = $('.advance_search .filter_field.advance_search');

			var do_run = 0;

			$.each(ds, function(index, value){ 
				if($(this).val().length === 0) {
					alert('Please fill in '+$(this).data('label'));
					do_run++;
					return false;
				}
			});

			if($('*[name="advance[add_criteria]"]').val() != 'N/A') {
				$.each(das, function(index, value){ //this loop checks for series of fields
					if($(this).val().length === 0) {
						alert('Please fill in '+$(this).data('label'));
						do_run++;
						return false;
					}
				});
			}

			if(do_run == 0) {
				dt.fnDraw();
				$('#search_clear, #search').toggle();
				$.colorbox.close();
			}

		});
</script>

<div style="background:#FFF; width:94%; padding:2%; margin:auto;">

    <form action="" id="contacts_listing_filter" class="grid_filter">
        <table  class="filter_table">
            <tr>
                <td>
                    <label>Org. Type</label>
                    <?php echo \Helper_Form::org_type('org_type', '', array('class'=>'filter_field')); ?>
                </td>
                <td>
                    <label for="">By Letter</label>
                    <?php
                        echo \Form::select('by_letter', '', array_combine(range('A', 'Z'), range('A', 'Z')), array('class'=>'filter_field')); 
                    ?>
                </td>
            </tr>
    
            <tr class="sr">
                <td>
                    <label for="">Branch</label>
                    <select name="branch" class="filter_field" id="wdb_branch"></select>
                </td>
                <td>
                    <label for="">Section</label>
                    <select name="section" class="filter_field" id="wdb_section"></select>
                </td>
    
            </tr>
    
    
            <tr class="sr">
                <td>
                    <label for="">Project</label>
                    <select name="project" class="filter_field" id="wdb_project"></select>
                </td>
                <td>
                    <label for="">Area</label>
                    <select name="area" class="filter_field" id="wdb_area"></select>
                </td>
            </tr>
    
            <tr class="tr" >
                <td colspan="">
                    <label>Type:</label>
                    <select name="type" class="filter_field" id="a_type"></select>
                </td>
    
                <td> 
                    <label for="">Status</label>
                    <select name="status" class="filter_field">
                        <option value="1">Current Contacts &amp; Organizations</option>
                        <option value="3">Obsolete Organizations</option>
                        <option value="2">Obsolete Contacts</option>
                        <option value="4">All Contacts &amp; Organizations</option>
                    </select>
                </td>
            </tr>
    
            
        </table>
    
    </form>
    
    <form action="" method="post" class="">
        <table class="category_search grid_filter filter_table" width="100%">
                <tr>
                    <td width="50%" class="clr_contact_category">
                        <label for="">Contact Category</label>
                        <?php echo \Form::select('contact_cat', '', $contact_cats, array('class'=>'filter_field')); ?>
                    </td>
                    <td width="50%" class="clr_org_category">
                        <label for="">Organization Category</label>
                        <?php echo \Form::select('org_cat', '', $org_cats, array('class'=>'filter_field')); ?>
                    </td>
                </tr>
    
        </table>
        <div class="clear"></div>
    
    </form>
    
	<table class="datatable">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Organization</th>
                <th>Phone</th>
                <th>Mobile</th>
            </tr>
        </thead>
    </table>
    <div style="clear:both; height:15px;"></div>
    <input type="button" class="button1" value="Cancel" onclick="javascript:popup_close();" />
</div>

<!-- cb inline modals -->
<div style="display:none;">
	<div id="advance_search_modal" class="clr_org" style="height:135px;width:700px;">
	    <table class="advance_search" width="100%">
	        <tr>
	            <td>
	                <label for="">Field</label>
	                <select class="filter_field basic_search" data-label="Search Field" name="field" id="">
	                    <option value="">Select</option>
	                    <option value="Country">Country</option>
	                    <option value="First name">First name</option>
	                    <option value="Last name">Last name</option>
	                    <option value="Org. name">Org. name</option>
	                    <option value="Org. web address">Org. web address</option>
	                    <option value="Position">Position</option>
	                </select>
	            </td>
	            <td>
	                <label for="">Equality</label>
	                <?php echo \Helper_Form::seach_criteria('equality', '', array('class'=>'filter_field basic_search', 'data-label' => 'Search Equality')); ?>
	            </td> 
	            <td>
	                <label for="">Critieria</label>
	                <input class="filter_field basic_search" type="" data-label="Search Criteria" name="criteria" />
	            </td>
	        </tr>

	        <tr>
	            <td colspan="2"> 
	                <label for="">Additional Criteria</label>
	                <select class="filter_field" name="advance[add_criteria]" id="">
	                    <option value="N/A">N/A</option>
	                    <option value="AND">AND</option>
	                    <option value="OR">OR</option>
	                </select>
	            </td>
	        </tr>
	        
	        <tr>
	            <td>
	                <label for="">Field</label>
	                <?php
	                    $opts = array('Country', 'First name', 'Last name', 'Org. name', 'Org. web address', 'Position');
	                    echo \Form::select('advance[field]', '', array_combine($opts, $opts), array('class'=>'filter_field advance_search', 'data-label' => 'Search Field 2'));
	                ?>
	            </td>
	            <td>
	                <label for="">Equality</label>
	                <?php echo \Helper_Form::seach_criteria('advance[equality]', '', array('class'=>'filter_field advance_search', 'data-label' => 'Search Equality 2')); ?>
	            </td> 
	            <td>
	                <label for="">Critieria</label>
	                <input type="text" class="filter_field advance_search" name="advance[criteria]" data-label="Search Criteria 2" />
	            </td>
	        </tr>

	        <tr>
	            <td></td>
	            <td></td>
	            <td>
	                <input type="button" id="advance_search" value="Advance Search" />
	            </td>
	        </tr>
               
	    </table>
	</div>
</div>	
