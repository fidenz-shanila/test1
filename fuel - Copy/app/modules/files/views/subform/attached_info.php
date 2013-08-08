<?php echo $form->open(array('onsubmit'=>'return form_add_log()','enctype'=>"multipart/form-data")); ?>

<div id="attachinfo">
        <div class="part-2">
        <div class="mainbox">
            <div class="div_1">
				<div class="blk1" id="add_log">
                    <div class="c1">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                                <td align="center"><h6>entry date</h6></td>
                            </tr>
                            <tr>
                                <td align="center"><p>DATE (dd/mm/yy)</p></td>
                            </tr>
                            <tr>
                                <td align="center"><?php echo $form->build_field('date'); ?></td>
                            </tr>
                            <tr>
                                <td align="center"><p>TIME (00:00 24 hr)</p></td>
                            </tr>
                            <tr>
                                <td align="center"><?php echo $form->build_field('time'); ?></td>
                            </tr>
                        </tbody></table>
                    </div>
                  <div class="c2">
                    <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody><tr>
                                <td width="50%" align="center" class="one border-right border-bottom"><p>ENTERED BY</p><?php echo $form->build_field('AI_CreatedBy'); ?></td>
                                <td align="center" class="border-bottom"><p>TYPE</p>
                                    <?php //echo \Form::select('infoType', null, $info_types); ?>
									<?php echo $form->build_field('AI_Type'); ?>
                                    <?php echo $form->build_field('quote_id');?>
									
									<?php echo $form->build_field('CF_FileNumber_pk'); ?>
                                </td>
                            </tr>
                      </tbody></table>
                      <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                          <tbody>
                              <tr>
                                <td colspan="2" align="center"><p>PATH TO INFO (optional)</p></td>
                              </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <?php echo $form->build_field('file_upload');?>
                                   
                                </td>
                            </tr>
                            <tr>
                              <td width="80%" align="center">&nbsp;</td>
                              <td width="20%" align="right"><input type="button" value="go" disabled="disabled" class="gobutton cb iframe " /></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="c3">
                        <p>DESCRIPTION <span>(max=300 char, size=<i class=no>0</i>, <br><i class=count>click</i>)</p>
                        <?php echo $form->build_field('AI_Description'); ?>
                        <?php echo $form->build_field('AI_Reference');?>
                    </div>
                    <div class="c4">
                        <input type="submit" class="addbutton"  value="">
                    </div>
                </div>
