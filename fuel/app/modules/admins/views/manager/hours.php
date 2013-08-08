<h1>Hour Analysis</h1>
<form action="" id="hour_analysis" class="grid_filter">
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
	
	<tr class="sr">
            <td>
                <label for="">Status</label>
		<?php echo \Form::select('status', '', array("Hours today" => "Hours today", "Hours yesterday" => "Hours yesterday", "Hours over last 7 days" => "Hours over last 7 days", "Hours this month" => "Hours this month", "Hours over last 3 months" => "Hours over last 3 months", "Hours over last 6 months" => "Hours over last 6 months", "hours over last 12 months" => "hours over last 12 months", "Hours this year" => "Hours this year", "Total hours" => "Total hours"), array('class' => 'filter_field', 'id' => 'filter_status', 'data-name' => 'filter_status')); ?>
            </td>
	    <td>
                <label for="">Test Officer</label>
		<?php echo \Form::select('officer', '', array(), array('class' => 'filter_field', 'id' => 'filter_officer', 'data-name' => 'filter_officer')); ?>
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



<table class="datatable">
	<thead>
		<tr>
			<th>Employee</th>
			<th>Hours</th>
		</tr>
	</thead>
</table>

<!-- TODO, sum of hours-->

<script>
    
 $(document).ready(function(){
    $.ajax({
	    url : "<?php echo \Uri::create('admins/hours/dropdown_listing'); ?>",
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
		    {"sWidth": '50px', "mDataProp": "EM1_Lname_ind"},
		    {"sWidth": '50px', "mDataProp": "SumOfHours"},
	     ],
	    "bServerSide": true,
	    "sAjaxSource": "<?php echo \Uri::create('admins/hours/listing'); ?>",
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
    
