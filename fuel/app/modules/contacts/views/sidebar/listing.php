
<style>
.Invisibal
{
display:none;
}
</style>
<form action="" method="post" id="listing_filter" name="contacts_listing_filter" class="grid_filter">
     <?php echo Helper_Form::range_filter(); ?> 
    </br><table  class="filter_table"  border="0" >
        <tr>
            <td>
                
            </td><td>
                
                <?php 
                 $rangeSelecter=array("select");
                 $a=array_combine(range('A', 'Z'), range('A', 'Z'));
                 array_push($rangeSelecter,$a);
                echo \Form::select('by_letter', '', $rangeSelecter, array('class'=>'filter_field Invisibal')); ?>
            </td>
            
        </tr>

        <tr class="sr">
            <td  align="right">
                <label for="">BRANCH:</label>
                <select name="branch" class="filter_field" id="wdb_branch"></select>
                <?php echo \Helper_Form::clear_select('branch'); ?>
            </td>
            <td align="left">
                <label for="">SECTION:</label>
                <select name="section" class="filter_field" id="wdb_section"></select>
                <?php echo \Helper_Form::clear_select('section'); ?>
            </td>

        </tr>


        <tr class="sr">
            <td align="right">
                <label for="">PROJECT:</label>
                <select name="project" class="filter_field" id="wdb_project"></select>
                 <?php echo \Helper_Form::clear_select('project'); ?>
            </td>
            <td align="left">
                <label for="">AREA:</label>
                <select name="area" class="filter_field" id="wdb_area"></select>
                 <?php echo \Helper_Form::clear_select('area'); ?>
            </td>
        </tr></table>
        <table   border="0" width="100%"  style="" ></table>
        <table   border="0" class="filter_table"  style="" width="100%" >
        <tr class="tr" >
            <td colspan=""  style="width: 35%">
                <label>TYPE:</label>
                <select name="type" class="filter_field" id="a_type"></select>
                 <?php echo \Helper_Form::clear_select('type'); ?>
            </td>

            <td  style="width: 40%"> 
                <label for=""><u>STATUS:</u></label>
                <select name="status" onclick="setval();" class="filter_field" Id="selectF">
                    <option value="1">Current contacts and organisations</option>
                    <option value="2">Obsolete contacts</option>
                    <option value="3">Obsolete organisations</option>
                    <option value="4">All contacts and organisations</option>
                </select>
                 
            </td><td style="">
            <input type="button" style="font-weight:bold;color: blue;" id="new_org_button"  value="NEW ORGANISATION"/>   
    <!--<button href="<?php echo \Uri::create('contacts/new_org'); ?>" class="cb  iframe  spaced"><font color="blue"><b>NEW ORGANISATION</b></font></button>--> 
    
            </td><td style="">
                <?php echo '<input type="button"     id="cat" style="font-weight:bold;" class="btn spaced " value="CAT.S"/>';?>
                <?php echo '<input type="button" onclick="clearCatJs()" class="btn spaced" style="font-weight:bold;" id="clearCat" value="CLEAR CAT.S"/>';?>
            </td><td style="" >
                <input type="button" id="search" class="btn spaced" style="font-weight:bold;color:red;width:100%;"  value=" SEARCH"/>
        <input type="button" id="search_clear" class="btn spaced " style="font-weight:bold;color:red;width:100%;display:none;"  value="CLEAR SEARCH"/>
               
                
                 
                 
            </td><td style="width:10%;" >
                <?php (\Input::get('mode'))? $clouseButton= " <input type='button' onclick='closeIframeforQuote()'   style='font-weight:bold;' class='btn spaced' value='CLOSE'/>":$clouseButton='<input type="button"  href="dashboard" id=""   style="font-weight:bold;" class="btn spaced" value="CLOSE"/>';
                echo $clouseButton ;?>
            </td>
        </tr>
</table>
        
    
    


    
    <table class="category_search grid_filter filter_table Invisibal"  width="100%">
            <tr>
                <td width="50%" class="clr_contact_category">
                    <label for="">Contact Category</label>
                    <?php $a=array(''=>''); ?>
                    <?php echo \Form::select('contact_cat', '', array_merge($a,$contact_cats), array('id'=>'contact_cat','class'=>'filter_field')); ?>
                     <?php echo \Helper_Form::clear_select('contact_cat'); ?>
                </td>
                <td width="50%" class="clr_org_category">
                    <label for="">Organization Category</label>
                     <?php $a=array(''=>''); ?>
                    <?php echo \Form::select('org_cat', '', array_merge($a,$org_cats), array('id'=>'org_cat','class'=>'filter_field')); ?>
                     <?php echo \Helper_Form::clear_select('org_cat'); ?>
                </td>
            </tr>
            

    </table>
    <input type="text" id="insertCheckr2nd" style="display:none" value="">

   
   <input type="hidden" name="org_type" id="hiddenOrgType" value="EXTERNAL" disabled/>  <input type="hidden" name="export_to_excel_limit" id="hiddenExportToExcelLimit" value="200" disabled/> <input type="hidden" name="export_to_excel" id="hoddenExportToExcel"  disabled/> <input type="hidden" name="limitData" id="limitData" class="filter_field" value="200"/> 