<?php echo $form->close(); ?>
                <div class="blk2">
                    <h2>INFORMATION LOG</h2>
                    
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody><tr>
                                <td width="20%" valign="top"><p>date</p></td>
                                <td width="10%" valign="top"><p>ref</p></td>
                                <td width="20%" valign="top"><p>entered by</p></td>
                                <td width="15%" valign="top"><p>type</p></td>
                                <td valign="top"><p>description</p></td>
                            </tr>
								
                                <?php 
								$x = 0;
								foreach($info_log as $entry):
								$x++;
								 ?>
                                <form action="<?php echo \Uri::create('files/update_attached');?>" method="post" enctype="multipart/form-data" onsubmit="call_to_validate('<?php echo $x; ?>')">
                            <tr>
                              <td valign="top" colspan="5">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                                        <tbody><tr>
                                            <td width="20%"><h6><?php echo $entry['DaysAgo']; ?></h6></td>
                                            <td width="10%" align="center"><input type="text" name="AI_Reference" id="AI_reference<?php echo $x;?>" value="<?php echo $entry['AI_Reference']; ?>" class="textbox-1"></td>
                                            <td width="20%" align="center"><input type="text" disabled="disabled" value="<?php echo $entry['AI_CreatedBy']; ?>" class="disabled"></td>
                                            <td width="15%" align="center"><input type="text"  disabled="disabled"  value="<?php echo $entry['AI_Type']; ?>" class="disabled"></td>
                                          <td valign="top" align="center" rowspan="2"><textarea class="textarea-1" rows="" cols="" name="AI_Description" id="AI_description<?php echo $x; ?>"><?php echo $entry['AI_Description']; ?></textarea>
                                            <input type="submit" name="img_upload" value="Save" class="save" />
                                          
                                            <input type="hidden" name="quote_id" value="<?php echo \Input::param('quote_id');?>" />
                                            <input type="hidden" name="AI_AttachedInfoID_pk" value="<?php echo $entry['AI_AttachedInfoID_pk'];?>" />
                                          </td>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="2">
                                                <div class="c1">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody><tr>
                                                            <td width="50%" align="center"><p>DATE (dd/mm/yy)</p><input value="<?php echo $entry['AI_Date']; ?>" type="text" class="textbox-1 datepicker" id="AI_date<?php echo $x;?>" name="AI_Date"></td>
                                                            <td align="center"><p>TIME (00:00 24hr)</p><input type="text"   disabled="disabled" value="<?php echo $entry['time']; ?>" class="disabled"></td>
                                                        </tr>
                                                    </tbody></table>
                                                </div>
                                            </td>
                                            <td align="center" colspan="2">
                                                <div class="c2">
                                                  <table width="256" border="0" cellpadding="0" cellspacing="0" class="table-2">
                                                    <tr>
                                                      <td width="168"><p>PATH</p></td>
                                                      <td width="44"><input type="button" class="button2 cb iframe" value="move" href="<?php echo \Uri::create('Files/move_attached/?quote_id='.\Input::param('quote_id').'&AI_CF_FileNumber_fk='.$entry['AI_CF_FileNumber_fk'].'&AI_AttachedInfoID_pk='.$entry['AI_AttachedInfoID_pk']); ?>" /></td>
                                                      <td><input type="button" class="button3 action-delete" data-object="attached info" value="delete" href="<?php echo \Uri::create('Files/delete_attached?AI_AttachedInfoID_pk='.$entry['AI_AttachedInfoID_pk'].'&quoteid='.$quote); ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2"><input type="text" disabled="disabled" value="<?php echo $entry['AI_Path']; ?>" class="disabled box" />
                                                        <input type="hidden"  value="<?php echo $entry['AI_Path']; ?>" name="AI_Path" /></td>
                                                      <td width="44"><input type="button" class="button1 cb iframe" value="go" href="<?php echo \Uri::create('files/view_attached_doc/?AI_Path='.$entry['AI_Path'].'&quote_id='.\Input::param('quote_id')); ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="3"><input  class="box" type="file" name="file_up"  /></td>
                                                    </tr>
                                                  </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            </form>
                          <?php endforeach; ?>
                        </tbody></table>
                    
                </div>
				
				
                </div>
        </div>
</div>
		
		
		
		<script type="text/javascript">
				$(document).ready(function(){
				
						$('.count').click(function(){
								var comment_length = $('.no').text($('.attach_comment').val().length);
                                                                if(comment_length>250){
                                                                    alert('The description is '+comment_length+' characters long. The maximum is 250, please rectify.');
                                                                }
						});
						
				
				
				});
				
				function form_add_log(){ 
					//window.open("file:///E:/PROJECTS/Woodfin Pattern Approval/img/1.gif");
                                                if($('#ai_date').val()==''){
                                                    alert('You must enter a date');
						    return false;
                                                 }else if($('#ai_time').val()==''){
                                                      alert('You must enter a time');
						      return false;
                                                 }else if($('#sel_type').val()==''){
							alert('You must enter a type');
							return false;
						}else if($('#ai_description').val().length<3){
						     alert('You must enter Keywords and Notes');
						     return false;
						}else if($('#ai_description').val().length>250){
                                                    alert('The description is '+$('#ai_description').val().length+' characters long. The maximum is 250, please rectify.');
						    return false;
                                                }
                                        
				}
                                $('#ai_time').click(function(){
     
                                })
		</script>
		
