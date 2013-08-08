<?php echo $form->open();?>
   
    <div id="createneworg" style="background-color:#BAC7FC;border: none">
    	
        <div class="content">
        	
            <h1>CREATE NEW ORGANISATION</h1>
            
            <div class="box-1">
            	<h2>organisation details</h2>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="15%" valign="top"><p>Name:</p></td>
                        <td width="70%" valign="top"><?php echo $form->build_field('names'); ?><p>(Not limited to list)</p></td>
                        <td valign="top"></td>
                    </tr>
                    <tr>
                    	<td valign="top"><p>Section:</p></td>
			<td valign="top"><?php echo $form->build_field('sections'); ?><p>(Not limited to list)</p></td>
                        <td valign="top"><h6>(Optional)</h6></td>
                    </tr>
                </table>
            </div>
            
            <div class="box-3">
            	<h2>contact details</h2>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="15%" valign="top"><p>Name:</p></td>
                         <td width="50%" valign="top"><?php echo $form->build_field('titles') ?><H6>(Not limited to list)</H6></td>
                        <td valign="top"><h6>(eg. , Mr, Ms, Dr, etc.)</h6></td>
                    </tr>
                    <tr>
                    	<td valign="top"><p>First Name:</p></td>
                        <td valign="top"><?php echo $form->build_field('fname') ?></td>
                        <td valign="top"></td>
                    </tr> <tr>
                    	<td valign="top"><p>Last Name:</p></td>
                        <td valign="top"><?php echo $form->build_field('lname') ?></td>
                        <td valign="top"></td>
                    </tr>
                  
                </table>
            </div>
            <table width='80%' border="0" style="margin-left:55px;"><tr><td>
            <div   class="box-4">
            	<h2>Created by</h2>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="50%" valign="top" align="center"><?php echo $form->build_field('createdby') ?></td>
                    </tr>
                </table>
            </div>
            
            </td><td>
            <div class="box-2">
            	<div class="rightside">
                    <table ><tr><td> <div class="blk"><?php echo $form->build_field('submit'); ?></div></td>
                            <td><div class="blk"><input type="button" class="button2 " onClick="setDataJs();" value="cancel / close" /></div></td></tr></table>
                   
                    
                </div>
            </div>
            </td></tr></table>
        </div>
        
    </div>
<script type="text/javascript">


    function setDataJs(){
  
 parent.$('body').css('overflow','auto'); 
     parent.$('#NewOrg').dialog('close');
    }
       
     
       $('#IdSubmit').click(function(e){
           
           if($('#form_names').val().length!=0){
               if($('#form_titles').val().length!=0){
                   if($('#form_fname').val().length!=0){
//                       var width =  screen.width;
//                        var height = screen.height;
//                           width = width - 200;
//
// 
//                             if(height>950){
//                                $('#NewOrg').css('overflow','hidden'); 
//                                 height = height-50;
//                                            }
//                             
//                            parent.$('#NewOrgIF').css('width',width);
//                        parent.$('#NewOrgIF').css('height',height);
//                     $( "#NewOrg" ).position({
//                         my: "left-10% center",
//                            at: "right center",
//                        of: $(".main-template")
//    
//                        });
                    }else{
                        alert('Please fill in the contact\'s first name');
                        e.preventDefault();
               }
               }else{
                   alert('Please fill in the contact\'s title');
                     e.preventDefault();
               }
           
           }else{
               alert('Please fill in the organisation\'s name');
               e.preventDefault();
           }
    
 
    //$('#NewOrg').dialog('option', '50px', '50px');
    
    
   //alert('s');
    //$("#NewOrg").dialog( "option", "width", 1000 );
});
</script>