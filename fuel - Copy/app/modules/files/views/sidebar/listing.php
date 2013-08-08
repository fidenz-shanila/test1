
<form action="" id="contacts_listing_filter_job" class="grid_filter" method="post">
     <table height="100px" width="100%" style="border:1px solid #a1a1a1;" > 
        <tr><td>
    <table border="0" id="jobFilter" class="filter_table mainForm">
       

        <tr class="sr">
            <td>
                <label for="">BRANCH:</label>
               <select name="branch" class="filter_field" id="wdb_branch"></select>
                <?php echo \Helper_Form::clear_select('branch',array('style'=>'max-width:4%;')); ?>
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
         <table border="0" id="jobFilter1" class="mainForm">
         <tr class="">
            <td bgcolor="#8080FF" width="25%">
                <label for="">OWN.:</label>
                <select name="owner" class="filter_field" id="wdb_owner"></select>
                <?php echo \Helper_Form::clear_select('owner',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#FFFF80" width="13%" style="border:1px solid #a1a1a1;"> 
                 <label for="">YEAR:</label>
                <select name="year" class="filter_field" id="m_year"></select>
                <?php echo \Helper_Form::clear_select('year',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#D7AEFF" width="23%">
                <label for="">TEST OFF.:</label>
                <?php echo \Helper_Form::list_employees1('test_officer');?>
                <?php echo \Helper_Form::clear_select('test_officer',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
       
            <td colspan=""  width="15%" bgcolor="#5AADAD">
                <label>TYPE:</label>
                <select name="type" class="filter_field" id="a_type"></select>
                <?php echo \Helper_Form::clear_select('type',array('style'=>'max-width:4%;')); ?>
            </td>

            
            <td width="55%" align="right"> 
                 <div class="">
        <input type="button" id="" href="<?php echo \Uri::create('files/new_file'); ?>" class="btn spaced " style="font-weight:bold;width:30%;"  value="NEW FILE"/>
        <input type="button" id="search55" class="btn spaced " style="font-weight:bold;color:red;width:40%;"  value=" SEARCH"/>
        <input type="button" id="search_clear1" class="btn spaced " style="font-weight:bold;color:red;width:40%;display:none;"  value="CLEAR SEARCH"/>
        <?php echo '<input type="button"  href="dashboard"    style="font-weight:bold;" class="btn spaced " value="CLOSE"/>';?>
            </div>
                
            </td>
        </tr>


    </table>
    </td>
        </tr>


    </table>



   
    
<input type="hidden" name="owner_type" id="hiddenOrgType" value=" " /><input type="hidden" name="file_type" id="hiddenFileType" value=" " /><input type="hidden" name="optShowCatchAlls" id="hiddenOptShowCatchAlls" value=" " /><input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" /><input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  /><input type="hidden" name="limitData" id="limitData" class="filter_field" value="200"/> 
   
   

 

   
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
                      "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,5] } ],
			"sAjaxSource": "<?php echo \Uri::create('files/listing_data'); ?>",
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
				 	url: "<?php echo \Uri::create('files/dropdown_data'); ?>",
				 	type: "GET",
				 	dataType: 'json',
					data: filter,
					success: function(data){
						$('#a_type, #wdb_branch, #wdb_section, #wdb_project, #wdb_area, #wdb_owner, #m_year, #wdb_officer,#wdb_fileType,#wdb_ownerType').html('<option value=""></option>');
                                              var sortArray1 = new Array();
                                                // var sortArray2 = new Array();
                                                 var i=0;
						$.each(data, function(index, value){
                                                   
							$.each(data[index], function(key, val){
                                                            // alert(key);
                                                            if(index=='year'){
                                                           
                                                            sortArray1[i]=val 
                                                            //alert(sortArray[i]);
                                                            i++;
                                                            }
                                                    
                                                          if(index!='year'){
                                                         
								$('*[name='+index+']').append('<option  value="'+key+'">'+val+'</option>');
                                                          }
							});
							$('*[name='+index+']').val(filter['extra_search_'+$('*[name='+index+']').attr('name')]);
						});
                                                var sortNewArray1=sortArray1.sort(function(a,b){return b-a});
                                                //alert(i);
                                                var x;
                                                for(x=0;x<i;x++){
                                                   
                                                       
                                                                $('#m_year').append('<option value="'+sortNewArray1[x]+'">'+sortNewArray1[x]+'</option>');
                                                                $('#m_year').val(filter['extra_search_'+$('#m_year').attr('name')]);
                                                          
                                                       
                                                }
                                                
                                                
					}
				});
	        },
		});
		
		$('.mainForm .filter_field ').bind('keyup change', function(){
			dt.fnDraw();
		});
		
		$('#advance_search12').click(function(){
			 //var FIELD_CRITERIA_1='no';
                        var FIELD_CRITERIA_2='no';
                        
                        
                              
                        if(($('#field_crieteria_02').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_2='yes';
                           // alert('P.'  );
                        }else{
                           // alert('dd');
                            if($('#advance_field_2').val().length == 0){
                               
                                alert('Please fill the in \'field\' box.'  );
                            }else{
                               if($('#advanceEquality2').val().length == 0){
                                   
                                alert('Please fill the in \'equality\' box.'  );
                                }else{
                                    if($('#criteria2nd').val().length == 0){
                                      
                                    alert('Please fill the in \'criteria\' box.'  );
                                    }else{
                                    FIELD_CRITERIA_2='yes';   
                                     }  
                                }
                            }
                        }
                        
                         if( FIELD_CRITERIA_2=='yes' ){
			
				dt.fnDraw();
                                 $("#search55").css("display", "none");
                                
                                   $("#search_clear1").show();
                                  
				
                            
                         }
                        
                                
			
			
		});
                $('#search_clear1').click(function(){
			//var ds = $('.advance_search .filter_field');
			
                           // alert('ffff');
				//dt.fnDraw(); //shouldn't be called if either one of the field is empty
				//alert('ffff');
                                
                                 $("#search_clear1").css("display", "none");
                                
                                   $("#search55").show();
                                    $('#criteria1St').val('');
                                    $('#criteria2nd').val('');
                                    dt.fnDraw();
			
			
		});
                //$("div").removeClass("ui-resizable-handle");
                // $(".").css("display", "none");
                
          
     $('input[type="checkbox"]').click(function(){
            if($(this).is(':checked')){
                $(this).attr('value','yes');
            }else{
                $(this).attr('value','no');
            }
        });
            //invisible top lable 03/6/2013 sd
      $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
		
                
                
   $('#search55').click(function(){
            $('#fieldOne').prop("selectedIndex",2);
             $('#field_crieteria_02').prop("selectedIndex",0);
              $('#advance_field_2').prop("selectedIndex",0);
              $('#advance_field_2').attr("disabled","disabled");
               $('#advanceEquality2').prop("selectedIndex",0);
               $('#advanceEquality2').attr("disabled","disabled");
               $('#criteria2nd').val('');
               $('#criteria1St').val('');
                $('#criteria2nd').attr('readonly','readonly');
                $("#advanceCriteria p").css("color","#B8B8B8");
                $('#form_equality').prop("selectedIndex",0);
        });
        
        
        $('#field_crieteria_02').change(function() {
    if($('#field_crieteria_02').val()=='N/A'){
                $("#advanceCriteria p").css("color","#B8B8B8");
            }else{
                 $("#advanceCriteria p").css("color","#000000");
        
            }
    });
            
            
                
                
                
</script>
<script>
   
  $(function() {
    $( "#dialog-form" ).dialog({
       open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      height: 400,
      width: 610,
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
    
  $( "#closeNewWindow" ) .click(function() {
       parent.$('body').css('overflow','auto');
        $('input').removeAttr('disabled','disabled');
    $( "#dialog-form"  ).dialog( "close" );
 });
 
    $( "#search55" ).button().click(function() {
         $( "#dialog-form" ).dialog( "open" );
           $("div").removeClass("ui-resizable-handle");
           parent.$('body').css('overflow','hidden');
           $('form input').each(function(){
            //$('form :input:submit').attr('disabled','disabled');
      });
        });
           
  });
  
  </script>
  
  