<input type="hidden" name="topColor" id="topColor"  /> <input type="hidden" name="TopCount" id="TopCount"  /> 
</form>

<div id="somediv" title="frmContact" width="100%" height="1000px" style="display:none;background-color:#8FA5FA;" >
    <iframe id="thedialog" width="100%" height="1000px" style="background-color:#8FA5FA;overflow:auto;border:none"></iframe>
</div>
<div id="somediv1" title="frmContact" width="100%" height="100%" style="display:none;" >
    <iframe id="thedialog1" width="100%" height="100%"></iframe>
</div>



<script id="code1" type="text/myjs">alert('hi')</script>
<script type="text/javascript">
	dt = $('.datatable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bFilter" : false,
                        "bAutoWidth": false,
                        "oLanguage": {
                        "sProcessing": "Please wait - loading..."
                        },
                        "iTotalRecords": "57",
                         "iTotalDisplayRecords": "57",
                         'iDisplayLength':-1,
                        //"sScrollY": "585px",
                      // "sPaginationType": "full_numbers",
                        
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0, 3, 4 ] }],
			"sAjaxSource": "<?php if(\Input::get('mode')){$mode='?mode=form';}else{$mode='';} echo \Uri::create('contacts/listing_data/'. $mode); ?>",
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
						$('#a_type, #wdb_branch, #wdb_section, #wdb_project, #wdb_area ').html('<option value=""> </option>');

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
					alert('Please fill in \''+$(this).data('label')+'\' box');
					do_run++;
					return false;
				}
			});

			if($('*[name="advance[add_criteria]"]').val() != 'N/A') {
                           
				$.each(das, function(index, value){ //this loop checks for series of fields
					if($('*[name="advance[field]"]').val().length == 0) {
                                            alert('Please fill in \''+$(this).data('label')+'\' box');
						do_run++;
						return false;
					}else{
                                            if($('*[name="advance[equality]"]').val().length == 0) {
                                                //alert("ff");
						alert('Please fill in \''+$('*[name="advance[equality]"]').data('label')+'\' box');
						do_run++;
						return false;
                                            }else{
                                            
                                            if($('*[name="advance[criteria]"]').val().length == 0) {
                                                alert('Please fill in \''+$('*[name="advance[criteria]"]').data('label')+'\' box');
						do_run++;
						return false;
                                            }
                                            
                                            
                                            }
                                        }
				});
			}
                        

			if(do_run == 0) {
				
				$('#search_clear, #search').toggle();
                                $("#hoddenExportToExcel").remove();
                                
                                dt.fnDraw();
				//$.colorbox.close();
			}

		});

		$('*[name="advance[add_criteria]"]').change(function(){
                    if($('*[name="advance[add_criteria]"]').val() == 'N/A') {
				//childern.hide();
                               $('*[name="advance[field]"]').attr('disabled','disabled');
                                $('*[name="advance[equality]"]').attr('disabled','disabled');
                               $('input[name="advance[criteria]"]').attr('readonly','readonly');
                                $('#aField').css("color",'#B8B8B8');
                                $('#aEquality').css("color",'#B8B8B8');
                                $('#aCriteria').css("color",'#B8B8B8');
                                
			}
			else {
				//childern.show();
                                
                                $('input[name="advance[criteria]"]').removeAttr('readonly');
                                $('*[name="advance[field]"]').removeAttr('disabled','');
                                $('*[name="advance[equality]"]').removeAttr('disabled','');
                                $('#aField').css("color",'#000000 ');
                                $('#aEquality').css("color",'#000000 ');
                                $('#aCriteria').css("color",'#000000 ');
			}
		});

		

		$('*[name="advance[add_criteria]"]').change();
		
		//$('#search').colorbox({inline:true});
                
     //change colour when click button 2/4/2013 sd         
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
    
    
     
         
     //invisible top lable 2/4/2013 sd
      $('#DataTables_Table_0_length').css("display", "none");
      $('#DataTables_Table_0_paginate').css("display", "none");
      
   //set default hidden clearCat button  2/4/2013 sd 
      $(document).ready(function() {
        $("#clearCat").css("display", "none");
           
    });
    
    var timerId=self.setInterval(function(){if(parent.$("#controlpanal").val().length!=0){refrish()}},1000);
    function refrish(){
       // alert(parent.$("#controlpanal").val().length);
       clearInterval(timerId);
         dt.fnDraw();
    }
