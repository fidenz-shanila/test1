<form action="" id="contacts_listing_filter_job" class="grid_filter" method="post">
    </br>
     <table height="50px" width="100%" style="border:2px solid #a1a1a1;" > 
        <tr><td>
    
         <table border="0" id="jobFilter1" class="mainForm">
         <tr class="">
            <td bgcolor="#E2C1A0" width="12%" style="border:1px solid #a1a1a1;">
                <label for="">PREFIX:</label>
                <select name="prefix" class="filter_field" id="m_prefix"></select>
                <?php echo \Helper_Form::clear_select('prefix',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#E2C1A0" width="15%" style="border:1px solid #a1a1a1;"> 
                <label for="">YEAR:</label>
                <select name="year" class="filter_field" id="m_year"></select>
                <?php echo \Helper_Form::clear_select('year',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
             <td bgcolor="#8080FF" width="23%" style="border:1px solid #a1a1a1;">
                <label for="">OWNER:</label>
                 <select name="organisation" class="filter_field" id="m_organisation"></select>
                <?php echo \Helper_Form::clear_select('organisation',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#D7AEFF" width="20%" style="border:1px solid #a1a1a1;">
                <label for="">TEST OFF.:</label>
                <?php echo \Helper_Form::list_employees2('test_officer');?>
                <?php echo \Helper_Form::clear_select('test_officer',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
       
            <td colspan=""  width="15%" bgcolor="#C7C78D">
                <label for="">SOURCE :</label>
                <select name="source" class="filter_field" id="m_source"></select>
                 <?php echo \Helper_Form::clear_select('source',array('style'=>'max-width:4%;')); ?>
            </td>

            
            <td  width="15%" align="right"> 
                 <div  class="">
       <input type="button" id="parent_search" class="btn spaced" style="font-weight:bold;color:red;"  value=" SEARCH"/>
        <input type="button" id="parent_search_clear" class="btn spaced " style="font-weight:bold;color:red;width:60%;display:none;"  value="CLEAR SEARCH"/>
        <?php echo '<input type="button"  href="../dashboard"    style="font-weight:bold;" class="btn spaced" value="CLOSE"/>';?>
            </div>
                
            </td>
        </tr>


    </table>
    </td>
        </tr>

<input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" /><input type="hidden" name="limitData" id="limitData" class="filter_field" value="200"/>
   <input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  />
    </table>

 

	
 

   
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
                       "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0, 1, 3, 5, 9,10] }],
			"sAjaxSource": "<?php echo \Uri::create('reports/reportmaster/listing_data'); ?>",
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
				 	url: "<?php echo \Uri::create('reports/reportmaster/dropdown_data'); ?>",
				 	type: "GET",
				 	dataType: 'json',
					data: filter,
					error : function(jqXHR, textStatus, errorThrown)
					{
						console.log(textStatus);
					},
					success: function(data){
					
						$('#m_prefix, #m_year, #m_organisation, #wdb_officer, #m_source').html('<option value=""></option>');
                                                 var sortArray1 = new Array();
                                                 var sortArray2 = new Array();
                                                 var i=0;
                                                 
						$.each(data, function(index, value){
                                                     
							$.each(data[index], function(key, val){
                                                            if(index=='year'){
                                                           
                                                            sortArray1[i]=val 
                                                            //alert(sortArray[i]);
                                                            i++;
                                                            }
                                                              if(index=='source'){
                                                         // val='ssss'
                                                         //alert(key)
                                                         if(key=='Old T&amp;C'){
                                                         //alert(key);
                                                         key='55555';
                                                         val='Old T&amp ;C';
                                                         }
                                                         
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
		
		$('.mainForm .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

		$('#advance_search').click(function(){
                    var FIELD_CRITERIA_1='no';
                        var FIELD_CRITERIA_2='no';
                        var FIELD_CRITERIA_3='no';
                        var checkValForMessage='no';
                    
                       if(($('*[name="field_crieteria_01"]').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_1='yes';
                            
                        }else{
                            if($('#criteria1St').val().length == 0){
                                 checkValForMessage='yes';
                                alert('Please fill in the \'criteria\' box.'  );
                            }else{
                                 FIELD_CRITERIA_1='yes';
                            }
                        }
                        
                            if(checkValForMessage!='yes'){
                        if(($('[name=field_crieteria_02]').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_2='yes';
                            
                        }else{
                            if($('#advanceField2').val().length == 0){
                                checkValForMessage='yes';
                                alert('Please fill the in \'field\' box.'  );
                            }else{
                               if($('#advanceEquality2').val().length == 0){
                                   checkValForMessage='yes';
                                alert('Please fill the in \'equality\' box.'  );
                                }else{
                                    if($('#criteria2Nd').val().length == 0){
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
                        if(($('#3rdDate_crieteria').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_3='yes';
                            
                        }else{
                            if($('#3rdDate_crieteria').val().length == 0){
                                alert('Please fill in the date \'field\' box.'  );
                            }else{
                                if($('#criteria3Rd').val().length == 0 && $('#criteria4Th').val().length == 0){
                                alert('Please fill in either the \'from date\' or \'to date\' box.'  );
                            }else{
                                FIELD_CRITERIA_3='yes';
                            }
                            }
                        }
                      } 
                       
                        
                    if(FIELD_CRITERIA_1=='yes' && FIELD_CRITERIA_2=='yes'&& FIELD_CRITERIA_3=='yes' ){
			
				dt.fnDraw(); 
                                $("#parent_search").css("display", "none");
                                   $("#parent_search_clear").show();
				
                            }
				
			
		});
                
                    $('#parent_search_clear').click(function(){

                                 $("#parent_search_clear").css("display", "none");
                                   $("#parent_search").show();
                                    $('#criteria1St').val('');
                                    $('#criteria2Nd').val('');
                                    $('#criteria3Rd').val('');
                                    $('#criteria4Th').val('');
                                    $("#3rdDate_crieteria").prop("selectedIndex",0);
                                    dt.fnDraw();
			
			
		});
                
                
		
		$('#search').colorbox({inline:true});	
                //invisible top lable 31/5/2013 sd
                $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
     
      
      
     $('#checkboxForIntelligent').click(function(){
            if($(this).is(':checked')){
               //alert($(this).val())
                $(this).attr('value','yes');
            }else{
                $(this).attr('value','no');
            }
        });
      
        $('#parent_search').click(function(){
            $('[name=field_crieteria_01]').prop("selectedIndex",1);
            $('[name=field]').prop("selectedIndex",3);
             $('[name=field_crieteria_02]').prop("selectedIndex",0);
               $('#form_equality').prop("selectedIndex",0);
              $('#advanceField2').prop("selectedIndex",0);
               $('#advanceEquality2').prop("selectedIndex",0);
                $('#criteria2Nd').attr('readonly','readonly');
                $('#3rdDate_crieteria').prop("selectedIndex",0);
                $('#criteria3Rd').attr('readonly','readonly');
                $('#criteria4Th').attr('readonly','readonly');
                $('*[name="Intelligent"]').attr('checked','checked');
                $('#checkBoxDiv').css("background-color",'#FD8181');
                $('#switch').text('ON');
                 $("#.advanceP p").css("color","#D9D3D3");
                 $('#criteria1St').val('');
                 $('#criteria2Nd').val('');
                 $('#criteria3Rd').val('');
                 $('#criteria4Th').val('');
                 $('#dateField').prop("selectedIndex",0);
                 
                 
            
          
        });
         $('#field_crieteria_02').change(function() {
            if($('#field_crieteria_02').val()=='N/A'){
                $(".advanceCriteria1P p").css("color","#D9D3D3");
            }else{
                 $(".advanceCriteria1P p").css("color","#000000");
        
            }
    });
    
     $('#3rdDate_crieteria').change(function() {
            if($('#3rdDate_crieteria').val()=='N/A'){
                $(".advanceCriteria1P2 p").css("color","#B8B8B8");
            }else{
                 $(".advanceCriteria1P2 p").css("color","#000000");
        
            }
    });
        



</script>
<script>
  $(function() {
    $( "#dialog-form" ).dialog({
        //closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      //position: [5000,900],
      height: 505,
      width: 750,
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
   // $(".ui-dialog-titlebar").removeClass('ui-widget-header');
   // $("#dialog-form").removeClass('ui-widget');
  $( "#closeNewWindow" ) .click(function() {
       parent.$('body').css('overflow','auto')
    $( "#dialog-form"  ).dialog( "close" );
 });
 
    $( "#parent_search" ).button().click(function() {
      // parent.$('body').css('overflow','hidden')
       //$("#dialog-form").dialog("option", "position", "center");
         $( "#dialog-form" ).dialog( "open" );
         parent.$('body').css('overflow','hidden');
        // $('.selector').dialog('option', 'position');
           //$("div").removeClass("ui-resizable-handle");
           //$('.selector').dialog({ position: 'top' });
             //$("div").removeClass("ui-resizable-handle");
           //parent.$('body').css('overflow','hidden');
           $("#header").scrollTop();
      });
     // $( "#dialog-form" ).draggable();
  });
    //$(function() {
    //$( "#dialog-form" ).draggable();
  //});
 // var position = $('.selector').dialog('option', 'position');
  </script>
  