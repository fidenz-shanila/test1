<?php  if($quote['Q_LockForm']==1){$class = 'locked';}else{$class='quote_tab_lock';}?>

<div  class="part-2 <?php echo $class;?>" id="quote_tab">
    <div style="background-color: #FCDE83; margin: 10px;">
    <div class="tital_line">
        <?php echo $form->Q_YearSeq_pk; ?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="20%"><h1>quote number:</h1></td>
                <td width="15%"><input type="text" class="textbox-1" value="<?php echo $quote['Q_FullNumber']; ?>" ></td>
                <td width="10%"><h1>Status:</h1></td>
                <td><input type="text" class="textbox-1" value="<?php echo $quote['FullStatusString']; ?>"></td>
            </tr>
        </tbody></table>
    </div>
    <div class="cl1">
        <div class="box-0">
            <h1>Appears on quote</h1>
            <div class="r1">
                <h2>1) PREPARED BY (Test Officer)</h2>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1 prepared">
                    <tbody><tr>
                        <td align="center" width="80%"><?php echo \Helper_Form::list_employees('quote_tab[Q_PreparedByEmployeeID]', $quote['Q_PreparedByEmployeeID'] ,$lock['AdminEdit'],$lock['AdminEdit']);?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="r2"> 
                <h2>2) DATES</h2>
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    <tbody><tr>
                        <td align="center" width="20%"><p>site visit?</p></td>
                        <td align="center" width="30%"><p id="date_inst">date inst. required</p></td>
                        <td align="center"><p>target report despatch date</p></td>
                    </tr>
                    <tr>
                        <td align="center"><?php echo \Form::checkbox('quote_tab[Q_SiteVisitRequired]', $quote['Q_SiteVisitRequired'], $quote['Q_SiteVisitRequired'] == 0?false:true,$lock['AdminEdit']=='disabled'?array('disabled'=>'disabled'):array('id'=>'Q_SiteVisitRequired')); ?><div id="div_site_visit_msg">No</div></td>
                        <td align="center"><?php echo $form->Q_DateInstRequired; ?></td>
                        <td align="center"><?php echo $form->Q_TargetReportDespatchDate; ?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="r3 cal_size">
                <h2>3) SERVICES OFFERED<span>(max=300 char, size=<i>0</i>, <i class="click">click</i>)</span></h2>
                <?php echo $form->Q_ServicesOffered; ?>
              
            </div>
            <div class="r4">
                <h2>4) CERTIFICATE OFFERED<span>(Limit to list)</span></h2>
                <?php echo $form->Q_CertificateOffered; ?>
            </div>
            <div class="r3 cal_size">
                <h2>5) SPECIAL CONDITIONS<span>(max=300 char, size=<i>0</i>, <i class="click">click</i>)</span></h2>
                    <?php echo $form->Q_SpecialRequirements; ?>
                 <button type="button" <?php echo $lock['AdminEdit'];?> id="RetButton" class="cb iframe" href="<?php echo \Uri::create('quotes/load_ret/'.\Input::get('quote_id'));//.'?Q_DR='.$quote['Q_DateInstRequired'].'&Q_SR='.$quote['Q_SpecialRequirements']);?>" >Ret.</button>


                
                
            </div>
        </div>
        
        <div class="box-1">
            <h1>Does not appear on quote</h1>
            <div class="r1">
                <h2>6a) TEST METHOD<span>(Not limited to list and Optional)</span></h2>
               <?php echo $form->A_TestMethodUsed; ?>
            </div>
            <div class="r1">
                <h2>6b) PURCHASE ORDER NO:<span>(Optional)</span></h2>
                <?php echo $form->Q_PurchaseOrderNumber; ?>
            </div>
            <div class="r1">
                <h2>7) DELIVERY INSTRUCTIONS FOR NMI STORE<span>(Optional)</span></h2>
                <?php echo $form->Q_DeliveryInstructions; ?>
            </div>
            <div class="r1 cal_size">
                <h2>Comments<strong>(max=300 char, size=<i>0</i>, <i class="click">click</i>)</strong><span>(Highlight <?php echo \Form::checkbox('quote_tab[Q_HighlightComment]', 1, $quote['Q_HighlightComment'], array('class' => 'highlighter', 'data-hl_target' => '.comment_highlight', $lock['AdminEdit']=>$lock['AdminEdit'])); ?>:)</span></h2>
                <?php echo $form->Q_Comments; ?>
            </div>
        </div>
        
    </div>
    
    <div class="cl2">
        <div class="box-2">
            <h2>8) BUILD PRICE <?php echo $form->BuildPrice;?></h2>
            <div class="worklog_container">
                <iframe src="<?php echo \Uri::create('quotes/mainform_worklog/'.$quote['Q_YearSeq_pk']); ?>" scrolling="no" frameborder="0"></iframe>
            </div>
            <div class="full_quoted_price currency">FULL QUOTED PRICE:  <?php echo $form->Q_QuotedPrice_Set; ?></div>
        </div>
        
        <div class="row-1">
            <div class="box-3">
                <h2>9) OFFER DATE</h2>
                <div class="r2">
                    <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                        <tbody><tr>
                            <td width="40%" align="center"><p>quote offer date</p></td>
                            <td width="30%" align="center"><p>validity period</p></td>
                            <td align="center"><p>expiry date</p></td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $form->Q_OfferDate; ?></td>
                            <td align="center"><?php echo $form->Q_ValidityInDays; ?>(days)</td>
                            <td align="center"><?php echo $form->Q_ExpiryDate; ?></td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            <div class="box-4">	
                <h2>10) REQUEST EMAIL</h2>
                <div class="blk" id="requestMail">
                    <p>
                        <?php //echo $form->RequestEmail;?>
                         <?php echo \Form::checkbox('quote_tab[Q_SendEmail]', 1, $quote['Q_SendEmail'] == 0?false:true,$lock['AdminEdit']=='disabled'?array('disabled'=>'disabled'):array()); ?>
                        Request email confirming quote sent</p>
                </div>
            </div>
        </div>
        
    </div>
    <?php if($current_user['CanLockQuote']==0||$lock['AdminEdit']=='disabled'){$officeLock = 'disabled'; }else{$officeLock = ''; }?>
    <div class="cl3">
        <h2>OFFICIAL USE ONLY</h2>
        <div class="r1">
            <h2>checked by</h2>
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td width="80%" align="center"><?php echo \Helper_Form::list_employees('quote_tab[Q_CheckedByEmployeeID]', $quote['Q_CheckedByEmployeeID'],$officeLock,$officeLock);?></td>
                </tr>
            </tbody></table>
        </div>
        <div class="r2">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td width="50%" align="right"><p>date sent: </p></td>
                    <td align="left"><?php echo $form->Q_DateSent; ?>
                </tr>
                <tr>
                    <td align="right"><p>sent method: </p></td>
                    <td align="left"><?php echo $form->Q_SentMethod; ?></td>
                </tr>
            </tbody></table>
        </div>
        <div class="r3">
            <h2>mail merge</h2>
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td align="center"><?php echo $form->BtnPrintQuotes;?></td>
                </tr>
            </tbody></table>
        </div>
        <div class="r3">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td align="center">
                        <div id="email_user">
                        <?php echo $form->Email_User; ?>
                        </div>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <div class="r2">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td align="right"><p>outcome: </p></td>
                    <td align="left"><?php echo $form->Q_OutCome; ?></td>
                </tr>
                <tr>
                    <td width="50%" align="right"><p>date: </p></td>
                    <td align="left"><?php echo $form->Q_OutComeDate;?></td>
                </tr>
            </tbody></table>
        </div>
        <div class="r5">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td align="center"><?php echo $form->BtnAcceptQutoes; ?></td>
                </tr>
            </tbody></table>
        </div>
        <div class="r6">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td align="center" class="one">
                     <input type="button" <?php echo $officeLock;?>  href="<?php echo Uri::create('files/?is_selectable=true');?>" class="cb iframe button1" value="change cb file" />
                     <?php echo $form->A_CF_FileNumber_fk; ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="two"><input <?php echo $officeLock;?> type="button" value="change owner" class="button1 cb iframe" href="<?php echo \Uri::create("quotes/change_owner/?Q_YearSeq_pk={$quote['Q_YearSeq_pk']}"); ?>"></td>
                </tr>
            </tbody></table>
        </div>
    </div>
 
    <div class="lastbutton"> 
        <div class="rightside">
            <div class="blk1" ><?php if($quote['Q_LockForm']==1){echo '<h1 style="color: red; font-weight: bold;">QUOTE LOCKED</h1>';}?></div>
            <div class="blk1"><input <?php echo $lock['AdminEdit'];?> type="button" value="create batch of quotes based on this quote" class="cb iframe button1" href="<?php echo \Uri::create("quotes/create_batch/?Q_YearSeq_pk={$quote['Q_YearSeq_pk']}&Q_FullNumber={$quote['Q_FullNumber']}"); ?>"></div>
            <div class="blk1"><input <?php echo $lock['AdminEdit'];?> type="button" value="NEW QUOTE BASED ON THIS QUOTE" class="cb iframe button1" href="<?php echo \Uri::create('quotes/new_quote/'.$quote['Q_YearSeq_pk']. '?base_quote=base_quote&Q_YearSeq_pk=' . $quote['Q_YearSeq_pk']) ; ?>"></div>
            
            <div class="blk2 lock" id="lock_quote" data-lock_container=".quote_tab_lock">
                <?php if($current_user['CanLockQuote']==1){?>
                <?php echo \Form::checkbox('quote_tab[Q_LockForm]', 1, $quote['Q_LockForm'] == 0?false:true); ?><p>official use only Lock form</p>
                <?php }else{?>
                <?php echo \Form::checkbox('quote_tab[Q_LockForm]', 1, $quote['Q_LockForm'] == 0?false:true,array('disabled'=>'disabled')); ?><p>You don't have permission to perform this operation.</p>
                <?php } ?>
            </div>
            <div class="blk1">
                <input <?php echo $lock['AdminEdit'];?> type="submit" name="save" value="Save &amp; Update" class="button1 save_cancel" />
                <input type="submit" class="action-cancel button1 save_cancel" onclick="clouseTab();" value="Cancel"  />
            </div>
        </div>
    </div>
    </div>
