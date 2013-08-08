<form action="" id="contacts_listing_filter_job" class="grid_filter" method="post">
    
     <table height="100px" width="100%" style="border:1px solid #a1a1a1;" > 
        <tr><td>
                 <?php echo Helper_Form::range_filter1(); ?>
    <table border="0" id="" class="filter_table">
       

        <tr class="sr">
            <td align="right">
               <label for="">BRANCH:</label>
                <select name="branch" class="filter_field" id="wdb_branch"></select>
                <?php echo \Helper_Form::clear_select('branch',array('style'=>'max-width:4%;')); ?>
            </td>
            <td align="left">
                <label for="">SECTION:</label>
                 <select name="section" class="filter_field" id="wdb_section"></select>
                <?php echo \Helper_Form::clear_select('section',array('style'=>'max-width:4%;')); ?>
            </td>
             

        </tr>

</table>
         <table border="0" id="" class="">
         <tr class="">
           
            <td bgcolor="#C0C0C0" width="25%" style="border:1px solid #a1a1a1;"> 
                <label for=""><u>STATUS:</u></label>
               <select name="status" class="filter_field" style="width:70%" id="wdb_status">
                   <option value="CURRENT" selected>CURRENT</option>   
               </select>

                <?php echo \Helper_Form::clear_select('status',array('style'=>'max-width:4%;','id'=>'statusClr')); ?>
            </td><td></td>
       
            <td colspan=""  width="35%" bgcolor="#B66CFF">
                <label>SITE:</label>
                <select name="site" class="filter_field" style="width:80%" id="a_type"></select>
                <?php echo \Helper_Form::clear_select('site',array('style'=>'max-width:4%;')); ?>
            </td>

            
            <td width="40%" align="right"> 
                 <div class="">
                       <button style="font-weight:bold;" class="cb iframe spaced cboxElement" <?php //echo $disabled;?> class="cb iframe button1" href="<?php echo \Uri::create('employees/new_employee'); ?>">New Employee</button>
        <input type="button" id="parent_search" class="btn spaced" style="font-weight:bold;color:red;width:20%;"  value=" SEARCH"/>
        <input type="button" id="parent_search_clear" class="btn spaced " style="font-weight:bold;color:red;width:30%;display:none;"  value="CLEAR SEARCH"/>
        <?php echo '<input type="button"  href="dashboard"    style="font-weight:bold;" class="btn spaced  " value="CLOSE"/>';?>
            </div>
                
            </td>
        </tr>


    </table>
    </td>
        </tr>


    </table>


                <?php 
                 $rangeSelecter=array("select");
                 $a=array_combine(range('A', 'Z'), range('A', 'Z'));
                 array_push($rangeSelecter,$a);
                echo \Form::select('by_letter', '', $rangeSelecter, array('class'=>'filter_field','style'=>'display:none')); ?>
     <input type="hidden" name="owner_type" id="hiddenOrgType" value=" " /><input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" /><input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  /><input type="hidden" name="limitData" id="limitData" class="filter_field" value="1001"/>
    
    
   
    

   
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
                       "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,2,3] } ],
			"sAjaxSource": "<?php echo \Uri::create('employees/listing_data'); ?>",
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
                                
                                
                               // var checkSite=0;
                                //$( "#statusClr" ) .click(function() {
                                 // checkSite=1;
                                  //alert(checkSite);
                                       // });

				$.ajax({
				 	url: "<?php echo \Uri::create('employees/dropdown_data'); ?>",
				 	type: "GET",
				 	dataType: 'json',
					data: filter,
					success: function(data){
						$('#a_type, #wdb_branch, #wdb_section, #wdb_status').html('<option value=""></option>');

						$.each(data, function(index, value){
							$.each(data[index], function(key, val){
                                                            
								$('*[name='+index+']').append('<option  value="'+key+'">'+val+'</option>');
                                                             
							});
							$('*[name='+index+']').val(filter['extra_search_'+$('*[name='+index+']').attr('name')]);
						});
                                              
					}
				});
	        },
		});
                // <option value="CURRENT" selected>CURRENT</option>
		
		$('.grid_filter .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

//		$('#advance_search').click(function(){
//			var ds = $('.advance_search .filter_field');
//			var do_run = 0;
//
//			$.each(ds, function(index, value){
//				if($(this).val().length === 0) {
//					alert('Please fill in '+$(this).data('label'));
//					do_run++;
//					return false;
//				}
//			});
//			if(do_run == 0){
//				dt.fnDraw(); //shouldn't be called if either one of the field is empty
//				//$.colorbox.close();
//			}
//			
//		});
		//$('#search').colorbox({inline:true});
                
                      //invisible top lable 06/8/2013 sd
      $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
      
      
       $('#parent_search_clear').click(function(){

                                 $("#parent_search_clear").css("display", "none");
                                   $("#parent_search").show();
//                                    $('#criteria1St').val('');
//                                    $('#advance_field_2').val('');
                                    $('#criteria1St').val('');
                                    $('#criteria2nd').val('');
                                    $("#field_crieteria_02").prop("selectedIndex",0);
                                    $("#advanceEquality2").prop("selectedIndex",0);
                                    $("#advance_field_2").prop("selectedIndex",0);
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
                                FIELD_CRITERIA_2='no'
                            }else{
                               if($('#2ndEq').val().length == 0){
                                   
                                alert('Please fill the in \'equality\' box.'  );
                                FIELD_CRITERIA_2='no'
                                }else{
                                    if($('#criteria2nd').val().length == 0){
                                    //  alert('ddd');
                                    alert('Please fill the in \'criteria\' box.'  );
                                    FIELD_CRITERIA_2='no'
                                    }else{
                                       // alert('sss');
                                    FIELD_CRITERIA_2='yes';   
                                     }  
                                }
                            }
                        }
                        //alert(FIELD_CRITERIA_2);
                         if( FIELD_CRITERIA_2=='yes' ){
			
				dt.fnDraw();
                                 $("#parent_search").css("display", "none");
                                
                                   $("#parent_search_clear").show();
                                  
				
                            
                         }
                        
                                
			
			
		});
                
                 //change colour when click button 6/8/2013 shanila Dilshan         
    function filterChangeColour(){
            document.getElementById("ColourChenger").style.backgroundColor="#eb0f19";
            
            
                }
                
                $('.range-filter').live('click', function(){
		var val = $(this).val(); 
		$('select[name=by_letter]').val(val).change();
                
	});
        
        function filterResetColour(){
            document.getElementById("ColourChenger").style.backgroundColor="";
            document.getElementById("btnReset").style.fontWeight = "";
    }
                
      
      
		
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
 
    $( "#parent_search" ).button().click(function() {
        $("table.advance_search #PField").css('color',"#B8B8B8");
          $("table.advance_search #PEquality").css('color','#B8B8B8');
           $("table.advance_search #PCriteria").css('color','#B8B8B8');
            $("#fieldOne").prop("selectedIndex",2);
            $("#field2Eq").prop("selectedIndex",0);
            $("#advance_field_2").prop("selectedIndex",0);
            $("#2ndEq").prop("selectedIndex",0);
            $("#criteria1St").val('');
            $("#criteria2nd").val('');
         $( "#dialog-form" ).dialog( "open" );
           $("div").removeClass("ui-resizable-handle");
           parent.$('body').css('overflow','hidden');
           $('form input').each(function(){
            //$('form :input:submit').attr('disabled','disabled');
      });
        });
           
  });
  </script>
  


