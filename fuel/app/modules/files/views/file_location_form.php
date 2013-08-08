<?php echo $form->open();?>
<body class="file_location">

	
    <div align="center" id="file_location">
    	
        <div class="content">
        	
            <h1>FILE LOCATION FORM</h1>
            
            <h2><?php echo $setOfLocations['CF_FileNumber_pk'] ; ?></h2>
            
            
            <div class="box-1">
            	<h3>CURRENT LOCATION</h3>
                <table cellpadding="0" cellspacing="0" border="0"  class="table-1">
                	<tr>
                    	<td width="25%" border="0" ><p>Location:</p></td>
                        <td width="5%"><?php echo'<div class="employee"><input type=button class="select_current_employee" id="insert_quote_emp1"  data-emp_id="'.Nmi::current_user('last_name_first').'" data-dropdown="#FrmInsert_officer1" type="button"  />'?></td><td width="70%" align="left"><?php echo $form->build_field('current_location'); ?></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="50%"><p>Date at location:</p></td>
                        <td align="right"><input type="text" id="dataLocationId" class="datepicker " name="date_at_location" value="<?php echo $setOfLocations['CF_FileLocationDate'] ?>" style="margin-right:10%;text-align:center;"/></td>
                    </tr>
                </table>
            </div>
            <div class="box-1">
            	<h3>REQUESTED LOCATION</h3>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="25%"><p>Location:</p></td>
                        <td width="5%"><?php echo'<div class="employee"><input type=button class="select_current_employee" id="insert_quote_emp2"  data-emp_id="'.Nmi::current_user('last_name_first').'" data-dropdown="#FrmInsert_officer2" type="button"  />'?></td><td width="70%" align="left"><?php echo $form->build_field('requested_location'); ?></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="50%"><p>Date required:</p></td>
                        <td  align="right"><input type="text" id="DateRequiredId" class="datepicker " name="date_required" value="<?php echo $setOfLocations['CF_FileRequestDate'] ?>" style="margin-right:10%;text-align:center;" /></td>
                    </tr>
                </table>
            
                
                <table align="" width="85%" border="0">
                      <tr>
                          <td width="85%" align="right">
                 <input type="button" class="button3" value="UNDO" id="btn_undo"/>
                          </td><td>
                        <input type="button" class="button3" value="CLEAR" id="btn_clear" />
                        </td>
                        </table>
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button2" name="close_locations" value="CLOSE" id="btn_close" /></div>
                </div>
            </div>
            
            
            
         
                        <input type="hidden"  id="hid_CF_FileLocation" value="<?php echo$setOfLocations['CF_FileLocation']?>" />
                        <input type="hidden"  id="hid_CF_FileLocationDate"  value="<?php echo$setOfLocations['CF_FileLocationDate']?>"/>
                        <input type="hidden"  id="hid_CF_FileRequestLocation" value="<?php echo$setOfLocations['CF_FileRequestLocation']?>"/>
                         <input type="hidden"  id="hid_CF_FileRequestDate"  value="<?php echo$setOfLocations['CF_FileRequestDate']?>"/>
                         
                       
                        
            
        </div>
        
    </div>

<script type="text/javascript">
$( ".date_picker" ).datepicker({ altFormat: "yy-mm-dd" });
$("#btn_clear").click(function(){
    $('#FrmInsert_officer2').val('');
    $('#DateRequiredId').val('');
    });
    
    jQuery(document).ready(function($){
        $('#hid_CF_FileLocation').val($('#FrmInsert_officer1').val());
   $('#hid_CF_FileLocationDate').val($('#dataLocationId').val());
    $('#hid_CF_FileRequestLocation').val($('#FrmInsert_officer2').val());
    $('#hid_CF_FileRequestDate').val($('#DateRequiredId').val()); 
        });
   
 $("#btn_undo").click(function(){
    $('#FrmInsert_officer1').val($('#hid_CF_FileLocation').val());
    $('#dataLocationId').val($('#hid_CF_FileLocationDate').val());
    $('#FrmInsert_officer2').val($('#hid_CF_FileRequestLocation').val());
    $('#DateRequiredId').val($('#hid_CF_FileRequestDate').val());
    });


//
//
//$("#btn_clear").click(function(){
//	//CF_FileLocation Select box reset
//	var CF_FileLocation = $("#CF_FileLocation").prop("selectedIndex");
//	$('#CF_FileLocation option').eq(0).attr('selected', 'selected');
//	$('#hid_CF_FileLocation').val(CF_FileLocation);
//	
//	//CF_FileLocation Select box reset
//	var CF_FileRequestLocation =  $("#CF_FileRequestLocation").prop("selectedIndex");
//	$('#CF_FileRequestLocation option').eq(0).attr('selected', 'selected');
//	$('#hid_CF_FileRequestLocation').val(CF_FileRequestLocation);
//	
//	//datepicker_file_loaction_date Select box reset
//	var datepicker_file_loaction_date = $('#datepicker_file_loaction_date').val();
//	$('#datepicker_file_loaction_date').val('');
//	$('#hid_CF_FileLocationDate').val(datepicker_file_loaction_date);
//	
//	//datepicker_file_request_date Select box reset
//	var datepicker_file_request_date = $('#datepicker_file_request_date').val();
//	$('#datepicker_file_request_date').val('');
//	$('#hid_CF_FileRequestDate').val(datepicker_file_request_date);
//});
//
//$("#btn_undo").click(function(){
//	//CF_FileLocation Select box reset
//	var CF_FileLocation = $('#hid_CF_FileLocation').val();
//	$('#CF_FileLocation option').eq(CF_FileLocation).attr('selected', 'selected');
//	
//	//CF_FileLocation Select box reset
//	var CF_FileRequestLocation = $('#hid_CF_FileRequestLocation').val();
//	$('#CF_FileRequestLocation option').eq(CF_FileRequestLocation).attr('selected', 'selected');
//	
//	//datepicker_file_loaction_date Select box reset
//	var datepicker_file_loaction_date = $('#hid_CF_FileLocationDate').val();
//	$('#datepicker_file_loaction_date').val(datepicker_file_loaction_date);
//	
//	//datepicker_file_loaction_date Select box reset
//	var datepicker_file_request_date = $('#hid_CF_FileRequestDate').val();
//	$('#datepicker_file_request_date').val(datepicker_file_request_date);
//
//});
//
////Close Butoon Action
//$("#btn_close").click(function(){
//	var CF_FileLocation			=	$("select#CF_FileLocation option:selected").val();
//	var CF_FileRequestLocation	=	$("select#CF_FileRequestLocation option:selected").val();
//	var CF_FileLocationDate		=	$("#datepicker_file_loaction_date").val();
//	var CF_FileRequestDate		=	$("#datepicker_file_request_date").val();
//	
//	parent.$('#CF_FileLocation').val(CF_FileLocation);
//	parent.$('#CF_FileRequestLocation').val(CF_FileRequestLocation);
//	parent.$('#datepicker_file_loaction_date').val(CF_FileLocationDate);
//	parent.$('#datepicker_file_request_date').val(CF_FileRequestDate);
//	
//	parent.jQuery.fn.colorbox.close();
//});

$(".select_current_employee").click(function(){
    
var emp_id   = $(this).data('emp_id');
var select_id   = $(this).data('dropdown');
//alert(select_id);
            $(select_id).val(emp_id);
            });
</script>