</script>

   <?php 
	//according to parameter to record selection processs
	if(\Input::get('mode')){
		
		?>
    <script type="text/javascript">
		$('.select_item2').live('click', function(){
			//console.log($(this).data());
			var org_id	 	 = $(this).data('org_id');
			var contact_id	 = $(this).data('contact_id');
			var name = $(this).data('org_name');
			var contact_name = $(this).data('contact_name');
				
			parent.$("#hid_org_id").val(org_id);
			parent.$("#hid_contact_id").val(contact_id);
			parent.$("#org_name").val(contact_name);
			parent.$("#org_contact").val(name);
			parent.$('#InsertQuoteNextWendow').dialog('close');
			//alert('ff');
                       
		});
                 $('.select_item').live('click', function(){
                                    var id = $(this).data('id');
                                //$('#module_top_menu').css('height',10000);
                                    editCon(id);
                                });
                                function editCon(id){
					
                                        var width = $(window).width();
                                            var height = $(window).height();
                                            // parent.$('body').css('overflow','hidden');
                                          //  alert(height);
 parent.$('body').css('overflow','hidden');
                   width = width - 200;
                                    if(height>950){
                                       $('#somediv').css('overflow','hidden'); 
                                    height = height-50;
                                    }
                                    
					  //$(".select_item").click(function () {
                                        $("#thedialog").attr('src', "<?php echo \Uri::create('contacts/edit/'); ?>"+id);
                                        $("#somediv").dialog({
                                            open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
                                            width: width,
                                            height: height,
                                            modal: true,
                                             resize:false,
                                            resizable: false,
                                            close: function () {
                                                $("#thedialog").attr('src', "about:blank");
                                            }
                                            
                                            
                                        });

                                     $( "#saveId" ) .click(function() {
  
    $(window.top.document).find('#ContactEditDialog').dialog('close');
 });
	}			
	//alert('s');
         $('#ButtonContact').css('width','4%');
         $('#CONTACT_PHONE').css('width','15%');
         $('#CONTACT_MOBILE').css('width','15%');
                $('#module_top_menu').css('top','0px');
                $('#module_top_menu').css('padding','0px');
                $('#module_top_menu').css('margin-top','0px');
                 $('#filter').css('padding','0px');
                  $('#filter').css('margin-bottom','0px');
                  $('.container').css('padding','0px');
                  $('#module_top_menu').css('width','100%');
                  $('.listing_screen #filter ').css('width','100%');
                  //{ padding:10px; }
		</script>
        <?php }else{?>
           <script type="text/javascript">
				$('.select_item').live('click', function(){
                                    var id = $(this).data('id');
                                
                                    editCon(id);
                                });
                                
                                
                  function editCon(id){
					
                                        var width = parent.$('body').innerWidth();
                                            var height = $(window).height();
                                          //  alert(height);
 parent.$('body').css('overflow','hidden');
                   width = width - 200;
                                    if(height>950){
                                       $('#somediv').css('overflow','hidden'); 
                                    height = height-50;
                                    }
                                    
					  //$(".select_item").click(function () {
                                         parent.$("#thedialog").attr('src', "<?php echo \Uri::create('contacts/edit/'); ?>"+id);
                                         parent.$("#somediv").dialog({
                                             open: function(event, ui) {  parent.$(".ui-dialog-titlebar-close").hide(); },
                                            width: width,
                                            height: height,
                                            modal: true,
                                             resize:false,
                                            resizable: false,
                                            close: function () {
                                                $("#thedialog").attr('src', "about:blank");
                                            }
                                            
                                            
                                        });

                                     $( "#saveId" ) .click(function() {
  
    $(window.top.document).find('#ContactEditDialog').dialog('close');
 });
	}			
		</script>
        
        <?php } ?>
 <script type="text/javascript">

//get data from cat.php ifram and set default 4/4/2013 sd
     function setData(contact_cat,org_cat){
         if(contact_cat!=''||org_cat!=''){
             
         document.getElementsByName("contact_cat")[0].value=contact_cat;
         document.getElementsByName("org_cat")[0].value=org_cat;
         dt.fnDraw();
         $('#cat, #clearCat').toggle();
        
        }
     }
 //clear filters 4/4/2013 sd
    function clearCatJs(){
        document.getElementsByName("contact_cat")[0].value='';
            document.getElementsByName("org_cat")[0].value='';
            dt.fnDraw();
            $('#clearCat, #cat').toggle();
        }    


