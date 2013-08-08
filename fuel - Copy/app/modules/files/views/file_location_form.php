
<body class="file_location">

	
    <div id="file_location">
    	
        <div class="content">
        	
            <h1>FILE LOCATION FORM</h1>
            
            <h2><?php echo $CF_FileNumber_pk ; ?></h2>
            
            
            <div class="box-1">
            	<h3>CURRENT LOCATION</h3>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="30%"><p>Location <input type="button" class="button2" value="" /></p></td>
                        <td><?php echo $form->CF_FileLocation; ?></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="30%"><p>Date at location</p></td>
                        <td><?php echo $form->CF_FileLocationDate; ?><input type="button" class="button1" value=".." /></td>
                    </tr>
                </table>
            </div>
            <div class="box-1">
            	<h3>REQUESTED LOCATION</h3>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="30%"><p>Location <input type="button" class="button2" value="" /></p></td>
                        <td><?php echo $form->CF_FileRequestLocation; ?></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="30%"><p>Date at location</p></td>
                        <td><?php echo $form->CF_FileRequestDate; ?><input type="button" class="button1" value=".." /></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td>
                        <input type="hidden" value="" id="hid_CF_FileLocation" />
                        <input type="hidden" value="" id="hid_CF_FileLocationDate" />
                        <input type="hidden" value="" id="hid_CF_FileRequestLocation" />
                         <input type="hidden" value="" id="hid_CF_FileRequestDate" />
                         
                        <input type="button" class="button3" value="UNDO" id="btn_undo"/>
                        <input type="button" class="button3" value="CLEAR" id="btn_clear" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="button" class="button2" value="close" id="btn_close" /></div>
                </div>
            </div>
            
            
            
            
            
        </div>
        
    </div>

<script type="text/javascript">
$( ".date_picker" ).datepicker({ altFormat: "yy-mm-dd" });



$("#btn_clear").click(function(){
	//CF_FileLocation Select box reset
	var CF_FileLocation = $("#CF_FileLocation").prop("selectedIndex");
	$('#CF_FileLocation option').eq(0).attr('selected', 'selected');
	$('#hid_CF_FileLocation').val(CF_FileLocation);
	
	//CF_FileLocation Select box reset
	var CF_FileRequestLocation =  $("#CF_FileRequestLocation").prop("selectedIndex");
	$('#CF_FileRequestLocation option').eq(0).attr('selected', 'selected');
	$('#hid_CF_FileRequestLocation').val(CF_FileRequestLocation);
	
	//datepicker_file_loaction_date Select box reset
	var datepicker_file_loaction_date = $('#datepicker_file_loaction_date').val();
	$('#datepicker_file_loaction_date').val('');
	$('#hid_CF_FileLocationDate').val(datepicker_file_loaction_date);
	
	//datepicker_file_request_date Select box reset
	var datepicker_file_request_date = $('#datepicker_file_request_date').val();
	$('#datepicker_file_request_date').val('');
	$('#hid_CF_FileRequestDate').val(datepicker_file_request_date);
});

$("#btn_undo").click(function(){
	//CF_FileLocation Select box reset
	var CF_FileLocation = $('#hid_CF_FileLocation').val();
	$('#CF_FileLocation option').eq(CF_FileLocation).attr('selected', 'selected');
	
	//CF_FileLocation Select box reset
	var CF_FileRequestLocation = $('#hid_CF_FileRequestLocation').val();
	$('#CF_FileRequestLocation option').eq(CF_FileRequestLocation).attr('selected', 'selected');
	
	//datepicker_file_loaction_date Select box reset
	var datepicker_file_loaction_date = $('#hid_CF_FileLocationDate').val();
	$('#datepicker_file_loaction_date').val(datepicker_file_loaction_date);
	
	//datepicker_file_loaction_date Select box reset
	var datepicker_file_request_date = $('#hid_CF_FileRequestDate').val();
	$('#datepicker_file_request_date').val(datepicker_file_request_date);

});

//Close Butoon Action
$("#btn_close").click(function(){
	var CF_FileLocation			=	$("select#CF_FileLocation option:selected").val();
	var CF_FileRequestLocation	=	$("select#CF_FileRequestLocation option:selected").val();
	var CF_FileLocationDate		=	$("#datepicker_file_loaction_date").val();
	var CF_FileRequestDate		=	$("#datepicker_file_request_date").val();
	
	parent.$('#CF_FileLocation').val(CF_FileLocation);
	parent.$('#CF_FileRequestLocation').val(CF_FileRequestLocation);
	parent.$('#datepicker_file_loaction_date').val(CF_FileLocationDate);
	parent.$('#datepicker_file_request_date').val(CF_FileRequestDate);
	
	parent.jQuery.fn.colorbox.close();
});

</script>