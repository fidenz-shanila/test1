<div style="background-color:#FEE69C;overflow:hidden;height:100%">
<?php echo $form->open(array('id'=>'form_new_quote'));?>
    <div id="insertnewquote">
    	
        <div class="content">
        	
            <h1>INSERT NEW QUOTE</h1>
            
            
            <div class="box-0">
            	
                <div class="c1">
                	<h3>1) instrument owner type</h3>
                     <?php echo $form->build_field('sel_type_owner');?>
                </div>
                <div class="c2">
                	<h3>2) instrument owner</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="20%"><p>Organisation:</p></td>
                            <td>
                            
                    	  <?php echo $form->build_field('org_names'); ?>
                           <?php echo $form->build_field('hid_org_id'); ?>
                           
                           <!--This hidden fields are not in use-->
                            <?php echo $form->build_field('servicesoffered'); ?>
                             <?php echo $form->build_field('special_requirements'); ?>
                              <?php echo $form->build_field('certificate_offered'); ?>
                             
                            </td>
                        </tr>
                        
                        <tr>
                        	<td><p>Contact:</p></td>
                            <td><table width="100%" border="0"><tr><td></td><td>
                                            <?php echo $form->build_field('org_contact');?>
                                             <?php echo $form->build_field('hid_contact_id'); ?>
                                        </td><td align="right">
                                            
                                            
                                            <input type="button" class="button1" id="btn_contact_load" value="SELECT"/>
<!--                                             <button class="cb iframe button1" id="btn_contact_load"  href="<?php echo \Uri::create('contacts/?mode=form'); ?>" >SELECT</button>-->
                                            <input type="text" id="btn_contact_load_hidden_text" style="display:none;" value="contacts/?mode=form">
                                            <input type="text" id="btn_contact_load_hidden_color" style="display:none;" value="#8FA5FA">
                                            <input type="text" id="btn_contact_load_hidden_width" style="display:none;" value="1500">
                                            <input type="text" id="btn_contact_load_hidden_height" style="display:none;" value="1000">
                                            
                                        </td></tr></table>
                            
                            
                           
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
                
                <div class="c3">
                	<h3>3) work performed by</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>NMI Branch:</p></td>
                            <td>
                            <?php echo $form->build_field('branch_name'); ?>
                            </td>
                        </tr>
                        <tr>
                        	<td><p>NMI Section:</p></td>
                            <td><?php echo $form->build_field('S_Name_ind'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Project:</p></td>
                            <td><div id="div_sel_project"><?php echo $form->build_field('projects'); ?></div></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Area:</p></td>
                            <td><?php echo $form->build_field('areas'); ?></td>
                        </tr>
                        <tr bgcolor="#d9b7ff">
                        	<td><p>Test Officer:</p></td>
                             <td> <table border="0" width="100%"><tr><td ><?php echo'<div class="employee"><input type=button class="select_current_employee" id="insert_quote_emp"  data-emp_id="'.Nmi::current_user('id').'" data-dropdown="#FrmInsert_officer" type="button"  />'?></td><td width="50%"><?php echo $form->build_field('offices'); ?></td><td><span>(*Double click to get all)</span></td></tr></table></td>
                             
                        </tr>
          
                        <?php //echo \Helper_Form::list_employees('offices', @$call_sp['offices'],array('required'=>'required'),null,null,1); ?>
                    </table>
                    </div>
                </div>
                <div class="c4">
                	<h3>4) instrument / artefact type</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>Type:</p></td>
                            <td>
                              <?php echo $form->build_field('types'); ?>
                            </td>
                        </tr>
                    </table>
                    </div>
                </div>
                
                <div class="c5">
                	<h3>5) instrument / artefact description</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                            <td width="30%"><p>Make:</p></td>
                            <td width="40%"><?php echo $form->build_field('make'); ?></td>
                            <td width="30%"><span>&nbsp;(Optional)</span></td>
                        </tr>
                        <tr>
                        	<td><p>Model:</p></td>
                            <td width="40%"><?php echo $form->build_field('model'); ?></td>
                            <td width="30%"><span>&nbsp;(Optional)</span></td>
                        </tr>
                        <tr>
                        	<td><p>Serial No.:</p></td>
                            <td width="40%"><?php echo $form->build_field('serial_no'); ?></td>
                            <td width="30%"><span>&nbsp;(Optional)</span></td>
                        </tr>
                        <tr>
                        	<td valign="top"><p>Range:</p></td>
                            <td width="40%"><?php echo $form->build_field('range'); ?></td>
                            <td width="30%"><span>&nbsp;(Optional)</span></td>
                        </tr>
                        <tr>
                            <td></td>
                             <td><h6>(eg., -200 to 100 degC):</h6></td>
                        </tr>
                        
                    </table>
                    </div>
                    <div class="blk1">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        	<tr>
                            	<td width="70%"><p>DESCRIPTION (Can be edited)</p></td>
                                <td><input type="button" class="button1" id="build_description" value="Build description" /></td>
                            </tr>
                            <tr>
                            	<td colspan="2" align="center">
                                	<?php echo $form->build_field('description'); ?><!--<textarea cols="" rows="" class="textarea-1"></textarea>-->
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="c6">
                	<div class="tital">
                    	<div class="right">
                        	<div class="one">
                            <input type="checkbox" class="radio" id="radio_nofile" /><span>No file exists</span></div>
                            <input type="button" class="button1" id="btn_file_load" value="SELECT"/>
                            
