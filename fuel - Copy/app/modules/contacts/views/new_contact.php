
<form action="" method="post">
	
<div class="new_contact" >

	<h1>CREATE NEW CONTACT</h1>

	<div id="contact_inner">
		<table border="0">
			<tr>
				<td align="right">Title :</td>
				<td><?php echo $form->build_field('title'); ?></td><td align="left">(Not limited to list)</td>
			</tr>
			<tr>
				<td align="right">First Name :</td>
				<td><?php echo $form->build_field('first_name'); ?></td>
			</tr>
			<tr>
				<td align="right">Last Name :</td>
				<td><?php echo $form->build_field('last_name'); ?></td>
			</tr>
			<tr><?php echo $form->build_field('hiddenTitle'); ?><?php echo $form->build_field('hiddenTitleKeyUp'); ?>
				<td ></td>
				<td align="right">
					<input type="submit" class="spaced" id="submitInsertIId" style="font-weight:bold;" value="Insert">
					
				</td>
                               
                                <td>
                                     <input type="button" id="insertCloseId" class=" spaced" onclick="closeIframeInsertCon()" value="CANCEL/CLOSE">
                                    </td>
			</tr>
		</table>
	</div>


</div>

</form>
<script>
      function closeIframeInsertCon()
{
    parent.$('#dialog').dialog('close');
}

$('#submitInsertIId').click(function(e){
    
	var form_first_name=$("#form_first_name").val();
         var form_last_name=$("#form_last_name").val();
             
                
//alert(form_first_name.length);
                 if(form_first_name.length ==0){
                    alert("You must enter a first name");
                }else{
                    if(form_last_name.length ==0){
                    alert("You must enter a last name");
                }
                }
                
		
                
               
                
                
                
	});
        
        $('#submitInsertIId').click(function(e){
            var form_title=$("#InsertConTitleHiddenKeyUpId").val();
            if(form_title.length<6 ){
                   // alert(array_ContractExpiryDate[2]);
                   //alert(get_email_val[1]);
			return true;
		}
		else {
                    alert('Title is limited to 5 characters, you have '+form_title.length+' charcaters');
                    e.stopImmediatePropagation();		
                     e.preventDefault();
			return false;
		}
        });
        
          $('#submitInsertIId').click(function(e){
                 var form_first_name=$("#form_first_name").val();
             if(form_first_name.length<25 ){
                   // alert(array_ContractExpiryDate[2]);
                   //alert(get_email_val[1]);
			return true;
		}
		else {
                    alert('First name is limited to 25 characters, you have '+form_first_name.length+' charcaters');
                    e.stopImmediatePropagation();		
                     e.preventDefault();
			return false;
		}
        });
        
          $('#submitInsertIId').click(function(e){
              var form_last_name=$("#form_last_name").val();
             if(form_last_name.length<25 ){
                   // alert(array_ContractExpiryDate[2]);
                   //alert(get_email_val[1]);
			return true;
		}
		else {
                    alert('First name is limited to 25 characters, you have '+form_last_name.length+' charcaters');
                    e.stopImmediatePropagation();		
                     e.preventDefault();
			return false;
		}
               
        });
         $('#InsertConTitle').change(function(){
            // alert('ald');
            $('#InsertConTitleHiddenKeyUpId').val('');
              $('#InsertConTitleHidden').val($('#InsertConTitle').val());
             });
             
              $('#InsertConTitle').keyup(function(){
            //alert('ald');
            $('#InsertConTitleHidden').val('');
              $('#InsertConTitleHiddenKeyUpId').val($('#InsertConTitle').val());
             });
         
        
    </script>
  