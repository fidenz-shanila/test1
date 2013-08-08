<form action=" <?php echo \Uri::create('files/update_cb_file_form');?>" method="post" id="form_save" >
<div id="file_location">
    	
        <div class="content">
        	
            <h1>CB FILE: <?php echo $CF_FileNumber_pk; echo $form->CF_FileNumber_pk;?> CONTENTS</h1>

           <div class="box-1">
             <table class="table-2">
            	 <tr>
            		 <td colspan="4">
             			<h3>FILE TITLE (as in TRIM)</h3>
             		</td>
             </tr>
             <tr>
             	<td colspan="3" style="text-align:center;"><?php echo $form->CF_Title;?></td>
             </tr>
             <tr>
            	 <td>
                 <h3>CURRENT LOCATION</h3>
            		 <table cellpadding="0" cellspacing="0" border="0" class="table-1">

                	<tr>
                    	<td width="30%"><p>Location <input type="button" class="button2" value="" /></p></td>
                        <td><?php echo $form->CF_FileLocation;?></td>
                    </tr>

                </table>
                
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="30%"><p>Date at location</p></td>
                        <td><?php echo $form->CF_FileLocationDate;?><input type="button" class="button1" value=".." />
                       
                        </td>
                    </tr>
                </table>
               
               </td>
                <td>
            
     
            	<h3>REQUESTED LOCATION</h3>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="30%"><p>Location <input type="button" class="button2" value="" /></p></td>
                        <td><?php echo $form->CF_FileRequestLocation;?></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td width="30%"><p>Date at location</p></td>
                        <td><?php echo $form->CF_FileRequestDate;?><input type="button" class="button1" value=".." /></td>
                    </tr>

                </table>
                <div  style="text-align:right;"> <input type="button" id="btn_change" value="CHANGE" /> </div>
                	
           
                </td>
               </tr>
               <tr>
               <td colspan="3" style="text-align:center;">
               B FILE CONTENTS LISTING (ie., Related records)
               </td>
               </tr>
               <tr>
               <td class="blk"  colspan="2" > 
                   <div  class="grid_box">
              <table width="95%" >
             	 <tr>
                 <td>&nbsp;
                 
                 </td>
             		 <td >
             			 QUOTE NUMBER
             		 </td>
              		<td>
              			OWNER
              		</td>
              	</tr>
                <?php if(isset($cb_file_content) and count($cb_file_content)>0): ?>
      <?php
		 $i	=	0;
                while(count($cb_file_content)>$i)
                {		
	?>
              	<tr >
              		<td><button disabled="disabled">...</button></td>
            		  <td class="grid_q_number"><div><?php echo $cb_file_content[$i]['Q_FullNumber'];?></div></td>
              		 <td class="gridtd"><div class="gridlist"><?php echo $cb_file_content[$i]['OR1_Name_ind'];?></div></td>
              		
             	 </tr>
                 <tr >
              		<td colspan="3" ><textarea name="textarea" disabled="disabled" class="textarea-1"><?php echo $cb_file_content[$i]['A_Description'];?></textarea></td>
              		
             	 </tr>
                 <?php
                	 $i++;
                     }
				 endif; ?>
               
                 <!--//////////////////////////////////-->
                  	<tr>
              		<td>&nbsp;</td>
            		  <td>&nbsp;</td>
              		 <td>&nbsp;</td>
             	 </tr>
              </table>
                   </div>
              	<tr>
             		 <td>
                     
              		</td>
                    <td>
                    
                    </td>
              	</tr>
              </table>
               </td>
               </tr>
               <tr>
               <td>
               <table width="100%" class="table-2">
              	 <tr>
              	 	<td colspan="3">
             			 <h3>
              				 DIRECTORY PATH
               			</h3>
               		</td>
              	 </tr>
                 <tr>
                 <td width="95%">
                 <?php echo $form->CF_DirectoryPath; ?>
                 </td>
                 <td>
                 <div class="blk"> <button disabled="disabled" >OPEN</button></div>
                 </td>
                 <td>
                	<div class="blk">	<button disabled="disabled" >CREATE</button></div>
                 </td>
                 </tr>
               </table>
               </td>
               </tr>
                </table>

           </div>
            
            <div class="box-2">
            	<div class="rightside">
               		<div class="blk"><input type="button" class="button2" value="UPDATE" id="btn_update"  onclick=""/></div>
                	<div class="blk"><input type="button" class="button2" value="CLOSE"  onclick="javascript:parent.jQuery.fn.colorbox.close();"/></div>
                </div>
            </div>
            
            
            
            
            
        </div>
        
    </div>
</form>
<script type="text/javascript">
$("#btn_change").click(function(){
	 $.colorbox({ width: "70%", height: "380px", iframe: true, href: " <?php echo \Uri::create('files/list_quote_files_sub?CF_FileNumber_pk=' . $_GET['CF_FileNumber_pk']);?>" });
});

$("#btn_update").click(function(){
	$("#form_save").submit();
});

$( ".date_picker" ).datepicker({ altFormat: "yy-mm-dd" });


</script>
