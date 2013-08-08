
<div id="chng_fee_due">
	<div class= "content">
		
		<h1>CHANGE FEE DUE</h1>
	
		<div class="inner">
		<?php	//print_r($works); ?>
                    <div class="form_line_box">     
                    <?php
                    $full_quote_price ='';
                    for($x=0;$x<count($works);$x++){?>
			<div class="inner-form">

				<h1><?php echo $works[$x]['WDB_WorkGroupNumberString'];?></h1>
				<table>
					<tr>
						<td>SECTION :</td>
						<td>
                                                    <input type="hidden" value="<?php echo @$works[$x]['WDB_YearSeq_fk_ind']; ?>" id="hid_WDB_YearSeq_fk_ind<?php echo $x;?>" />
                                                    <input type="hidden" value="<?php echo $works[$x]['WDB_WorkDoneBy_pk']; ?>" id="hid_WDB_WorkDoneBy_pk<?php echo $x;?>" />
                                                    <input type="text" disabled="disabled" class="" name="" value="<?php echo $works[$x]['WDB_S_Name']; ?>"></td>
					</tr>

					<tr>
						<td>PROJECT :</td>
						<td><input type="text" disabled="disabled" class="" name="" value="<?php echo $works[$x]['WDB_P_Name']; ?>"></td>
					</tr>

					<tr>
						<td>AREA :</td>
						<td><input type="text" disabled="disabled" class="" name="" value="<?php echo $works[$x]['WDB_A_Name']; ?>"></td>
					</tr>

					<tr>
						<td></td>
						<td style="background-color:#DDBAFC; padding: 5px;">
							<p>TEST OFFICER:</p>
							<?php echo \Helper_Form::list_employees('officer', $works[$x]['WDB_TestOfficerEmployeeID'], array( 'disabled' => 'disabled' ),'disabled','disabled'); ?>
						</td>
					</tr>

				</table>

				<div class="right-box" style="float: right">
					
					<div class="box-fir">
						<p>QUOTED PRICE</p><br/>
						<input type="text" name="" disabled="disabled" class="currency" value="<?php echo $works[$x]['WDB_QuotedPrice']; ?>">
                                                <?php $full_quote_price += $works[$x]['WDB_QuotedPrice'];?>
					</div>
					<div class="box-sec">
						<p>FEE DUE</p><br/>
                                                 <input type="hidden" value="<?php echo $works[$x]['WDB_FeeDue']; ?>" id="hid_fee_due<?php echo $x;?>" />
                                                 <div class="due_input">
                                                <input type="text" id="txt_fee_due<?php echo $x;?>" name="" disabled="disabled" class="fee_due currency" value="<?php echo $works[$x]['WDB_FeeDue']; ?>">
                                                 </div>
                                                <div id="button_div<?php echo $x;?>"><button  id="fee_due_change<?php echo $x;?>" class="save_cancel" onclick="open_change_window(<?php echo $x;?>)">Change</button></div>
					</div>

				</div>
				
				<div class="clear"></div>
			</div>
                    <?php } ?>
                    </div>
			<div class="outer-box ">
				<h2 id="justification"><?php echo $job['J_FeeJustificationStatus'];?></h2>
                                <input type="hidden" value="<?php echo $job['J_FeeJustificationStatus'];?>" name="J_FeeJustificationStatus" id="J_FeeJustificationStatus" />
				<p>FEE JUSTIFICATION</p>
                                <textarea id="justification_text" > <?php echo $job['J_FeeJustification'];?></textarea>
			</div>

			<div class="outer">
				<div class="cr">
					<p>FULL QUOTED PRICE:</p>
					<input type="text" class="currency txt_bold" disabled="disabled" id="full_quoted_price" value="<?php echo $full_quote_price; ?>">
					<div class="clear"></div>
				</div>
				<br/>
				<div>
					<p>TOTAL FEE DUE:</p>
                                        <input type="hidden" value="<?php echo $job['J_FeeDue']; ?>" id="hid_total_fee_due" />
                                        <input type="text" class="currency txt_bold" id="total_fee_due" disabled="disabled" value="<?php echo $job['J_FeeDue']; ?>">
					<div class="clear"></div>
				</div>
                                <br /><br />
                                <div>
				<button   class="" id="Save" style="float: right; font-weight: bold; padding: 5px 10px">SAVE</button>
                               <button   class="" id="close" onclick="Javascript:parent.$.colorbox.close();" style="float: right;  padding: 5px 10px">CANCEL</button>
                                </div>
                                </div>

			<div class="clr"></div>

                               

		</div>
             
		
		<script>

                   function change_value(val,x)
                   {
                       $('#txt_fee_due'+x).val(val);
                   }
                          
                         $('#Save').click(function(){
                               $('#justification_text').attr('disabled','disabled');
                               var justification = $('#justification_text').val();
                               var justification_lable = $('#J_FeeJustificationStatus').val();
                               var total_fee_due = set_number_format($('#total_fee_due').val());
                               var full_quoted_price = set_number_format($('#full_quoted_price').val());
                               var error_count = 0;

                               
                                for(p=0;p<<?php echo count($works);?>;p++){ 
                                    var hid_fee =   $('#hid_fee_due'+p).val();
                                    var fee     =   $('#txt_fee_due'+p).val();
                                    var hid_WDB_YearSeq_fk_ind = $('#hid_WDB_YearSeq_fk_ind'+p).val();
                                    var hid_WDB_WorkDoneBy_pk = $('#hid_WDB_WorkDoneBy_pk'+p).val();
                                    
                                        fee = set_number_format(fee);
                                        hid_fee = set_number_format(hid_fee);
                                        
                                    if(hid_fee!=fee){
                                        if(total_fee_due!=full_quoted_price){
                                            if($('#justification_text').val().length<3){
                                                 alert('Please provide fee justification');
                                                $('#justification').text('Fee justification required');
                                                $('#J_FeeJustificationStatus').val('Fee justification required');
                                                $('#justification_text').removeAttr('disabled','disabled');
                                                error_count = 1;
                                            }
                                        }
                                        if(error_count==0){
                                                var J_FeeDue =0;
                                                J_FeeDue = get_total();
                                                $.ajax({
                                                        url  : "<?php echo \Uri::create('jobs/edit_fee_due'); ?>",
                                                        type : "GET",
                                                        data : { 'J_FeeJustificationStatus':justification_lable,'J_FeeDue':J_FeeDue,'J_YearSeq_pk':hid_WDB_YearSeq_fk_ind,'J_FeeJustification':justification, 'WDB_FeeDue' : fee, 'WDB_WorkDoneBy_pk' : hid_WDB_WorkDoneBy_pk },
                                                        success : function(data){
                                                                data = $.formatNumber(data, {format:"$#,###.00", locale:"au"});
                                                                $('#total_fee_due').val(data);
                                                                parent.changeFeeDue(data);
                                                                //alert('Fee due edit success.');
                                                                setTimeout(parent.$.colorbox.close(),1000);

                                                        }
                                                });
                                            }
                                        
                                    }
                                }
                                 
			}) 
                        
                        function set_number_format(number)
                        {
                             number = number.replace('$','');
                             number = number.replace(',','');
                             number = parseFloat(number);
                             return number;
                        }
                        
                        function get_total(){
                            var sum = 0;  
                             $('.due_input input').each (function(){ sum+=set_number_format($(this).val()); });
                            return sum;
                        }
                            
                        function change_fee_justification(){
                            var hid_total = set_number_format($('#hid_total_fee_due').val());
                            var total_due = set_number_format($('#total_fee_due').val());
                            
                            var full_quoted_price = set_number_format($('#full_quoted_price').val());
                            
                            if(hid_total!=total_due){
                                $('#justification').html('Fee justification required');
                                $('#J_FeeJustificationStatus').val('Fee justification required');
                                $('#justification_text').removeAttr('readonly');
                            }
                            if(full_quoted_price==total_due){
                                $('#justification').html('No fee justification required');
                                $('#J_FeeJustificationStatus').val('No fee justification required');
                                $('#justification_text').attr('disabled','disabled');
                            }
                        }
                        
 
                        function open_change_window(x){
                            var fieldval = $('#txt_fee_due'+x).val();
                            $('#justification_text').removeAttr('disabled','disabled');
                            var url ="<?php echo \Uri::create('jobs/change_fee_due_window/?x=');?>"+x+"&val="+fieldval;
                            $.colorbox({width:"250px", height:"250px", iframe:true, href:url});                            
                        }
                        
                        function update_total_due(){ 
                            var data = get_total();
                            var number = $.formatNumber(data, {format:"$#,###.00", locale:"au"});
                            $('#total_fee_due').val(number);  
                            change_fee_justification();
                        }


		</script>


	</div>
</div>