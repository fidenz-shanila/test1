<form action="<?php echo \Uri::create('files/move_attached_info');?>" method="post" onsubmit="return form_validate()">
    <div id="moveattached">
    	
        <div class="content">
        	
            <h1>MOVE ATTACHED INFORMATION</h1>
            
            <div class="box-1">
            	<div class="c1">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        <tr>
                            <td width="15%"><p>FROM:</p></td>
                            <td width="30%"><input type="text" class="textbox-1" disabled="disabled" id="cb_file_from" value="<?php echo $field['AI_CF_FileNumber_fk'];?>"/>
                                <input type='hidden' value="<?php echo $field['AI_CF_FileNumber_fk'];?>" name="from_AI_CF_FileNumber_fk" />
                                <input type="hidden" value="<?php echo $field['AI_AttachedInfoID_pk'];?>" name="from_AI_AttachedInfoID_pk" />
                                <input type="hidden" value="<?php echo $field['quote_id'];?>" name="quote_id" />
                               
                            </td>
                            <td width="10%" class="bor-left bor-top bor-bottom"><p>TO:</p></td>
                            <td width="30%" class="bor-top bor-bottom"><input type="text" id="cb_file_to" name="to_AI_CF_FileNumber_fk" class="textbox-1 cb_file_id" /></td>
                            <td class="bor-right bor-top bor-bottom">
                             <button class="cb iframe button1"  href="<?php echo Uri::create('files/?is_selectable=true');?>">SELECT</button></td>
                        </tr>
                    </table>
                </div>
                
            </div>
            
            
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button1" value="do it" /></div>
                    <div class="blk"><input type="button" class="cb iframe close button2" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

</form>

<script type="text/javascript">
     function form_validate(){
         if($('#cb_file_to').val()==''){
             alert('Please select the CB File to move the information to.');
             return false;
         }else if($('#cb_file_to').val()==$('#cb_file_from').val()){
             alert('You cannot move the info to the same CB File.  Operation cancelled.');
             return false;
         }
     }
    </script>