<!--                            <button class="cb iframe button1"  href="<?php echo \Uri::create('files/?is_selectable=true');?>">SELECT</button>-->
                           
                        </div>
	                	<h3>6) cb file</h3>
                        
                    </div>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="15%"><p><u>file number</u></p></td>
                            <td><p><u>Title</u></p></td>
                        </tr>
                        <tr>
                        	<td align="center"><?php echo $form->build_field('file_no'); ?>
                            
                            </td>
                            <td align="center"><?php echo $form->build_field('title'); ?></td>
                        </tr>
                        
                    </table>
                    </div>
                    
                </div>
                
            </div>
            
          
            
            
            <div class="box-2">
            	
            	<div class="rightside">
                <div class="blk" ><?php echo $form->build_field('submit'); ?></div>
                	
                <div class="blk"><input type="button" class="button2" id="btn_close" value="cancel / close" onclick=""/></div>
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo Form::close(); ?>
<div id="pop_up_data" style="position:absolute; top:20px; width:100%;"></div>
</div>
<script type="text/javascript">
    $('#btn_contact_load_hidden_width').val(((parent.$('body').innerWidth())/100)*90);
         $('#btn_contact_load_hidden_height').val(((parent.$(window).height()/100)*105));
     $("#sel_type_owner").prop("selectedIndex",1);
     fill_filter();
    $("#txt_file_title").val('Catch all CB file for '+(new Date).getFullYear());
		 var str=new Date().getFullYear()+'';
		 str= str.match(/\d{2}$/);
		  $("#txt_file_name").val('CB/'+str+'/0000'); 
                   $("#radio_nofile").attr("checked","checked");
                  
                  
                  
                  
                  
$('#build_description').click(function(){
	var type	 = $("#sel_type").val();
	var make 	 = $("#txt_make").val();
	var model 	 = $("#txt_model").val();
	var serial	 = $("#txt_serial").val();
	var range	 = $("#txt_range").val();
	
	if(type == ''){
		alert('Please fill in the instrument type.');	
	}else{
		var description = type;
		if(make != ''){
			description	+= ', '+make;
		}
		if(model != ''){
			description	+= ' model '+model;
		}
		if(range != ''){
			description	+= ', '+range;
		}
		if(serial != ''){
			description	+= ', s/n:'+serial;
		}

                    $("#txt_description").val(description);
            
	}
});


//////////////Set Owner Type/////////////////////////////////////

var select_value = $('select#sel_type_owner option:selected').val();
	if(select_value=='NMI'){ 
		$('button#btn_contact_load').click(function(){
			$("#btn_contact_load").attr("href", "<?php echo \Uri::create('quotes/nmi_internal_projects_and_contacts/?mode=form'); ?>")
		});
	}else{
		$('button#btn_contact_load').click(function(){
			$("#btn_contact_load").attr("href", "<?php echo \Uri::create('contacts/?mode=form'); ?>")
		});
	}

