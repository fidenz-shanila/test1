<?php  if($report['R_LockForm']==1){$class = 'locked';$form_text = '<strong style="color:red;">REPORT FORM LOCKED</strong>';}else{$class=''; $form_text = 'REPORT FORM';}?>
<div class=" <?php echo $class; ?>">
<div id="page-1">
    <div class="column_2">
<?php echo \Form::open('reports/mainform_report/'.$report_id);?>
<?php echo $form->R_FullNumber_pk;  ?>
<?php echo $form->quote_id;  ?>
<div class="line-1">
    <h1><?php echo $form_text; ?></h1>
    <div class="block-1">
        <!--<a class="button1" href="#"><img border="0" alt="" src="<?php //echo \Uri::base(false); ?>/assets/img/button1.jpg"></a>
        <a class="button2" href="#"><img border="0" alt="" src="<?php //echo \Uri::base(false); ?>/assets/img/delete-1.jpg"></a>-->
        
        <button class="button1" id="next_revision"  <?php echo $lock['AdminEdit'];?> href="<?php echo \Uri::create('Reports/next_revision?R_FullNumber_pk='.$report['R_FullNumber_pk'].'&R_J_YearSeq_fk_ind='.$R_J_YearSeq_fk_ind);?>">INSERT NEXT REVISION</button>
        <!--<button class="button1" id="next_revision">INSERT NEXT REVISION</button>-->
        <button class="del_button confirm"  title="Are you sure you wish to delete report <?php echo $report['R_FullNumber_pk'] ;?>?" id="delete_job" data-object="report" <?php echo $lock['AdminEdit'];?>  href="#">DELETE</button>
        
        <h1><?php echo $report['R_ReportNumberString']; ?></h1> 
        <div class="rightbuttons">
            <a href="#"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/left-arrow.jpg"></a>
            <a href="#"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/right-arrow.jpg"></a>
        </div>
    </div>
</div>

<div class="line-2">
    <div class="box-1"><strong><?php echo $report['R_FullNumber_pk']; ?></strong></div>
    <div class="box-2"><?php echo $report['FullStatusString']; ?></div>
</div>

