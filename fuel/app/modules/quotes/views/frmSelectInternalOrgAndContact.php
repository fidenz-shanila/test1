<?php //echo $form->open();?>	
<div class="noPadding">
<form>
   <div id="selectinternalorg" style="background-color:#C7DDFE">
    	<div width="100%" style="text-align:center"><h1 style="margin-bottom:15px;">SELECT NMI OWNER FORM</h1></div>
        <div class="content">
         <div class="box-0" style="width:100%" >
         <div class="c1">
         <div class="blk">
        
<table width="100%"  border="0" class="tbl_internal" style="background-color:#C7DDFE">
	<tr>
		<td width="70%">
			<table width="99%"   border="0" style="background-color:#7BAFFD;text-align: center;" class="tbl_internal midTable">
				<tr>
					<td >
						<h3>1)SELECT NMI PROJECT</h3>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div style="width:98%; height:20px; background-color:#CCC;" class="middiv" id="div_project_msg"></div>
					</td>
				</tr>
				<tr>
					<td height="300px">
						<div id="table-scroll">
						<table border="0" id="table-scroll_table"  style="width:100%;"><tr ><td  align="center"> 
						<?php //echo $form->build_field('txt_projects'); echo $project_list;
						$i=0; echo '<ol id="selectable_projects" style="height:400px" >'; foreach(\Quotes\Model_Quote::get_nmi_internal_projects()as $key => $value){ echo '<li value='.$key.'  class="ui-widget-content Contactcon" style="padding-left:3px;;padding-top:2px;">'.$value.'</li>' ;$i++; };echo '</ol>'; ?>
						</td></tr></table>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td width="30%">
			<table width="99%" align="center" border="0" class="tbl_internal midTable" style="background-color:#D3A8FF">
				<tr>
					<td>
						<h3>2)SELECT NMI CONTACT</h3>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div style="width:98%; height:20px; background-color:#CCC;" class="middiv" id="div_contact_msg"></div>
					</td>
				</tr>
				<tr>
					<td  height="700px">
						<div id="table-scroll">
						<table border="0" id="table-scroll_table" align="center" style="width:100%;"><tr ><td  align="" > 
						<?php //echo $form->build_field('txt_projects'); echo $project_list;
						$i=0; echo '<ol id="selectable_contacts" >'; foreach(\Quotes\Model_Quote::get_nmi_internal_contacts()as $key => $value){ echo '<li value='.$key.'  class="ui-widget-content Contactcon" style="padding-left:3px;;padding-top:2px;">'.$value.'</li>' ;$i++; };echo '</ol>'; ?>
						</td></tr></table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
             <div class="box-2">
            	
            	<div class="rightside">
                <div class="blk" ><input type="button" class="button2" id="sel_select_button" value="SELECT" /></div>
                	
                    <div class="blk"><input type="button" class="button2" onclick='closeIframeforQuote_Con();' id="btn_close" value="cancel" /></div>
                </div>
            </div>
            
</div>
</div>

        </div>

</div>
</div>
</div>
</form>



<script type="text/javascript">

$('#sel_select_button').click(function(e){
    //alert($('#div_project_msg').text());
    if($('#div_project_msg').text().length!=0){
                    if($('#div_contact_msg').text().length!=0){
                            var selectd_text_project = $("#my-selected").text();
	var selectd_val_project = $("#my-selected").val();
	var selectd_text_contact = $("#my-selected_con").text();
	var selectd_val_contact = $("#my-selected_con").val();
	
	parent.$("#hid_org_id").val(selectd_val_project);
	parent.$("#hid_contact_id").val(selectd_val_contact);
	parent.$("#org_name").val(selectd_text_project);
	parent.$("#org_contact").val(selectd_text_contact);
	//parent.jQuery.fn.colorbox.close();
       parent.$('#InsertQuoteNextWendow').dialog('close');
                                }else{
                                     alert('Please make the selection(s)');
                                    e.preventDefault();
                                }
                                }else{
                                     alert('Please make the selection(s)');
                                    e.preventDefault();
                                }
                            
    });
function closeIframeforQuote_Con()
{
    parent.$('#InsertQuoteNextWendow').dialog('close');
}
//Call to Project Selectbox
$(function(){
  $("#selectable_projects li").click(function(){ 
      //alert('s');
      $("#selectable_projects li").css('background', '#FFFFFF'); 
      $("#selectable_projects li").css('color', 'black'); 
        $(this).css('background', 'black'); 
      $(this).css('color', 'white'); 
      //$(this).addClass("my-selected");
      $(this).attr('id', 'my-selected');
  	 $("#div_project_msg").html('');
	  var selectd_text = $(this).text();
	  var selectd_val = $(this).val();
      $("#div_project_msg").html(selectd_text);
    });
});

//Run Select button
//$("#sel_select_button").click(function(){
//   // alert($("#my-selected").text());
//	var selectd_text_project = $("#my-selected").text();
//	var selectd_val_project = $("#my-selected").val();
//	var selectd_text_contact = $("#my-selected_con").text();
//	var selectd_val_contact = $("#my-selected_con").val();
//	
//	parent.$("#hid_org_id").val(selectd_val_project);
//	parent.$("#hid_contact_id").val(selectd_val_contact);
//	parent.$("#org_name").val(selectd_text_project);
//	parent.$("#org_contact").val(selectd_text_contact);
//	//parent.jQuery.fn.colorbox.close();
//         parent.$('#InsertQuoteNextWendow').dialog('close');
//});

//Run Close Button
//$("#btn_close").click(function(){
//	parent.jQuery.fn.colorbox.close();
//});

//Call to contact Selectbox
$(function(){
  $("#selectable_contacts li").click(function(){ 
      $("#selectable_contacts li").css('background', '#FFFFFF'); 
      $("#selectable_contacts li").css('color', 'black'); 
        $(this).css('background', 'black'); 
      $(this).css('color', 'white');
      $(this).attr('id', 'my-selected_con');
  	  $("#div_contact_msg").html('');
	  var selectd_text_contact = $(this).text();
	  var selectd_val_contact = $(this).val();
      $("#div_contact_msg").html(selectd_text_contact);
    });
});
// parent.$('#NewOrgIF').css('width','100px');
//                        parent.$('#NewOrgIF').css('height','100px');



</script>
<style>
    #table-scroll {
  height:98%;
  margin-left:1%;
  width:98%;
  overflow:auto;  
  vertical-align: top;
  padding-top:5px
  
}
</style>