$('select#sel_type_owner').change(function(){
	var select_value = $('select#sel_type_owner option:selected').val();
	if(select_value=='NMI'){ 
		$('button#btn_contact_load').click(function(){
			$("#btn_contact_load").attr("href", "<?php echo \Uri::create('quotes/nmi_internal_projects_and_contacts/?mode=form'); ?>")
		});
                $('#org_name').val('');
                $('#org_contact').val('');
                $('#hid_org_id').val('');
                $('#hid_contact_id').val('');
	}else{
		$('button#btn_contact_load').click(function(){
			$("#btn_contact_load").attr("href", "<?php echo \Uri::create('contacts/?mode=form'); ?>")
		});
                 $('#org_name').val('');
                 $('#org_contact').val('');
                 $('#hid_org_id').val('');
                 $('#hid_contact_id').val('');
	}
});

$('#radio_nofile').click(function(){
	
	if($('#radio_nofile').attr('checked')) {
   		 $("#txt_file_title").val('Catch all CB file for '+(new Date).getFullYear());
		 var str=new Date().getFullYear()+'';
		 str= str.match(/\d{2}$/);
		  $("#txt_file_name").val('CB/'+str+'/0000'); 
	} else {
		$("#txt_file_title").val('');
		 $("#txt_file_name").val('');
	}
	
});
var select_option_emp_button     =  '';
$("#insert_quote_emp").click(function(){

            window.select_option_emp_button ='yes';
            fill_filter();	
             });
function fill_filter()
{
	  var select_option_sections =  $('select#sections option:selected').val();
          var select_option_projects =  $('select#projects option:selected').val();
          var select_option_sel_area =  $('select#sel_area option:selected').val();
          var select_option_sel_type =  $('select#sel_type option:selected').val();
           var select_option_emp     =  $('select#FrmInsert_officer option:selected').val();
           
//          / alert('qi');
        

           $.ajax({
            url: "<?php echo \Uri::create('quotes/load_project_select_ajax/'); ?>?sections="+select_option_sections+"&projects="+select_option_projects+"&sel_area="+select_option_sel_area+"&sel_emp="+select_option_emp+"&emp_button="+window.select_option_emp_button+"",
            type: "GET",
            dataType: 'json',
            data: 'id=testdata',
            cache: false,
            success: function(result){
       // alert('z');
        //alert(data1['Wavemeters and optical spectrum analyzers']);
//         $.each(dataFill, function(key, val) {
//    alert(dataFill[val]);
//  });
// 

$('#sections, #projects, #sel_area, #sel_type, #FrmInsert_officer').html('<option value=""></option>');
          $.each(result, function(index, value){  
              $.each(result[index], function(key, val){
                 // alert('s');
                 // alert('<option  value="'+key+'">'+val+'</option>');
                  $('select[name='+index+']').append('<option  value="'+key+'">'+val+'</option>');
              });
        });
        if(window.select_option_emp_button=='yes'){
            var emp_id   = $('#insert_quote_emp').data('emp_id');
            $("#FrmInsert_officer").val(emp_id);
            window.select_option_emp_button ='';
        }
        if((select_option_sections).length !=0){
            // alert(select_option_sections);
             $('#sections').html('<option value="'+select_option_sections+'">'+select_option_sections+'</option>');
        }
        if((select_option_projects).length !=0){
            // alert(select_option_sections);
             $('#projects').html('<option value="'+select_option_projects+'">'+select_option_projects+'</option>');
        }
        if((select_option_sel_area).length !=0){
             //alert(select_option_sections);
             $('#sel_area').html('<option value="'+select_option_sel_area+'">'+select_option_sel_area+'</option>');
        }
      
         }
         
           });
}

//Call to Project Selectbox

  $("select#projects").change(function(){

       // $(this).empty();
		 fill_filter();		
             });
$("select#sections").change(function(){

		 fill_filter();		
});
$("select#sel_area").change(function(){

		 fill_filter();		
 });
 $("select#FrmInsert_officer").change(function(){
//$(' #FrmInsert_officer').html('<option value=""></option>');
		// fill_filter();		
 });
