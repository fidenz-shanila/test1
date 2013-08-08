
<form action="" id="contacts_listing_filter_job" class="grid_filter" method="post">
    </br>
     <table height="100px" width="100%" style="border:2px solid #a1a1a1;" > 
        <tr><td>
    <table border="0" id="jobFilter" class="filter_table">
       

        <tr class="sr">
            <td>
                <label for="">BRANCH:</label>
               <select name="branch" class="filter_field" id="wdb_branch"></select>
                <?php echo \Helper_Form::clear_select('branch',array('style'=>'width:1%;height:2px')); ?>
            </td>
            <td>
                <label for="">SECT:</label>
                <select name="section" class="filter_field" id="wdb_section"></select>
                <?php echo \Helper_Form::clear_select('section',array('style'=>'max-width:4%;')); ?>
            </td>
             <td>
                <label for="">PROJ:</label>
                <select name="project" class="filter_field" id="wdb_project"></select>
                <?php echo \Helper_Form::clear_select('project',array('style'=>'max-width:4%;')); ?>
            </td>
            <td>
                <label for="">AREA:</label>
                <select name="area" class="filter_field" id="wdb_area"></select>
                <?php echo \Helper_Form::clear_select('area',array('style'=>'max-width:4%;')); ?>
            </td>

        </tr>

