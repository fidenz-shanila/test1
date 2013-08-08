
<form action="" method="POST" id="listing_filter" name="quotes_listing_filter" class="grid_filter">
    <table height="100px" width="100%" style="border:1px solid #a1a1a1;" > 
        <tr><td>
    <table border="0" id="quoteFilter" class="filter_table">
        <tr class="sr">
            <td>
                <label align="left" for="">BRANCH:</label>

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
     <table border="0" id="quoteFilter1" class="">
     <tr >
            <td bgcolor="#8185fc" width="25%" style="border:1px solid #a1a1a1;">
                <label for="">OWN.:</label>
                <select name="owner" class="filter_field" id="wdb_owner"></select>
                <?php echo \Helper_Form::clear_select('owner',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#FCDB77" width="15%" style="border:1px solid #a1a1a1;">
                <label for="">STATUS:</label>
                <select name="status" class="filter_field">
                    <option value="0"></option>
                    <option value="1" selected>ALL Live</option>
                    <option value="2">Live: on offer (current)</option>
                    <option value="3">Live: on offer (expired)</option>
                    <option value="4">Live: Ready for checking</option>
                    <option value="5">Live: Ready for sending</option>
                    <option value="6">All Closed</option>
                    <option value="7">Closed: Accepted</option>
                    <option value="8">Closed: Rejected</option>
                    <option value="9">Closed: Requoted</option>
                    <option value="10">Closed: Cancelled</option>
                    <option value="11">Nothing issued</option>
                    <option value="12">Quote form LOCKED</option>
                    <option value="13">Quote form UNLOCKED</option>
                    <option value="14">Wrong data</option>
                </select>
                <?php echo \Helper_Form::clear_select('status',array('style'=>'max-width:4%;')); ?>
                
            </td><td></td>
            <td bgcolor="#d7acfa" width="21%" style="border:1px solid #a1a1a1;">
                <label for="">TEST OFF.:</label>
                <?php echo \Helper_Form::list_employees1('test_officer');?>
                <?php echo \Helper_Form::clear_select('test_officer',array('style'=>'max-width:4%;')); ?>
            </td><td></td>
            <td bgcolor="#59b0b3" width="15%" style="border:1px solid #a1a1a1;" >
                <label>TYPE:</label>
                <select name="type" class="filter_field" id="a_type"></select>
                <?php echo \Helper_Form::clear_select('type',array('style'=>'max-width:4%;')); ?>
            </td>
            <td align="right">
                <div class="">
        <button id="insertQuote"  class=""><b>NEW QUOTE</b></button>   
         <input type="button" id="search" class="btn spaced" style="font-weight:bold;color:red;"  value=" SEARCH"/>
        <input type="button" id="search_clear" class="btn spaced " style="font-weight:bold;color:red;width:60%;display:none;"  value="CLEAR SEARCH"/>
       
        <?php echo '<input type="button"  href="dashboard"    style="font-weight:bold;" class="btn iframe spaced" value="CLOSE"/>';?>
</div>

            </td>
        </tr>


       

    </table>
                
            </td>
        </tr>
                </table>

  
    
    
    
    <input type="hidden" name="owner_type" id="hiddenOrgType" value="" /><input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" /><input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  /><input type="hidden" name="limitData" id="limitData" class="filter_field" value="200"/>
   <div id="searchFieldshidden"> <input type="text" name="scrh1" id="scrh1" value=" " /><input type="text" name="scrh2" id="scrh2" value=" " /> <input type="text" name="scrh3" id="scrh3" value=" " /><input type="texts" name="scrh4" id="scrh4" value=" " /></div>  
</form>
<input type="text" id="hid_org_id" style="display:none" value="">
<input type="text" id="hid_contact_id" style="display:none" value="">
<input type="text" id="org_name" style="display:none" value="">
<input type="text" id="org_contact" style="display:none" value="">
<input type="text" id="cb_file_title" style="display:none" value="">
<input type="text" id="cb_file_id" style="display:none" value="">


<div id="InsertQuote" title="frmInsertQuote"  style="display:none;overflow:hidden;background-color:#FEE69C;" >
    <iframe id="InsertQuoteIframe" width="100%" height="100%"  style="background-color:#FEE69C;overflow:hidden;border:none"></iframe>
</div>


<div id="InsertQuoteNextWendow" title="frmContactListing" height="500px"   style="display:none;background-color:#8FA5FA;overflow:hidden;" >
    <iframe id="InsertQuoteNextIF" width="100%" height="100%"  style="background-color:#8FA5FA;overflow:hidden;border:none;">
   
    </iframe>
</div>

<div id="tabOpen" title="frmmainForm" height=""   style="display:none;overflow:hidden;background-color:#FFFFFF;" >
    <iframe id="tabOpenIF" width="100%" height="100%"  style="overflow:hidden;background-color:#FFFFFF;border:none;">
   
    </iframe>
</div>
<div id="OpenFile" title="frmCbFileListing" height=""   style="display:none;overflow:hidden;background-color:#FFFF80;" >
    <iframe id="OpenFileIF" width="100%" height="100%"  style="overflow:hidden;background-color:#FFFF80;border:none;">
   
    </iframe>
</div>

<!--#module_top_menu {
    margin-top: 2px;
    min-width: 950px;
    padding: 6px;
    position: fixed;
    top: 40px;
    width: 99%;
    z-index: 98;
}-->
<script type="text/javascript">
	var srarchClrStatus=0;
        var abc=0;
	dt = $('.datatable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bFilter" : false,
                        "bAutoWidth": false,
                        "oLanguage": {
                        "sProcessing": "Please wait - loading..."
                        },
                        'iDisplayLength':-1,
                        //"bScrollInfinite": true,
                        //"bScrollCollapse": true,
                        //"sScrollY": "670px",
                        
                         "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0, 2 ] } ],
			"sAjaxSource": "<?php echo \Uri::create('quotes/listing_data'); ?>",
			"fnServerParams": function ( aoData ) {
				
				var df = $('.grid_filter .filter_field');
				var ds = $('.advance_search .filter_field ');
                                
				var filter = {};
				
				$.each(df, function(index, val){
					if($(this).val() !== null) {
						aoData.push( {"name": "extra_search_"+$(this).attr('name'), "value": $(this).val()} );
						filter['extra_search_'+$(this).attr('name')] = $(this).val();
					}
				});

				$.each(ds, function(index, val){
                                    //alert("advance_search_"+$(this).attr('name'));
                                
					if($(this).val() !== null) {
						aoData.push( {"name": "advance_search_"+$(this).attr('name'), "value": $(this).val()} );
					}
				});
				
				$.ajax({
					url: "<?php echo \Uri::create('quotes/dropdown_data'); ?>",
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
                                                           
                                                            
                                                            if(index=='owner'){
                                                            sortArray1[i]='"'+val.toLowerCase() +'$'+key +'"';
                                                            sortArray2[i]='"'+val +'$'+key +'"';
                                                            
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
	        }
		});
                
        $('#search_clear').click(function(){
                 srarchClrStatus=0;
                 abc=0;
                 
			//$('.advance_search .filter_field').val('');
			$('#search_clear, #search').toggle();
			dt.fnDraw();
		});
                
                $('#closeWendow').click(function(){
                 abc=1;
                 //alert(srarchClrStatus);
                 if(srarchClrStatus>1){
                 $('#search_clear, #search').toggle();
			 $('#criteriaTxt').val(''); 
                        $('#ASCriteriaQ_2').val('');
                        $('#dateFrom').val(''); 
                        $('#dateTo').val('');
                         $("#SelectFieldCriteria_3").prop("selectedIndex",0);
                 }else{
                     $('#criteriaTxt').val(''); 
                        $('#ASCriteriaQ_2').val('');
                        $('#dateFrom').val(''); 
                        $('#dateTo').val('');
                 }
		});
                
                $('#search').click(function(){
                 srarchClrStatus=1;
                 
			//$('.advance_search .filter_field').val('');
			
		});

		
		$('.grid_filter .filter_field').bind('keyup change', function(){
			dt.fnDraw();
		});

		$('#advance_search').click(function(){
                    
			var do_run = 0;
                        var FIELD_CRITERIA_1='no';
                        var FIELD_CRITERIA_2='no';
                        var FIELD_CRITERIA_3='no';
			
                        
                       
                      if($('#scrh1').val()!=$("#criteriaTxt").val()||$('#scrh2').val()!=$("#ASCriteriaQ_2").val()||$('#scrh3').val()!=$("#dateFrom").val()||$('#scrh4').val()!=$("#dateTo").val()){ 
                           srarchClrStatus=1;
                        $('#scrh1').val($("#criteriaTxt").val());
                        $('#scrh2').val($("#ASCriteriaQ_2").val());
                        $('#scrh3').val($("#dateFrom").val());
                        $('#scrh4').val($("#dateTo").val());
                      }else{
                        $('#scrh1').val($("#criteriaTxt").val());
                        $('#scrh2').val($("#ASCriteriaQ_2").val());
                        $('#scrh3').val($("#dateFrom").val());
                        $('#scrh4').val($("#dateTo").val());
                      }
                        
                        if(($('*[name="SelectFieldCriteria_One"]').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_1='yes';
                            
                        }else{
                            if($('#criteriaTxt').val().length == 0){
                                alert('Please fill in the \'criteria\' box.'  );
                            }else{
                                 FIELD_CRITERIA_1='yes';
                            }
                        }
                        
                        if(($('#SelectFieldCriteria_2').val() == 'N/A')){
                            //alert('dd');
                            FIELD_CRITERIA_2='yes';
                            
                        }else{
                            if($('#advanceField').val().length == 0){
                                alert('Please fill the in \'field\' box.'  );
                            }else{
                               if($('#advanceEquality').val().length == 0){
                                alert('Please fill the in \'equality\' box.'  );
                            }else{
                                if($('#ASCriteriaQ_2').val().length == 0){
                                alert('Please fill the in \'criteria\' box.'  );
                            }else{
                              FIELD_CRITERIA_2='yes';   
                            }  
                            }
                        }}
                        
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
                        
                        if(srarchClrStatus==1 ){
                            if(FIELD_CRITERIA_1=='yes' && FIELD_CRITERIA_2=='yes'&& FIELD_CRITERIA_3=='yes' ){
			
				dt.fnDraw(); 
			
                       
                            }
                             
                         srarchClrStatus ++;
                        }
                       
                        
		});
                
		$('table.advance_search .select').each(function(){
			$(this).change(function(){
				if(this.value == 'N/A'){
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).attr('disabled', 'disabled');
					});
                                      // alert("dd");
                                         $('#FieldCri2F').css("color",'#B8B8B8');
                                         $('#FieldCri2E').css("color",'#B8B8B8');
                                         $('#FieldCri2C').css("color",'#B8B8B8');
                                         //$('#aEquality').css("color",'#B8B8B8');
                                        //$('#aCriteria').css("color",'#B8B8B8');
				}else{
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).removeAttr('disabled');
					});
				}
			});
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
                                         
				}else{
					$('#FieldCri3F').css("color",'#000000');
                                         $('#FieldCri3E').css("color",'#000000');
                                         $('#FieldCri3C').css("color",'#000000');
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
                
                
        //$('#search').colorbox({inline:true});
		
		$('.leftside .checkbox').change(function(){
			if(this.checked){
				$('#search_for_quote .content .box-2 .leftside').css('background-color', '#FD8181');
				$('#search_for_quote .content .box-2 .leftside #switch').text('ON');
				
			}else{
				$('#search_for_quote .content .box-2 .leftside').css('background-color', '#FEE69C');
				$('#search_for_quote .content .box-2 .leftside #switch').text('OFF');
			}
		});
                
                
        function call_to_img(img_path){ 
            if(img_path=='')
                {
                  alert('NO IMAGE EXISTS');
                }else{
                 var clorbox_open = $.colorbox({href:img_path});  
                }

         }
	
        //invisible top lable 30/4/2013 sd
      $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
      $('#searchFieldshidden').css("display", "none");
      
      
    $('#search').click(function(){
        
       
        $('#FieldCri3F').css("color",'#B8B8B8');
        $('#FieldCri3E').css("color",'#B8B8B8');
        $('#FieldCri3C').css("color",'#B8B8B8');
        $('#FieldCri2F').css("color",'#B8B8B8');
        $('#FieldCri2E').css("color",'#B8B8B8');
        $('#FieldCri2C').css("color",'#B8B8B8');
        $('#advanceField').attr('disabled', 'disabled');
        $('#advanceEquality').attr('disabled', 'disabled');
        $('#dateEquality').attr('disabled', 'disabled');
        $('#ASCriteriaQ_2').attr('readonly','readonly');
        $('#dateFrom').attr('readonly','readonly');
        $('#dateTo').attr('readonly','readonly');
        $("#SelectFieldCriteria_One").prop("selectedIndex",1);
        $("#selectField").prop("selectedIndex",4);
        $("#SelectFieldCriteria_1").prop("selectedIndex",0);
        $("#SelectFieldCriteria_2").prop("selectedIndex",0);
        $("#SelectFieldCriteria_3").prop("selectedIndex",0);
        $("#advanceField").prop("selectedIndex",0);
        $("#advanceEquality").prop("selectedIndex",0);
        $("#dateEquality").prop("selectedIndex",0);
        $('#ASCriteriaQ_2').val('');
        $('#dateFrom').val(''); 
        $('#dateTo').val('');
        $('#checkBoxDiv').css("background-color",'#FD8181');
        $('*[name="Intelligent"]').attr('checked','checked');
        $("#advanceEquality_field_crieteria_01").removeAttr("disabled");
       $("#criteriaTxt").removeAttr("disabled");
       $('strong').text('ON');
       
    });
    
    
    
</script>
<script>
  $(function() {
    $( "#dialog-form" ).dialog({
        //closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
      autoOpen: false,
      //position: [5000,900],
      height: 510,
      width: 750,
      modal: true,
      resize:false,
      resizable: false,
      hide: 'puff',
        show: 'puff',
    });
   // $(".ui-dialog-titlebar").removeClass('ui-widget-header');
   // $("#dialog-form").removeClass('ui-widget');
  $( "#closeWendow" ) .click(function() {
       parent.$('body').css('overflow','auto')
    $( "#dialog-form"  ).dialog( "close" );
 });
 
    $( "#search" ).button().click(function() {
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
 
 
 
 
 
 
 
 
 
 
  
 
 $('#insertQuote').click(function(){
    //alert($('#insertUrl').val());
 //  var width = $(window).width();
  var height = $(window).height();
  parent.$('body').css('overflow','hidden');
   //width = width - 200;
                                    if(height>950){
                                       $('#InsertQuote').css('overflow','hidden'); 
                                    height = height-40;
                                    }
                                    
                                    
     $("#InsertQuote").dialog({
    // open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
    autoOpen: false,
    modal: true,
    width:600,
    height:height,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
$(".ui-dialog-titlebar-close").hide();
             $('#InsertQuoteIframe').attr('src','quotes/new_quote/?form=form');
          }
});                               
    $('#InsertQuote').dialog('open');
});
 
 function openNweTab(year_seq_pk_id){
 //alert(year_seq_pk_id);
 
    $("#tabOpen").dialog({
    // open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
    autoOpen: false,
    modal: true,
    width:1200,
    height:1000,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
    $(".ui-dialog-titlebar-close").hide();
             $('#tabOpenIF').attr('src','mainform/index/?tab=1&quote_id='+year_seq_pk_id+'&wind=wind');
          }
});
$('#tabOpen').dialog('open');
//alert('not completed this development');
 }
 function set_file_data_quote(){
  //$('#OpenFile').dialog('close');
  alert('dd');
//  $('#InsertQuote').dialog(alert( $('#txt_branch_name').val()));
  //alert( $('#txt_branch_name').val());
//  $('#txt_file_name').val(title);
//  $('#txt_file_title').val('ddd');
//$(this).find( '#InsertQuote' ).css('color', 'red');
//alert('d');
//  //window.opener.functioname();
// $("#txt_file_title",child.document).append( 'newP' );

 }
 
  </script>