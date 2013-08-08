<?php  //if($quote['Q_LockForm']==1){$class = 'locked';}else{$class='quote_tab_lock';}?>
    <div  class="part-4 <?php //echo $class;?>" id="invoicing">
        <div class="part-2">
        <div class="top-line">
            <h2>JOB NUMBER:</h2>
            
            <div class="box-1"><?php  echo $job['J_FullNumber']; ?></div>
            <h2>STATUS:</h2>
            <div class="box-2">test<?php echo $job['J_InvoiceStatus']; ?></div>
        </div>

        <div class="part-2">

            <div class="mainbox">
                <div class="box-0">
                    <div class="c1">
                        <h2>INVOICE ADDRESSED TO</h2>
                        <p>organisation</p>
                       
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody>
                                <tr>
                                    <td align="center"> <?php echo $form->OR1_FullName; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><p>ABN:</p></td>
                                                    <td><?php echo $form->OR2_ABN; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       
                        <p>contact</p>
                        <?php echo $form->J_YearSeq_pk; ?>
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody>
                                <tr>
                                    <td width="70%"><?php echo $form->J_InvoiceContactID; ?></td>
                                    <td><h6>(Limit to list)</h6></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="blk">
                            <p>invoice address</p>
                            <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                                <tbody>
                                    <tr>
                                        <td width="70%" align="center">
                                       <div id="J_Return" style="background-color: #ffffff; width: 95%; margin: 5px;">
                                        <?php echo $form->J_InvoiceAddress1; ?>
                                             <?php echo $form->J_InvoiceAddress2; ?>
                                         <?php echo $form->J_InvoiceAddress3; ?>
                                         <?php echo $form->J_InvoiceAddress4; ?>
                                     </div>
                                        </td>
                                        <input id="invoicing"  type='button' class="cb iframe button1 copy_address " value="Copy Address" href="<?php echo \Uri::create('contacts/copy_address/'.\Input::get('quote_id').'/?div_id=J_Return&sub_div_id=J_Return'); ?>" />
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="c2">
                        <p>payment method</p>
                        <?php echo $form->J_PaymentMethod; ?>
                    </div>
                    <div class="c3">
                        <p>purchase order number</p>
                        <?php echo $form->Q_PurchaseOrderNumber; ?>
                    </div>
                    <div class="c4">
                        <p>date purchase order received</p>
                       <?php echo $form->J_DatePOReceived; ?>
                        
                    </div>

                </div>

                <div class="box-1">
                    <div class="c1">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td width="40%"><p>full quoted price:</p></td>
                                    <td><?php echo $form->J_FeeDue_Set; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                   
                    <div class="c2">
                        
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody><tr>
                                <td width="40%"><p>fee due:</p></td>
                                <td width="40%" class="hrline"><?php echo $form->J_FeeDue_Set; ?>
                                <td><?php echo $form->fee_due_button; ?></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><?php echo $form->J_FeeJustificationStatus; ?></td>
                                <td class="line">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><h6>FEE JUSTICATION (Test Off.)</h6></td>
                                <td class="line">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><?php echo $form->J_FeeJustification; ?></td>
                                <td class="line">&nbsp;</td>
                            </tr>
                        </tbody></table>
                                    
                    </div>
                    
                    <div class="c3">
                        
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody>
                                <tr>
                                    <td colspan="2" width="80%"><h6>(Invoice admin. locked fields)</h6></td>
                                    <td class="line">&nbsp;</td>
                                </tr>
                                <tr>
                                <td width="30%"><p>Fee due:</p></td>
                                <td class="hrline" style="padding:0px;" ><?php echo $form->J_FeeDueLocked_Set; ?></td>
                                <td class="line" style="background-position-y: 20px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><p>date sent to finance:</p></td>
                                <td><?php echo $form->J_DateSentToFinance; ?></td>
                            </tr>
                            <tr>
                                <td><p>invoice no.:</p></td>
                                <td><?php echo $form->J_InvoiceNumber; ?></td>
                            </tr>
                            <tr>
                                <td><p>invoice date:</p></td>
                                <td><?php echo $form->J_InvoiceDate; ?></td>
                            </tr>
                            <tr>
                                <td><p>paid date:</p></td>
                                <td><?php echo $form->J_PaidDate; ?></td>
                            </tr>
                        </tbody></table>
                    </div>

                </div>


                <div class="box-2">
                    <div class="c1">
                        <p>project code summary</p>
                        <?php echo $form->J_ProjectCodeSummary; ?>
                    </div>
                    <div class="c2">
                        <p>invoice comments (internal)<span>(Highlight <?php echo \Form::checkbox('invoice_tab[J_HighlightInvoiceComment]', 1, $job['J_HighlightInvoiceComment'], array('class' => 'highlighter', 'data-hl_target' => '.comment_highlight','id' => 'com_highlight', NULL)); ?>)</span></p>
                        <?php echo $form->J_InvoiceComments; ?>
                    </div>
                    <div class="c3">
                        <div class="blk">
                            <!--<input href="<?php ///echo \Uri::create('Invoices/billing_info/'.$quote_id); ?>" type="button" value="billing info." class="button1">-->
                        <button onclick="Javascript:alert('Word Template');" class="button1">billing info.</button>
                        </div>
                    </div>
                </div>

                <div class="lastbutton">
                    <div class="blk">
                        <input type="submit" name="save" value="save &amp; close" class="button1 save_cancel" />
                        <input type="submit" value="Cancel" class="button1 save_cancel" />
                    </div>
                </div>

            </div>


        </div>
    </div>
    </div>


<script type="text/javascript">
        
        function check(conf){
                if(conf == 'conf'){
                        if(confirm('This job is not complete. Do you still want to lock the fee due?')){
                               copy();
                        }
                        return false;
                };
        };
    
        function copy(){
            var fee = $('#fee_due').val();
            $('#fee_due_locked').val(fee);
            return false; 
        };

        $(document).ready(function(){
            
        $('#fee_due_locked').change(function(){
            var fee_due_locked = $(this).val();
            var numbers = /^[0-9]*\$?[0-9]*\.?[0-9]*$/;
            
            if(fee_due_locked.match(numbers))
            { 
              var set_value = $(this).val().replace('$','')
              $(this).val('$'+set_value)
              return true;  
            }else{  
                alert('Please input numeric characters only ');  
                $(this).focus();  
                return false;  
            }  
        });
            
            $('.copy_address').colorbox({inline:true});
            
            $('.copy_address').click(function(){
                    var id = $(this).attr('id');
                    var address = $('.'+id+'-address').val();
                    
                    $('#invoice-address').text(address);
                    $.colorbox.close();
            });
        });
</script>