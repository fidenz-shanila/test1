<div id="receipt">
    <div class="part-2">
        <div class="top-line">
            <h2>QUOTE NUMBER:</h2>
            <?php echo $form->RD_YearSeq_pk; ?>
            <div class="box-1"><?php echo $receipt['Q_FullNumber']; ?></div>
            <h2>STATUS:</h2>
            <div class="box-2"><?php echo $receipt['FullStatusString']; ?></div>
        </div>

        <div id="content">

            <div class="column1-p-2">
                <div class="box_1">
                    <h3>RECEIPT</h3>
                    <div class="r1">
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tbody><tr>
                                    <td width="40%"><p>Received By:</p></td>
                                    <td>
                                        <?php echo \Helper_Form::list_employees('receipt_tab[RD_ReceivedByEmployeeID]', $receipt['RD_ReceivedByEmployeeID']); ?>
                                    </td>
                                </tr>
                            </tbody></table>
                    </div>
                    <div class="r2">
                        <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                            <tbody><tr>
                                    <td width="40%" class="onetd">
                                        <?php echo $form->RD_mail; ?>
                                    <td width="25%"><p>Receipt date:</p></td>
                                    <td><?php echo $form->RD_ReceivedDate; ?></td>
                                </tr>
                            </tbody></table>
                    </div>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-3">
                        <tbody><tr>
                                <td width="30%"><p>Delivered by:</p></td>
                                <td><?php echo $form->RD_DeliveredBy; ?></td>
                            </tr>
                            <tr>
                                <td><p>Con note:</p></td>
                                <td><?php echo $form->RD_DeliveryConNote; ?></td>
                            </tr>
                        </tbody></table>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-4">
                        <tbody>
                              <tr>
                                <td>
                                   
                                    <button class="button1 cb iframe" href="<?php echo \Uri::create('Receipts/view_img_display/' . $RD_YearSeq_pk); ?>" >GO</button>
                                </td>
                            </tr>
                            <tr>
                                <td width="80%" align="center"><iframe src="<?php echo \Uri::create('Receipts/upload_main_image/' . $RD_YearSeq_pk); ?>" style="border: 0px;  height: 45px;" scrolling="no"></iframe></td>
                            </tr>


                        </tbody></table>

                </div>

                <div class="box_2 formbox">
                    
                    <h2>INTERNAL DELIVERY INSTRUCTIONS</h2>
                    <h3>( Note from Test Officer to Store)</h3>
                    <?php echo $form->Q_DeliveryInstructions; ?>
                    <h2>PURCHASE ORDER NUMBER</h2>
                    <?php echo $form->Q_PurchaseOrderNumber; ?>
                </div>

                <div class="box_3">
                    <h2>INSURANCE INSTRUCTIONS</h2>
                    <?php echo $form->RD_InsuranceInstructions; ?>
                    <div class="r1">
                        <p>Value for customs: </p>
                        <?php echo $form->RD_AustValueForCustomsPurposes; ?>
                    </div>
                </div>

            </div>


            <div class="column2-p-2">
                <div class="box_1">
                    <h3>SHIPPING</h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                        <tbody><tr>
                                <td width="40%"><p>Shipping mode:</p></td>
                                <td><?php echo $form->RD_ShippingMode; ?></td>
                            </tr>
                            <tr>
                                <td width="40%"><p>Shipping urgency:</p></td>
                                <td><?php echo $form->RD_ShippingUrgency; ?></td>
                            </tr>
                            <tr>
                                <td width="40%"><p>Carrier name:</p></td>
                                <td><?php echo $form->RD_CarrierName; ?></td>
                            </tr>
                            <tr>
                                <td width="40%"><p>Carrier account no.:</p></td>
                                <td><?php echo $form->RD_CarrierAccountNumber; ?></td>
                            </tr>
                            <tr>
                                <td width="40%"><p>Carrier contact:</p></td>
                                <td><?php echo $form->RD_CarrierContactPerson; ?></td>
                            </tr>
                            <tr>
                                <td width="40%"><p>Carrier contact phone:</p></td>
                                <td><?php echo $form->RD_CarrierContactPhone; ?></td>
                            </tr>
                        </tbody></table>
                </div>
                <div class="box_2">
                    <h3>INSTRUMENT RETURNED TO</h3>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                        <tbody><tr><td><h3>Contact and phone ( editable )</h3></td></tr>
                            <tr><td><?php echo $form->RD_ReturnContact; ?></td></tr>
                            <tr><td><h3>Organisation ( editable )</h3></td></tr>
                            <tr><td><?php echo $form->RD_ReturnOrganisation; ?></td></tr>
                            <tr><td><h3>Address ( editable )</h3></td></tr>
                            <tr><td>
                                
                                    <div id="RD_Return" style="background-color: #ffffff; width: 95%; margin: 5px;">
                                    <?php echo $form->RD_ReturnAddress1; ?>
                                         <?php echo $form->RD_ReturnAddress2; ?>
                                         <?php echo $form->RD_ReturnAddress3; ?>
                                         <?php echo $form->RD_ReturnAddress4; ?>
                                     </div>
                                </td></tr>
                        </tbody></table>
                    <div class="r1">
                        <div class="c1">
                            <input href="<?php //echo \Uri::create('Receipts/generate_dispach/f/' . $RD_YearSeq_pk); ?>" type="button" class="button1" onclick="Javascript:alert('word template');" value="DESPATCH FORM">
                        </div>
                         <div class="c1">
                            <input href="<?php //echo \Uri::create('Receipts/generate_dispach/l/' . $RD_YearSeq_pk); ?>" type="button" onclick="Javascript:alert('word template');" class="button1" value="DESPATCH LABEL">
                        </div>
                        <div class="c2">
                            <!--<button class="cb button1 copy_address" href="#view_address">Copy Address</button>-->
                            &nbsp;-&nbsp;
                            <input type='button' class="cb iframe " value="Copy Address" href="<?php echo \Uri::create('contacts/copy_address/'.\Input::get('quote_id').'/?div_id=RD_Return&sub_div_id=RD_return'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="box_3">
                    <h3>INSTRUMENT PACKAGING REQUIREMENTS <span>(Highlight:<?php echo \Form::checkbox('receipt_tab[RD_HighlightPackagingRequirements]', 1, $receipt['RD_HighlightPackagingRequirements'], array('class' => 'highlighter', 'data-hl_target' => '.comment_highlight','id' => 'com_highlight', NULL)); ?>:)</span></h3>
                    <?php echo $form->RD_PackagingRequirements; ?>
                </div>
            </div>


            <div class="column3-p-2">
                <div class="box_1">
                    <h3>DESPATCH</h3>
                    <div class="r1">
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <td width="40%"><p>Received By:</p></td>
                            <td>
                                <?php echo \Helper_Form::list_employees('receipt_tab[RD_DespatchedByEmployeeID]', $receipt['RD_DespatchedByEmployeeID']); ?>
                            </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <div class="r2">
                        <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                            <tbody><tr>
                                    <td width="40%" class="onetd"></td>
                                    <td class="sectd"><p>Receipt date:</p><?php echo $form->RD_DespatchedDate; ?></td>
                                </tr>
                            </tbody></table>
                    </div>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-3">
                        <tbody><tr>
                                <td width="30%"><p>Delivered by:</p></td>
                                <td><?php echo $form->RD_PickedUpBy; ?></td>
                            </tr>
                            <tr>
                                <td><p>Con note:</p></td>
                                <td><?php echo $form->RD_DespatchConNote; ?></td>
                            </tr>
                        </tbody></table>
                    <table cellspacing="0" cellpadding="0" border="0" class="table-4">
                        <tbody><tr>
                                 <td>
                                    <button class="button1 cb iframe" href="<?php echo \Uri::create('Receipts/view_img_display/' . $RD_YearSeq_pk . '?type=d'); ?>" >GO</button>
                                </td>
                            </tr>
                            <tr>
                                <td width="80%" align="center"><iframe src="<?php echo \Uri::create('Receipts/upload_main_image_despatch/' . $RD_YearSeq_pk); ?>" style="border: 0px; height: 45px;"scrolling="no"></iframe></td>
                               
                            </tr>
                        </tbody></table>

                </div>


                <div class="box_2 cal_size">
                    <h3>COMMENTS <strong>(max=300 char, size=<i>0</i>, <i class="click">click</i>)</strong><span>(Highlight <?php echo \Form::checkbox('receipt_tab[RD_HighlightComment]', 1, $receipt['RD_HighlightComment'], array('class' => 'highlighter', 'data-hl_target' => '.comment_highlight_2','id' => 'com_highlight', NULL)); ?> )</span></h3>
                    <?php echo $form->RD_Comments; ?>
                </div>

                <div class="box_3">
                    <div class="blk">
                        <input href="<?php //echo \Uri::create('Receipts/custom_proform_invoice/' . $RD_YearSeq_pk); ?>" onclick="Javascript:alert('word template');" type="button" class="button1" value="CUSTOME PROFORMA INVOICE">
                    </div>
                </div>

                <div class="box_4">
                    <div class="blk2">
                        <input type="submit" name="save" value="Save &amp; Close" class="button1 save_cancel" />
                        <input type="submit" class="button1 save_cancel" name="cancel" value="Cancel" />
                    </div>
                   
                    <div class="blk" id="Recipt_Despatch"><p>Receipt and Despatch N/A: </p> <?php echo \Form::checkbox('receipt_tab[RD_NotApplicable]', 1, $receipt['RD_NotApplicable'] == 0 ? false : true); ?></div>

                </div>


            </div>



        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        $('.address').click(function(){
            var id = $(this).attr('id');
            var address = $('.'+id+'-address').val();

            $('#return-address').text(address);
            $.colorbox.close();
        });

  
        //Receipt and Despatch N/A:
        $('#Recipt_Despatch input').click(function(){ 
            $(this).closest('form').append('<input type="hidden" name="save" value="1" />').submit();
        });   
        
    });
</script>