//    $.getJSON("<?php echo \Uri::create('quotes/load_project_select_ajax/'); ?>?sections="+select_option_sections+"&projects="+select_option_projects+"&sel_area="+select_option_sel_area+"&mode=form",{id: $(this).val(), ajax: 'true'}, function(j){
//      var options = '';
//      alert(j);
//      for (var i = 0; i < j.length; i++) {
//          alert('s');
//          alert(j[i]['Section'].optionValue);
//        options += '<option value="' + j[i]['Section'].optionValue + '">' + j[i]['Section'].optionDisplay + '</option>';
//      }
//      $("select#sections").html(options);
//    });



//Call to Area Selectbox
$(function(){
  $("select#projects").change(function(){
	  var select_option = $('select#projects option:selected').val();
    $.getJSON("<?php echo \Uri::create('quotes/load_select_area_ajax/'); ?>?select_id="+select_option+"&mode=form",{id: $(this).val(), ajax: 'true'}, function(j){
      var options = '';
      for (var i = 0; i < j.length; i++) {
         //alert(j[i].optionValue);
        options += '<option value="' + j[i]['area'].optionValue + '">' + j[i]['area'].optionDisplay + '</option>';
      }
      $("select#sel_area").html(options);
    });
  });
});

$("#btn_close").click(function(){

	$('#btn_contact_load_hidden_color').val('#8FA5FA');
        //alert($('#btn_contact_load_hidden_color').val());
        parent.$('#InsertQuote').dialog('close');
        parent.$('body').css('overflow','auto');
});


 //parent.$('#insertCheckr2nd')
 $('#btn_contact_load').click(function(){
    //alert($('#insertUrl').val());
   //alert('ss');
  // alert($('#btn_contact_load_hidden_text').val());

if($('#sel_type_owner').val()=='NMI'){
    $("#InsertQuoteNextWendow").attr('title', 'frmSelectInternalOrgAndContact');
}
if($('#sel_type_owner').val()!='NMI'){
    $("#InsertQuoteNextWendow").attr('title', 'frmContactListing');
}

  var width=$('#btn_contact_load_hidden_width').val();
  var height=$('#btn_contact_load_hidden_height').val();
    parent.$('#NewOrgIF').css('overflow','hidden'); 
  parent.$("#InsertQuoteNextWendow").dialog({
    // open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
    autoOpen: false,
    modal: true,
    width:width,
    height:height,
    resize:false,
      resizable: false,
       open: function(ev, ui){
 parent.$(".ui-dialog-titlebar-close").hide();
             parent.$('#InsertQuoteNextIF').attr('src',$('#btn_contact_load_hidden_text').val());
          }
 
});

    parent.$('#InsertQuoteNextWendow').dialog('open');
});

