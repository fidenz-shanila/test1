<h1>Top Earnings</h1>
<form action="" id="top_earning_filter" class="grid_filter">
    <table  class="filter_table">
	
	 <tr>
                <?php
                echo \Form::select('by_letter', '', array_combine(range('A', 'Z'), range('A', 'Z')), array('class' => 'filter_field'));
                ?>
        </tr>

        <tr class="sr">
	    <td>
                <label for="">Type</label>
                <?php echo \Form::select('type', '', array(), array('class' => 'filter_field', 'id' => 'filter_type', 'data-name' => 'filter_type')); ?>
            </td>
            <td>
                <label for="">Section</label>
                <?php echo \Form::select('owner', '', array(), array('class' => 'filter_field', 'id' => 'filter_section', 'data-name' => 'filter_section')); ?>
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
        
        

        <tr class="tr" >
            <td colspan="">
                <label>Based on :</label>
		<?php echo \Form::select('based', 'Org. Full name', array("Org. Full name" => "Org. Full name", "Org. Name" => "Org. Name"), array('class' => 'filter_field', 'id' => 'filter_based_on', 'data-name' => 'filter_based_on')); ?>
            </td>

            <td> 
                <label for="">Jobs Completed</label>
                <table>
                    <tr><td>FROM :<input type="text" data-name="filter_job_start_date" class="datepicker"></td><td>TO :<input type="text" data-name="job_end_date" class="datepicker"></td></tr>
                </table>
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
			<th>OR1_FullName</th>
			<th>OR1_InternalOrExternal</th>
			<th>TotalIncome</th>
			<th>NoJobs</th>
		</tr>
	</thead>
</table>

<script>

dt = $('.datatable').dataTable({
	    "bProcessing": true,
	    "aoColumns":[
		    {"sWidth": '200px', "mDataProp": "OR1_FullName"},
		    {"sWidth": '20px', "mDataProp": "OR1_InternalOrExternal"},
		    {"sWidth": '30px', "mDataProp": "TotalIncome"},
		    {"sWidth": '20px', "mDataProp": "NoJobs"}
	     ],
	    "bServerSide": true,
	    "sAjaxSource": "<?php echo \Uri::create('admins/earners/listing'); ?>",
	    "fnServerParams": function ( aoData ) {
		
		var df = $('.filter_field');
		
		$.each(df, function(index, val){
		    aoData.push({"name":$(this).data('name'), "value": $(this).val()});
		});
		
		$('.filter_field').on('change', function(){
		    dt.fnDraw();
		});
		    
		$.ajax({
		   url : "<?php echo \Uri::create('admins/earners/dropdown_listing'); ?>",
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
	   },
});

</script>   
    