<div class="main-leftbox">
    <div class="box_1">
        <h2>DATE OF REPORT (DOR)</h2>
        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
            <tbody><tr class="firsttd">
                <td width="30%"><p>Date:</p></td>
                <td><?php echo $form->R_DateOfReport; ?></td>
            </tr>
        </tbody></table>
        <div class="inbox">
            <table cellspacing="0" cellpadding="0" border="0" class="intable">
                <tbody><tr>
                    <td width="70%">
                        <h2>DATE REPORT SENT</h2>
                        <p style="margin:0 5px 0 10px;" class="fl">Date</p>
                        <?php echo $form->R_DateReportSent; ?>
                    </td>
                    <td>
                        <p>Report with item: <?php echo \Form::checkbox('reports[R_ReportWithItem]',  1, $report['R_ReportWithItem'] == 0?false:true,$lock['AdminEdit']=='disabled'?array('disabled'=>'disabled'):array()); ?></p>
                    </td>
                </tr>
            </tbody></table>
        </div>
    </div>

    <div class="box_1">
        <table cellspacing="0" cellpadding="0" border="0" class="table-2">
            <tbody><tr>
                <td colspan="4"><h2 style="display:inline-block; margin:0 5px 0 0;">CERTIFICATE EXPIRY(Applicable?)</h2>
                    <?php echo \Form::checkbox('chkR_CertExpiryApplicable', 1, true,$lock['AdminEdit']=='disabled'?array('disabled'=>'disabled'):array()); ?>
                   
                    <p id="crt_exp_app" style="display:inline-block; margin:0 0 0 5px;">NO</p></td>
            </tr>
            <tr>
                <td width="12%"><p>Period:</p></td>
                <td><?php echo $form->R_CertValidityPeriodInYears?><p style="display:inline-block;">(Year)</p></td>
                <td width="10%"><p>Date:</p></td>
                <td width="30%"><?php echo $form->R_CertificateExpiryDate?></td>
            </tr>
        </tbody></table>
    </div>

    <div class="box_1">
        <table cellspacing="0" cellpadding="0" border="0" class="table-2">
            <tbody><tr>
                <td colspan="4"><h2 style="text-align:left;"><em>Infrequently used</em></h2></td>
            </tr>
            <tr>
                <td colspan="4"><h2 style="display:inline-block; margin:0 5px 0 0;">REPORT EXPIRY DATE(Applicable?)</h2>
                     <?php echo \Form::checkbox('reports[R_ExpiryApplicable]', 1, $report['R_ExpiryApplicable'] == 0?false:true,$lock['AdminEdit']=='disabled'?array('disabled'=>'disabled','id'=>'R_ExpiryApplicable'):array('id'=>'R_ExpiryApplicable')); ?>
                    <p id="r_exp_app" style="display:inline-block; margin:0 0 0 5px;">NO</p>
                </td>
            </tr>
            <tr>
                <td width="12%"><p>Period:</p></td>
                <td><?php echo $form->R_ValidityPeriodInMonths?>
                    <input type="button" value="..." class="file-1" <?php echo $lock['AdminEdit'] ; ?>>
                    <p style="display:inline-block;">(month)</p></td>
                <td width="10%"><p>Date:</p></td>
                <td width="17%"><?php echo $form->R_ExpiryDate?></td>
            </tr>
        </tbody></table>
    </div>
    <div class="box_1">
        <h2>REPORT FINAL OUTCOME<br>(only fill in if withdrawn etc.)</h2>
        <table cellspacing="0" cellpadding="0" border="0" style="margin:0 0 5px 0;" class="table-2">
            <tbody><tr>
                <td width="30%"><p>Outcome:</p></td>
                <td><?php echo $form->R_OutCome?></td>
            </tr>
        </tbody></table>
        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
            <tbody><tr class="firsttd">
                <td width="30%"><p>Date:</p></td>
                <td><?php echo $form->R_OutComeDate?></td>
            </tr>
        </tbody></table>
    </div>
    <div class="box_2">
        <h3>OFFICIAL <br>USE ONLY</h3>
        <div class="rightside" id="report_lock" data-lock_container=".quote_tab_lock">
            <div class="survay">
                <?php echo $form->surveys; ?>
        
            </div> 
            <h3>LOCK FORM &nbsp;
                <?php 
                if($lock['canDo']=='Granted'){
                    echo \Form::checkbox('reports[R_LockForm]', 1, $report['R_LockForm'] == 0?false:true,array('id'=>'R_ExpiryApplicable'));
                }else{
                    echo \Form::checkbox('reports[R_LockForm]', 1, $report['R_LockForm'] == 0?false:true,array('disabled'=>'disabled')); 
                }
                ?></h3>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="table-2">
            <tbody><tr>
                <td width="80%" align="center"><h2>REPORT PATH</h2><?php echo $form->R_ReportPath; ?></td>
                <td>
                    <a class="btn" href="#"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/open-pdf.png"></a>
                    <a class="btn" href="#" id="link_build"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/build.png"></a>
                </td>
            </tr>
        </tbody></table>

    </div>
    <input type="submit" name="save" <?php echo $lock['AdminEdit'];?> value="Save" class="save_cancel"/>

</div>