</div>








<script type="text/javascript">
        $('#email').click(function(){
            var method   = $('.method').val();        
            var datesent = $('.datesent').val();
            var employee_select = $('.employee_select').val();
            
            if( method =='' || datesent =='' ){
                alert ('Please fill in the \'sent method\' and \'date sent\' and save the quote before sending this email.');
                return false;
            
            } else if (employee_select =='') {
                alert('Please ensure \'PREPARED BY (Test Officer)\' is filled in before sending this email.');
                return false;
            }
            
            var link = $(this).attr('href').replace('Q_SentMethod', method).replace('Q_DateSent', datesent);
            $(this).attr('href', link);
            
        });
        
        $('#accept_quote').click(function(){
            var outcome = $('#outcome').val();
            if (outcome != 'Accepted') {
                alert('A job record can only be created after the quote has been accepted.');
                return false;
            }
        });
        

        
        
        /*
         * Email [test officer] button
         */ 
        $('table.prepared .employee_select').on('change', function(){

            var test_officer = $('table.prepared .employee_select option:selected').text();
            $('#email').text('EMAIL '+test_officer);

        });
        
        $('#email').text('EMAIL '+$('table.prepared .employee_select option:selected').text());
        
        
       $("#outcome").change(function(){
          var outComeDate = $("#outcome_data_pic").val();
        if(outComeDate==''){
            $("#outcome_data_pic").attr('style','background-color: red;');
        }else{
            var thisVal   =   $(this).val();
                $.ajax({
                    url:'<?php echo \Uri::create('quotes/update_quotes/'.@$quote['Q_YearSeq_pk']);?>?string='+thisVal+'&outDate='+outComeDate
                }).done(function(data){
                    //alert(data)
                    $('#outcome').val(data);
                });
            }

       });
       
       
       $("#outcome_data_pic").change(function(){
          var outCome = $("#outcome").val();
        if(outCome==''){
            $("#outcome").attr('style','background-color: red;');
        }else{
            var thisVal   =   $(this).val();
                $.ajax({
                    url:'<?php echo \Uri::create('quotes/update_quotes/'.@$quote['Q_YearSeq_pk']);?>?string='+outCome+'&outDate='+thisVal
                }).done(function(data){
                    //alert(data)
                    $('#outcome').val(data);
                });
            }

       });
       

       var visit_check = $("#Q_SiteVisitRequired").val(); 
   
       if(visit_check==1){
        $('#div_site_visit_msg').html('<b>Yes</b>');
        $('#date_inst').html('<b>SITE VISIT DATE</b>');
       }else{
        $('#div_site_visit_msg').html ='<b>No</b>';
        $('#date_inst').html('<b>DATE INST. REQUIRED</b>');
       }
       
        $('#Q_SiteVisitRequired').click(function(){ 
            if($(this).is(':checked')){
                $('#div_site_visit_msg').html('<b>Yes</b>');
                $('#date_inst').html('<b>SITE VISIT DATE</b>');
                $("#Q_SiteVisitRequired").val(1)
            }else{
                 $('#div_site_visit_msg').html('<b>No</b>');
                 $('#date_inst').html('<b>DATE INST. REQUIRED</b>');
                 $("#Q_SiteVisitRequired").val(0);
            }
        });




        function set_ret(getYear,getMonth,getDate){
            //alert(getYear+getMonth+getDate)
            
           // We build a string here and add to 'Special Conditionns' in the quote form
           var dDateInstRequired = '<?php echo @$quote['Q_DateInstRequired']; ?>';
           var Q_SpecialRequirements = $('#Q_SpecialRequirements').val();
           var selectNewDate        =   getYear+'-'+getMonth+'-'+getDate;

            // Store the date of the newDate
            var newDate = new Date();
            newDate.setYear(getYear);
            newDate.setMonth(getMonth);
            newDate.setDate(getDate);
            

            // Store the date of the newDate
            var Q_DateInstRequired = new Date()
            Q_DateInstRequired.setYear(dDateInstRequired.substr(0,4));
            Q_DateInstRequired.setMonth(dDateInstRequired.substr(4,2));
            Q_DateInstRequired.setDate(dDateInstRequired.substr(7,2));
            
            //alert(newDate)
            // Call the days_between function
            var days_left = days_between(newDate, Q_DateInstRequired); //alert(days_left)
                    if(days_left == 1){
                        sDayString = "1 day"
                    }else{
                        sDayString = days_left + " days"
                    }
                    s = "Instrument required for an estimated " + sDayString + ", from " + dDateInstRequired + " until " + selectNewDate + "."
                //Perform checks
                    if(days_left < 0){
                        alert("You can't retain the instrument before it is required. Please rectify.");
                        return false;
                    }
            
            var steQSRvalue = Q_SpecialRequirements+' '+s;
            //alert(steQSRvalue);
            $('#Q_SpecialRequirements').val(steQSRvalue);

        }
        


    function days_between(date1, date2) {

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime()
        var date2_ms = date2.getTime()

        // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms)

        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY)

    }
    function clouseTab(){
        parent.$('#tabOpen').dialog('close');
    }

</script>

                 