$('#sel_type_owner').change(function(){
    if($('#sel_type_owner').val()=='NMI'){
        $('#btn_contact_load_hidden_color').val('#C7DDFE');
         $('#btn_contact_load_hidden_text').val('quotes/nmi_internal_projects_and_contacts/?mode=form');
         parent.$("#InsertQuoteNextWendow").css("background-color", $('#btn_contact_load_hidden_color').val());
         parent.$('#InsertQuoteNextIF').css("background-color", $('#btn_contact_load_hidden_color').val());
         $('#btn_contact_load_hidden_width').val(((parent.$('body').innerWidth())/100)*40);
         $('#btn_contact_load_hidden_height').val((parent.$(window).height()/100)*107);
          parent.$("#InsertQuoteNextWendow").attr('title', 'frmSelectInternalOrgAndContact');
         //alert(((parent.$('body').innerWidth())/100)*80);
        // alert(parent.$(window).height());
         
         
    }else{
        $('#btn_contact_load_hidden_color').val('#8FA5FA');
         $('#btn_contact_load_hidden_text').val('contacts/?mode=form');
          parent.$('#InsertQuoteNextIF').css("background-color", $('#btn_contact_load_hidden_color').val());
          parent.$("#InsertQuoteNextWendow").css("background-color", $('#btn_contact_load_hidden_color').val());
         $('#btn_contact_load_hidden_width').val(((parent.$('body').innerWidth())/100)*90);
         $('#btn_contact_load_hidden_height').val(((parent.$(window).height()/100)*105));
          parent.$("#InsertQuoteNextWendow").attr('title', 'frmContactListing');
          //$('#module_top_menu').css('top','0px');
           //alert(parent.$(window).height());
         
    }
   // alert(screen.width/100*80);
});
 $("#btn_contact_load").click(function(){
 var intervalId=setInterval(function(){ 
       
        if((parent.$('#hid_contact_id').val()).length != 0){
           // alert('rr');
         //  parent.$('#insertCheckr2nd').val($('#insertCheckr').val()) ;
         $("#hid_org_id").val(parent.$("#hid_org_id").val());
	$("#hid_contact_id").val(parent.$("#hid_contact_id").val());
	$("#org_name").val(parent.$("#org_name").val());
	$("#org_contact").val(parent.$("#org_contact").val());
        parent.$("#hid_org_id").val('');
        parent.$("#hid_contact_id").val('');
        parent.$("#org_contact").val('');
           clearInterval(intervalId);
        }
        },500);
        });
        
        $('#clear_Sections').live('click', function(){
		
		$('#sections, #projects, #sel_area, #sel_type').html('<option value=""></option>');
                fill_filter();
                
	});
        $('#clear_Projects').live('click', function(){
		
		$(' #projects, #sel_area, #sel_type').html('<option value=""></option>');
                fill_filter();
                
	});
         $('#clear_Areas').live('click', function(){
		
		$(' #sel_area, #sel_type').html('<option value=""></option>');
                fill_filter();
                
	});

function Emp_insert_quote_button(){
		var emp_id   = $(this).data('emp_id');
		var dropdown = $(this).data('dropdown');
                //alert(emp_id);
		$(dropdown).val(emp_id);
}


$('#form_submit').click(function(e){
           
           if($('#org_name').val().length!=0){
               if($('#sections').val().length!=0){
                   if($('#projects').val().length!=0){
                       if($('#sel_area').val().length!=0){
                            if($('#FrmInsert_officer').val().length!=0){                     
                            if($('#sel_type').val().length!=0){                             

                                if($('#txt_description').val().length!=0){
                    
                                }else{
                                     alert('Please fill in the instrument description');
                                    e.preventDefault();
                                }
                             }else{
                             alert('Please fill in the instrument type');
                                e.preventDefault();
                                }

                             }else{
                             alert('Please select an appropriate Test Officer');
                                e.preventDefault();
                                }
                        }else{
                        alert('Please select an appropriate area');
                        e.preventDefault();
                        }
                        
                    }else{
                        alert('Please select an appropriate project');
                        e.preventDefault();
               }
               }else{
                   alert('Please select an appropriate section');
                     e.preventDefault();
               }
           
           }else{
               alert('Please select an appropriate owner');
               e.preventDefault();
           }
    
 
   
});

$('#btn_file_load').click(function(){

  var width=((parent.$('body').innerWidth())/100)*90;
  var height=((parent.$(window).height()/100)*105);
    parent.$('#NewOrgIF').css('overflow','hidden'); 
  parent.$("#OpenFile").dialog({
    autoOpen: false,
    modal: true,
    width:width,
    height:height,
    resize:false,
      resizable: false,
       open: function(ev, ui){
 parent.$(".ui-dialog-titlebar-close").hide();
             parent.$('#OpenFileIF').attr('src','files/?is_selectable=true');
          }
 
});

    parent.$('#OpenFile').dialog('open');
});
$("#btn_file_load").click(function(){
 var intervalId1=setInterval(function(){ 
       
        if((parent.$('#cb_file_id').val()).length != 0){
           // alert('rr');
         //  parent.$('#insertCheckr2nd').val($('#insertCheckr').val()) ;
         $('#radio_nofile').removeAttr("checked")
         $("#txt_file_name").val(parent.$("#cb_file_id").val());
	$("#txt_file_title").val(parent.$("#cb_file_title").val());
	parent.$("#cb_file_id").val('');
           clearInterval(intervalId1);
        }
        },500);
        });


</script>
