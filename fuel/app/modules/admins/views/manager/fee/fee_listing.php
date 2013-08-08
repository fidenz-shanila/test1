<h1>Fee Listing</h1>
<form action="" id="fee_listing" class="grid_filter">
    <table  class="filter_table">
	
	
        <tr class="sr">
	    <td>
                <label for="">Branch</label>
                <?php echo \Form::select('branch', '', array(), array('class' => 'filter_field', 'id' => 'filter_branch', 'data-name' => 'filter_type')); ?>
            </td>
            <td>
                <label for="">Section</label>
                <?php echo \Form::select('section', '', array(), array('class' => 'filter_field', 'id' => 'filter_section', 'data-name' => 'filter_section')); ?>
            </td>

        </tr>


        <tr class="sr">
            <td>
                <label for="">Project</label>
		<?php echo \Form::select('project', '', array(), array('class' => 'filter_field', 'id' => 'filter_project', 'data-name' => 'filter_project')); ?>
            </td>
            <td>
                <label for="">Area</label>
		<?php echo \Form::select('area', '', array(), array('class' => 'filter_field', 'id' => 'filter_area', 'data-name' => 'filter_area')); ?>
            </td>
        </tr>
        
    </table>

</form>

<form action="" class="" method="post">
    <div class="export_to_excel">
        <?php echo \Form::select('export_to_excel_limit', null, array('ALL' => 'ALL', 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 5000 => 5000, 10000 => 10000));?>
        <input type="submit" name="export_to_excel" class="spaced" value="Export to Excel" />
    </div>
</form>

<div class="actions">
    <button  href="#advance_search_modal" class="cb spaced inline">Search</button>
</div>

<table class="datatable">
	<thead>
		<tr>
			<th>FEE_Code</th>
			<th>Description</th>
			<th>Amount</th>
		</tr>
	</thead>
</table>

<script>
    
    
$(document).ready(function(){
    $.ajax({
	url : "<?php echo \Uri::create('admins/fees/dropdown_listing'); ?>",
	dataType : "json",
	type : "GET",
	success : function(data){
	    $.each(data, function(key, val){
		$.each(val, function(k, v){
		    $('#filter_'+key).append('<option value="'+k+'">'+v+'</option>');
		});
	    });
	},
     });
});

dt = $('.datatable').dataTable({
	    "bProcessing": true,
	    "aoColumns":[
		    {"sWidth": '20px', "mDataProp": "F_Code"},
		    {"sWidth": '200px', "mDataProp": "F_Description"},
		    {"sWidth": '30px', "mDataProp": "F_Fee"},
	     ],
	    "bServerSide": true,
	    "sAjaxSource": "<?php echo \Uri::create('admins/fees/listing'); ?>",
	    "fnServerParams": function ( aoData ) {
		
		var df = $('.filter_field');
		
		$.each(df, function(index, val){
		    aoData.push({"name":$(this).data('name'), "value": $(this).val()});
		});
		
		$('.filter_field').on('change', function(){
		    dt.fnDraw();
		});
	   },
});

</script>   
    