$('#search').click(function(){
    $("select#form_field").prop("selectedIndex",2);
      
    });
</script>
<script>
   
//  $(function() {
//    $( "#dialog-form_contacts" ).dialog({
//        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
//      autoOpen: false,
//      height: 400,
//      width: 610,
//      modal: true,
//      resize:false,
//      resizable: false,
//      hide: 'puff',
//        show: 'puff',
//        
//    });
//   $( "#advance_search1" ) .click(function() {
//       parent.$('body').css('overflow','auto');
//        $('input').removeAttr('disabled','disabled');
//    $( "#dialog-form_contacts"  ).dialog( "close" );
// });
// 
//    $( "#search" ).button().click(function() {
//         $( "#dialog-form_contacts" ).dialog( "open" );
//           $("div").removeClass("ui-resizable-handle");
//           parent.$('body').css('overflow','hidden');
//          
//        });
//           
//           
//  });

parent.$("#lll").dialog({
    autoOpen: false,
    modal: true,
    width:600,
    height:400,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
parent.$(".ui-dialog-titlebar-close").hide();
             parent.$('#lllIF').attr('src','contacts/search_contacts');
           // $("p").show();
           //window.location.href = 'http://www.google.com'; 
          }
});
 $( "#search" ).button().click(function() {
        parent.$("#lll").dialog( "open" );
        
           
          
        });
        

  </script>
  
  <script src="app.js">
   
 $(function() {
    $( "#ContactEditDialog" ).dialog({
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
     autoOpen: false,
      height: 'auto',
     width: 'auto',
     modal: true,
      resize:false,
     resizable: false,
      hide: 'puff',
        show: 'puff',
    });
  //saveId

    $( "#abcdefg" ).button().click(function() {
        $( "#ContactEditDialog" ).dialog( "open" );
           $("div").removeClass("ui-resizable-handle");
          parent.$('body').css('overflow','hidden');
         
       });
           
          
  });

//UpdateLesting();
//function ContactListin(){
//    alert('ss');
//    dt.fnDraw();
//}

var countSetVal=0;



function cleanSetIntervalFunction()
{
   
    
   //alert(countSetVal);
    if(countSetVal>0){
        
        clearInterval(intervalId);
        intervalId = null;
        $('#insertCheckr2nd').val('');
    }
    countSetVal++;

}
function getDataFromNew2(val1){
     $("#"+val1).click();
        setTimeout(function(){$("#"+val1).click();},1000);
    }
      
function openWindowAndClose()
{
   
    
    intervalId=setInterval(function(){ })
      

}
  function closeIframeforQuote()
{
    parent.$('#InsertQuoteNextWendow').dialog('close');
}


parent.$("#CatWendow").dialog({
    autoOpen: false,
    modal: true,
    width:600,
    height:400,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
parent.$(".ui-dialog-titlebar-close").hide();
             parent.$('#CatWendowIF').attr('src','contacts/catForme');
          }
});

$('#cat').click(function(){
      $('#CatWendow').css('overflow','hidden');
     parent.$('body').css('overflow','hidden');
    parent.$('#CatWendow').dialog('open');
    
});


$('#cat').click(function(){
      $('#CatWendow').css('overflow','hidden');
     parent.$('body').css('overflow','hidden');
    parent.$('#CatWendow').dialog('open');
    });
    
parent.$("#NewOrg").dialog({
    autoOpen: false,
    modal: true,
    width:530,
    height:580,
    resize:false,
      resizable: false,
      
    open: function(ev, ui){
parent.$(".ui-dialog-titlebar-close").hide();
             parent.$('#NewOrgIF').attr('src','contacts/new_org');
          }
});

$('#new_org_button').click(function(){
    //alert($('#insertUrl').val());
    parent.$('body').css('overflow','hidden'); 
    parent.$('#NewOrg').dialog('open');
});

function ContactListin(){
    alert('gg');
}


  </script>
  
<!--  
$('.select_item').live('click', function(){
					var id = $(this).data('id');
					  $(".select_item").click(function () {
                                        $("#thedialog").attr('src', "<?php echo \Uri::create('contacts/edit/'); ?>"+id);
                                        $("#somediv").dialog({
                                            width: 1250,
                                            height: 1000,
                                            modal: true,
                                            close: function () {
                                                $("#thedialog").attr('src', "about:blank");
                                            }
                                            
                                            
                                        });
                                        return false;
                                    });
                                     $( "#advance_search1" ) .click(function() {
       parent.$('body').css('overflow','auto');
        $('input').removeAttr('disabled','disabled');
    $( "#dialog-form_contacts"  ).dialog( "close" );
 });
				});-->