</table>
         <table border="0" id="jobFilter1" class="">
         <tr class="">
            <td bgcolor="#8185fc" width="25%">
                <label for="">OWN.:</label>
                <select width="90%" name="owner" class="filter_field" id="wdb_owner"></select>
                <?php echo \Helper_Form::clear_select('owner',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#bac7de" width="15%" style="border:1px solid #a1a1a1;"> 
                <label for="">STATUS:</label>
               <select name="status" class="filter_field">
                   <option ></option>
                    <option value="All Live" selected>All Live</option>
                    <option value="Live: May arrive">Live: May arrive</option>
                    <option value="Live: Expected">Live: Expected</option>
                    <option value="Live: Received">Live: Received</option>
                    <option value="Live: Returned to store">Live: Returned to store</option>
                    <option value="ALL Closed">ALL Closed</option>
                    <option value="Closed: Despatched">Closed: Despatched</option>
                    <option value="Closed: Not despatched">Closed: Not despatched</option>
                    <option value="Closed: Site visit">Closed: Site visit</option>
                    <option value="Wrong data">Wrong data</option>
                </select>
                <?php echo \Helper_Form::clear_select('status',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#d7acfa" width="21%">
                <label for="">TEST OFF.:</label>
                <?php echo \Helper_Form::list_employees1('test_officer');?>
                <?php echo \Helper_Form::clear_select('test_officer',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
       
            <td colspan=""  width="15%" bgcolor="#59b0b3">
                <label>TYPE:</label>
                <select name="type" class="filter_field" id="a_type"></select>
                <?php echo \Helper_Form::clear_select('type',array('style'=>'max-width:4%;')); ?>
            </td>

            
            <td align="right"> 
                 <div class="">
        <input type="button" id="search1" class="btn spaced" style="font-weight:bold;color:red;width:40%;"  value=" SEARCH"/>
        <input type="button" id="search_clear" class="btn spaced " style="font-weight:bold;color:red;width:40%;"  value="CLEAR SEARCH"/>
        <?php echo '<input type="button"  href="dashboard"    style="font-weight:bold;" class="btn spaced " value="CLOSE"/>';?>
            </div>
                
            </td>
        </tr>


    </table>
    </td>
        </tr>


    </table>


     <input type="hidden" name="owner_type" id="hiddenOrgType" value=" " /><input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" /><input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  /><input type="hidden" name="limitData" id="limitData" class="filter_field" value="200"/>
    <div id="searchFieldshidden"> <input type="text" name="scrh1" id="scrh1" value=" " /><input type="text" name="scrh2" id="scrh2" value=" " /> <input type="text" name="scrh3" id="scrh3" value=" " /><input type="texts" name="scrh4" id="scrh4" value=" " /></div>
    
   
    

   
</form>
<script type="text/javascript">
	dt = $('.datatable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bFilter" : false,
                       "bAutoWidth": false,
                        "oLanguage": {
                        "sProcessing": "Please wait - loading..."
                        },
                       'iDisplayLength':-1,
                       "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0] } ],
			"sAjaxSource": "<?php echo \Uri::create('invoices/listing_data'); ?>",
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
				 	url: "<?php echo \Uri::create('invoices/dropdown_data'); ?>",
				 	type: "GET",
				 	dataType: 'json',
					data: filter,
					success: function(data){
						$('#a_type, #wdb_branch, #wdb_section, #wdb_project, #wdb_area, #wdb_owner, #wdb_officer').html('<option value=""></option>');
                                                var sortArray1 = new Array();
                                                 var sortArray2 = new Array(); 
                                                var i=0;
						$.each(data, function(index, value){
                                                   
							$.each(data[index], function(key, val){
                                                            // alert(key);
                                                            
                                                            if(index=='owner'){
                                                            sortArray1[i]='"'+val.toLowerCase() +'$'+key +'"';
                                                            sortArray2[i]='"'+val +'$'+key +'"';
                                                            //alert(sortArray[i]);
                                                            i++;
                                                            }
                                                            if(index!='owner'){
                                                   
								$('*[name='+index+']').append('<option  value="'+key+'">'+val+'</option>');
                                                            }
							});
							$('*[name='+index+']').val(filter['extra_search_'+$('*[name='+index+']').attr('name')]);
						});
                                                var sortNewArray1=sortArray1.sort();
                                                //alert(sortNewArray)
                                                var x,y;
                                                for(x=0;x<i;x++){
                                                    var valNew=(sortNewArray1[x].split('$')[0]).slice(1);
                                                    var keyNew=(sortNewArray1[x].split('$')[1]).slice(0,-1);
                                                    
                                                        for(y=0;y<i;y++){
                                                            var valNew1=(sortArray2[y].split('$')[0]).slice(1);
                                                            var keyNew1=(sortArray2[y].split('$')[1]).slice(0,-1);
                                                            if(keyNew==keyNew1){
                                                                //alert(valNew1);
                                                                $('#wdb_owner').append('<option value="'+keyNew1+'">'+valNew1+'</option>');
                                                                $('#wdb_owner').val(filter['extra_search_'+$('#wdb_owner').attr('name')]);
                                                            }
                                                        }
                                                    
                                                    
                                                }
                                                
					}
				});
	        },
		});
		
		$('.grid_filter .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

		$('#advance_search').click(function(){
			var ds = $('.advance_search .filter_field');
			var do_run = 0;

			$.each(ds, function(index, value){ 
				if($(this).val().length === 0) {
					alert('Please fill in '+$(this).data('label'));
					do_run++;
					return false;
				}
			});
			if(do_run == 0)
				dt.fnDraw(); 
		});
                
       // $('#search1').colorbox({inline:true});
		
		$('table.advance_search .select').each(function(){
			$(this).change(function(){
				if(this.value == 'N/A'){
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).attr('disabled', 'disabled');
					});
				}else{
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).removeAttr('disabled');
					});
				}
			});
		});
		
		$('table.advance_search .select').each(function(){
			if(this.value == 'N/A'){
				$(this).parent().parent().siblings().find('.filter_field').each(function(){
					$(this).attr('disabled', 'disabled');
				});
			}
		});
		
		$('.leftside .checkbox').change(function(){
			if(this.checked){
				$('.leftside').css('background-color', '#FD8181');
				$('.leftside #switch').text('ON');
				
			}else{
				$('.leftside').css('background-color', '#fff');
				$('.leftside #switch').text('OFF');
			}
		});
                 $('#search_clear').click(function(){
                 srarchClrStatus=0;
			//$('.advance_search .filter_field').val('');
			$('#search_clear, #search1').toggle();
			dt.fnDraw();
		});
                
                $('#search1').click(function(){
                 srarchClrStatus=1;
			//$('.advance_search .filter_field').val('');
			
		});
                

		
		$('.grid_filter .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

		$('#advance_search12').click(function(){
                    
			var do_run = 0;
                        var FIELD_CRITERIA_1='no';
                        var FIELD_CRITERIA_2='no';
                        var FIELD_CRITERIA_3='no';
                        var checkValForMessage='no';
			
                        if($('#scrh1').val()!=$("#criteriaTxt").val()||$('#scrh2').val()!=$("#ASCriteriaJ_2").val()||$('#scrh3').val()!=$("#dateFrom").val()||$('#scrh4').val()!=$("#dateTo").val()){ 
                           srarchClrStatus=1;
                        $('#scrh1').val($("#criteriaTxt").val());
                        $('#scrh2').val($("#ASCriteriaJ_2").val());
                        $('#scrh3').val($("#dateFrom").val());
                        $('#scrh4').val($("#dateTo").val());
                      }else{
                        $('#scrh1').val($("#criteriaTxt").val());
                        $('#scrh2').val($("#ASCriteriaJ_2").val());
                        $('#scrh3').val($("#dateFrom").val());
                        $('#scrh4').val($("#dateTo").val());
                      }
                        
                        
                        if(($('*[name="field_crieteria_01"]').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_1='yes';
                            
                        }else{
                            if($('#criteriaTxt').val().length == 0){
                                 checkValForMessage='yes';
                                alert('Please fill in the \'criteria\' box.'  );
                            }else{
                                 FIELD_CRITERIA_1='yes';
                            }
                        }
                        
                      if(checkValForMessage!='yes'){
                        if(($('#SelectFieldCriteria_2').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_2='yes';
                            
                        }else{
                            if($('#advanceField').val().length == 0){
                                checkValForMessage='yes';
                                alert('Please fill the in \'field\' box.'  );
                            }else{
                               if($('#advanceEquality').val().length == 0){
                                   checkValForMessage='yes';
                                alert('Please fill the in \'equality\' box.'  );
                                }else{
                                    if($('#ASCriteriaJ_2').val().length == 0){
                                      checkValForMessage='yes';
                                    alert('Please fill the in \'criteria\' box.'  );
                                    }else{
                                    FIELD_CRITERIA_2='yes';   
                                     }  
                                }
                            }
                        }
                        }
                        
                      if(checkValForMessage!='yes'){
                        if(($('#SelectFieldCriteria_3').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_3='yes';
                            
                        }else{
                            if($('#dateEquality').val().length == 0){
                                alert('Please fill in the date \'field\' box.'  );
                            }else{
                                if($('#dateFrom').val().length == 0 && $('#dateTo').val().length == 0){
                                alert('Please fill in either the \'from date\' or \'to date\' box.'  );
                            }else{
                                FIELD_CRITERIA_3='yes';
                            }
                            }
                        }
                      } 
                       
                        if(srarchClrStatus==1){
                            if(FIELD_CRITERIA_1=='yes' && FIELD_CRITERIA_2=='yes'&& FIELD_CRITERIA_3=='yes' ){
			
				dt.fnDraw(); 
				
                            }
                        srarchClrStatus++;
                        }
                        
		});
                
                
                 $('#closeWendow').click(function(){
                 abc=1;
                  if(srarchClrStatus>1){
                 $('#search_clear, #search1').toggle();
			 $('#criteriaTxt').val(''); 
                        $('#ASCriteriaJ_2').val('');
                        $('#dateFrom').val(''); 
                        $('#dateTo').val('');
                         $("#SelectFieldCriteria_3").prop("selectedIndex",0);
                 }else{
                     $('#criteriaTxt').val(''); 
                        $('#ASCriteriaJ_2').val('');
                        $('#dateFrom').val(''); 
                        $('#dateTo').val('');
                 }
                
		});
                 $('#search1').click(function(){
        
        $('#FieldCri3F').css("color",'#B8B8B8');
        $('#FieldCri3E').css("color",'#B8B8B8');
        $('#FieldCri3C').css("color",'#B8B8B8');
        $('#FieldCri2F').css("color",'#B8B8B8');
        $('#FieldCri2E').css("color",'#B8B8B8');
        $('#FieldCri2C').css("color",'#B8B8B8');
        //$('#advanceField').attr('disabled');
        //$('#advanceEquality').attr('readonly');
        $('#advanceField').attr('disabled', 'disabled');
        $('#advanceEquality').attr('disabled', 'disabled');
        $('#dateEquality').attr('disabled', 'disabled');
        //alert('dssfds');
        $('#ASCriteriaJ_2').attr('readonly','readonly');
        //$('#dateFrom').attr('readonly','readonly');
        //$('#dateTo').attr('readonly','readonly');
        $('*[name="field_crieteria_01"]').prop("selectedIndex",1);
        //$("#SelectFieldCriteria_1").prop("selectedIndex",1);
        $("#selectField").prop("selectedIndex",12);
        $("#advanceEquality_field_crieteria_01").prop("selectedIndex",0);
        $("#SelectFieldCriteria_1").prop("selectedIndex",0);
        $("#SelectFieldCriteria_2").prop("selectedIndex",0);
        $("#advanceField").prop("selectedIndex",0);
        $("#advanceEquality").prop("selectedIndex",0);
        $("#dateEquality").prop("selectedIndex",0);
        $("#SelectFieldCriteria_3").prop("selectedIndex",0);
         $('#criteriaTxt').val(''); 
      $('#ASCriteriaJ_2').val('');
      $('#dateFrom').val(''); 
      $('#dateTo').val('');
      $('#dateFrom').attr('disabled', 'disabled');
      $('#dateTo').attr('disabled', 'disabled');
      $('#dateFrom').attr('readonly','readonly');
      $('#dateTo').attr('readonly','readonly');
      $('#checkBoxDiv').css("background-color",'#FD8181');
      $('*[name="Intelligent"]').attr('checked','checked');
       $("#selectField").removeAttr("disabled");
       $("#advanceEquality_field_crieteria_01").removeAttr("disabled");
       $("#criteriaTxt").removeAttr("disabled");
      $('strong').text('ON');
      
       
    });
    
    $('table.advance_search #SelectFieldCriteria_2').each(function(){
			$(this).change(function(){
				if(this.value == 'N/A'){
					
                                      
                                         $('#FieldCri2F').css("color",'#B8B8B8');
                                         $('#FieldCri2E').css("color",'#B8B8B8');
                                         $('#FieldCri2C').css("color",'#B8B8B8');
                                         //$('#aEquality').css("color",'#B8B8B8');
                                        //$('#aCriteria').css("color",'#B8B8B8');
				}else{
					$('#FieldCri2F').css("color",'#000000');
                                         $('#FieldCri2E').css("color",'#000000');
                                         $('#FieldCri2C').css("color",'#000000');
				}
			});
		});
                
                $('table.advance_search #SelectFieldCriteria_3').each(function(){
			$(this).change(function(){
				if(this.value == 'N/A'){
					
                                       
                                         $('#FieldCri3F').css("color",'#B8B8B8');
                                         $('#FieldCri3E').css("color",'#B8B8B8');
                                         $('#FieldCri3C').css("color",'#B8B8B8');
                                         //$('#aEquality').css("color",'#B8B8B8');
                                        //$('#aCriteria').css("color",'#B8B8B8');
				}else{
					$('#FieldCri3F').css("color",'#000000');
                                         $('#FieldCri3E').css("color",'#000000');
                                         $('#FieldCri3C').css("color",'#000000');
				}
			});
		});
		
		//$('#search1').colorbox({inline:true});


  
                //invisible top lable 19/5/2013 sd
      $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
      $('#searchFieldshidden').css("display", "none");
      
</script>

<script>
   
  $(function() {
    $( "#dialog-form" ).dialog({
       open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      height: 510,
      width: 780,
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
    
  $( "#closeWendow" ) .click(function() {
       parent.$('body').css('overflow','auto');
        $('input').removeAttr('disabled','disabled');
    $( "#dialog-form"  ).dialog( "close" );
 });
 
    $( "#search1" ).button().click(function() {
         $( "#dialog-form" ).dialog( "open" );
           $("div").removeClass("ui-resizable-handle");
           parent.$('body').css('overflow','hidden');
          
        });
           
  });
  
  </script>
  