<div class="rightboxout">

    <div class="rightbox">
        <h2>MAIL MERGE</h2>
        <div class="box_1">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                        <td width="45%" ><p>REPORT ADDRESSED TO:</p></td>
                    <td><?php echo $form->R_ReportAddressedToFullName; ?><p style="text-align:left; display:inline-block; padding:0 0 0 5px;">(No Limit)<strong class="red_str"></strong></p></td>
                </tr>
                <tr>
                    <td width="45%"><p>NMI SIGNATORY (if appl.):</p></td>
                    <td><?php echo $form->R_NmiSignatoryID; ?><p style="text-align:left; display:inline-block; padding:0 0 0 5px;">(dbl click for all)</p></td>
                </tr>
                <tr>
                    <td width="45%"><p>NATA SIGNATORY (if appl.):</p></td>
                    <td><?php echo $form->R_NataSignatoryID; ?><p style="text-align:left; display:inline-block; padding:0 0 0 5px;">(dbl click for all)</p></td>
                </tr>
                <tr>
                    <td width="45%"><p>LETTER SIGNED BY (if appl.):</p></td>
                    <td><?php echo $form->R_DocumentSignerID; ?><p style="text-align:left; display:inline-block; padding:0 0 0 5px;">(dbl click for all)</p></td>
                </tr>
            </tbody></table>
        </div>
        <div class="box_2">
            <div class="col_1">
                <h3>COVER LETTER ADDRESS</h3><strong class="red_str"></strong>
                <div id="R_cover" style="background-color: #ffffff">
                <?php echo $form->R_CoverLetterAddress1; ?>
                <?php echo $form->R_CoverLetterAddress2; ?>
                <?php echo $form->R_CoverLetterAddress3; ?>
                <?php echo $form->R_CoverLetterAddress4; ?>
                </div>
                <button class="cb iframe button1 copy_address" <?php echo $lock['AdminEdit'];?> href="<?php echo \Uri::create('contacts/copy_address/'.\Input::get('quote_id').'/?div_id=R_cover&sub_div_id=Co_add_'); ?>">Copy Address</button>
            </div>
            <div class="col_1">
                <h3>REPORT ADDRESS (ie. Physical)</h3><strong class="red_str"></strong>
                <div id="R_report" style="background-color: #ffffff;">
               <?php echo $form->R_ReportAddress1; ?>
                    <?php echo $form->R_ReportAddress2; ?>
                    <?php echo $form->R_ReportAddress3; ?>
                    <?php echo $form->R_ReportAddress4; ?>
                </div>
                 <button class="cb iframe button1 copy_address" <?php echo $lock['AdminEdit'];?> href="<?php echo \Uri::create('contacts/copy_address/'.\Input::get('quote_id').'/?div_id=R_report&sub_div_id=Re_add_'); ?>">Copy Address</button>
            </div>
        </div>
        <div class="box_3">
            <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                <tbody><tr>
                    <td width="68%">
                        <h4>Report type<a href="#">Double click to generate report</a></h4>
                        <?php echo \Form::select('report_type', 'select', array('CoverLetter' => 'CoverLetter', 'Minute' => 'Minute', 'Reg13' => 'Reg13', 'Reg13DeemedMass-2p' => 'Reg13DeemedMass-2p', 'Reg13DeemedMass-nonN-2p' => 'Reg13DeemedMass-nonN-2p', 'Reg13DeemedMass-nonN' => 'Reg13DeemedMass-nonN', 'Reg13DeemedMass' => 'Reg13DeemedMass', 'Reg13DeemedVolume-nonN' => 'Reg13DeemedVolume-nonN', 'Reg13DeemedVolume' => 'Reg13DeemedVolume', 'Reg13PlusVolumeReport' => 'Reg13PlusVolumeReport', 'Reg13plusVolumeRpt-nonN' => 'Reg13plusVolumeRpt-nonN', 'Reg2000Certificate' => 'Reg2000Certificate', 'Section9Certificate' => 'Section9Certificate', 'StandardReport' => 'StandardReport', 'User defined' => 'User defined'), array('multiple' => 'multiple', 'style' => 'height:98px;', 'id' => 'report_type', $lock['AdminEdit'])); ?>
                    </td>
                    <td>
                        <button class="cb iframe button1" href="<?php //echo \Uri::create('reports/standard_report_template'); ?>" onclick="Javascript:alert('word template');">Get Standard report template</button>
                        <a class="btn1" href="#"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/record_detail.png"></a>
                        <a class="btn2" href="<?php //echo \Uri::create('Reports/cb_file_cover_sheet/'.$report['R_FullNumber_pk']); ?>" onclick="Javascript:alert('word template');"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/cb_file.png"></a>
                        <button class="btn3" id="get_standard" href="<?php //echo \Uri::create('reports/open_standard_report_template'); ?>" onclick="Javascript:alert('word template');">GET STANDARD REPORT TEMPLATE</button>
                        <a class="btn4" href="<?php //echo \Uri::create('reports/user_defined_template_help'); ?>"><img border="0" alt="" src="<?php echo \Uri::base(false); ?>/assets/img/user_define.png"></a>
                    </td>
                </tr>
            </tbody></table>
        </div>
    </div>

    <div class="box_4 cal_size">
        <h2>COMMENTS</h2>
        <h2 class="warning">(max=300 char, size=<i>0</i>, <i class="click">click</i>)</h2>
        <h2 class="right"><span>(Highlight:<?php echo \Form::checkbox('reports[R_HighlightComment]', 1, $report['R_HighlightComment'], array('class' => 'highlighter', 'data-hl_target' => '.comment_highlight','id' => 'com_highlight', $lock['AdminEdit'], NULL)); ?>:)</span></h2>
        <?php echo $form->R_Comments; ?>

    </div>

    <div class="box_5">
        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
            <tbody><tr>
                <td width="65%">
                    <h3>REPORT LATE REASON</h3>
                   <?php echo $form->R_ReportLateReason; ?>
                </td>
                <td valign="top">
                    <h3>CSM EVALUATION</h3>
                    <?php echo $form->R_ReportLateCustSerCategory; ?>
                </td>
            </tr>
        </tbody></table>
    </div>


</div>
    <div class="clear"></div>
<?php echo \Form::close(); ?>
</div>
</div>
</div>



<script type="text/javascript">
//$(document).ready(function(){
        $('#next_revision').on('click', function(){
            outcome = $('#outcome').val();
            outcome_date = $('#outcome_date').val();
            
            if(outcome.length == 0 || outcome_date == 0){
                alert('Next issue cannot be created as this issue has not been closed out.');
                return false;
            }
           
        });
    
        $('.copy_address').click(function(){ 
                var id = $(this).attr('id');
                var address = $('.'+id+'-address').val();
                
                $('#invoice-address').text(address);
                $.colorbox.close();
        });
        
        $('#get_standard').click(function(){
            alert("To obtain the \'Standard Report Template\', perform a \'Save As\' on the following Template.");
        });
        
        $('#report_type').click(function(){
            
            var type_check = window.parent.$('.type_check');
            type_check.push($('.type_check'));
            
            var i = 0;

            $.each(type_check, function(){
                if ($(this).val() == '' ) {
                    //$(this).css('border', '3px solid red');
                    $(this).css('background-color', 'red');
                    $(this).css('background-image', 'none');
                    i++;
                }else{
                    $(this).css('border', '1px solid #ABADB3');
                }
            });
            
            if( i>0 ) {
                var conf = confirm('The highlighted fields are required to be filled in.  Do you wish to proceed?');

                if(conf) {
                    return true;
                }else{
                    return false;
                }
            }
        });
        
        
      
        
        function make_attr(chk_id,ele_id,div_id){
            if($(chk_id).attr('checked')) {
                $(ele_id).removeAttr('disabled')
                $(ele_id).attr('class', 'textbox-1 datepicker')
                $(div_id).html('Yes');
            }else{
               $(ele_id).attr('disabled', 'disabled')
               $(ele_id).attr('class', 'textbox-1 datepicker')
                $(div_id).html('No');
            }
        }
 
        $('#form_chkR_CertExpiryApplicable').click(function(){ 
            var chk_id = '#form_chkR_CertExpiryApplicable';
            var ele_id = '#R_CertificateExpiryDate';
            var div_id = '#crt_exp_app';
            make_attr(chk_id,ele_id,div_id);
            
        });
        
          $('#R_ExpiryApplicable').click(function(){    
                var chk_id = '#R_ExpiryApplicable';
                var ele_id = '#R_ValidityPeriodInMonths';
                var div_id = '#r_exp_app';
                
                make_attr(chk_id,ele_id,div_id);
                
                var chk_id = '#R_ExpiryApplicable';
                var ele_id = '#R_ExpiryDate';
                var div_id = '#r_exp_app';
                
                make_attr(chk_id,ele_id,div_id);

        });
      
        //Report Lock
        $('#report_lock input').click(function(){ 
            $(this).closest('form').append('<input type="hidden" name="save" value="1" /><input type="hidden" name="lock" value="1" />').submit();
        });   
        


        //Create pdf 
        $('#link_build').click(function(){
        $.ajax({
                url: "<?php echo \Uri::create('Reports/build_report?R_J_YearSeq_fk_ind='.$R_J_YearSeq_fk_ind .'&R_FullNumber_pk='.$report['R_FullNumber_pk']); ?>",
                //context: document.body
                }).done(function(data) {
                $('#R_ReportPath').val(data);
               });
         });
         
         /*
         *Confirm MSG
         */
        $('.confirm').click(function(){
            $(".confirm").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});
            $(".confirm").click(function() {
		//alert("You clicked yes");
                document.location = '<?php echo \Uri::create('Reports/delete_report?R_FullNumber_pk='.$report['R_FullNumber_pk'].'&quote_id='.\Input::get('quote_id'));?>';
                return ture;
            });
            return false;
        }) 
        

         
//});

        

</script>
