<?php  if($job['J_LockForm']==1){$class = 'locked';$form_text = '<strong style="color:red;">JOB FORM LOCKED</strong>';}else{$class=''; $form_text = 'JOB FORM';}?>

<div id="page-1">
    <div class=" <?php echo $class; ?>">
    <div style="background-color: #79ECAD; margin: 10px;">
    <div class="top-line">
        <h2>JOB NUMBER:</h2>
        <div class="box-1"><?php echo $job['J_FullNumber']; ?></div>
        <h2>STATUS:</h2>
        <div class="box-2"><?php echo $job['FullStatusString']; ?></div>
    </div>
    <div id="content">
        
    <div class="column_1">      
            <div class="box_1">
                <h2>1) PLANNING</h2>
                <?php echo $form->J_YearSeq_pk; ?>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr class="firsttd">
                        <td width="50%" align="right"><p>Date inst. req.:</p></td>
                        <td><?php echo $form->Q_DateInstRequired; ?></td>
                    </tr>
                    <tr class="sectd">
                        <td><p>Planned start Date:</p></td>
                        <td><?php echo $form->J_PlannedStartDate; ?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="box_1">
                <h2>2) JOB START</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr class="sectd">
                            <td width="50%"><p>Actual start Date:</p></td>
                        <td><?php echo $form->J_ActualStartDate; ?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="box_1">
                <h2>3) MONEY</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr class="firsttd">
                        <td width="50%" align="right"><p>FULL QUOTED PRICE: </p></td>
                        <td> <?php echo $form->Q_QuotedPrice; ?></td>
                    </tr>
                    <tr class="sectd">
                        <td colspan="2">
                            <table cellspacing="0" cellpadding="0" border="0" width="93%">
                                <tbody><tr>
                                    <td width="40%"><p>FEE DUE: </p></td>
                                    <td><?php echo $form->J_FeeDue_Set; ?>
                                    <button class="cb iframe file-1 uppercase" <?php echo $lock['AdminEdit']; ?> href="<?php echo \Uri::create('jobs/change_fee_due?J_YearSeq_pk='.$job['J_YearSeq_pk']); ?>">Change</button></td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </div>

            <div class="box_2">
                <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                    <tbody><tr class="firsttd">
                        <td width="40%"><p>CERT. OFFERED</p></td>
                        <td><?php echo $form->Certificated_offered; ?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="box_2">
                <table cellspacing="0" cellpadding="0" border="0" class="table-2">
                    <tbody><tr class="firsttd">
                        <td width="40%"><p>METHOD</p></td>
                        <td><?php echo $form->A_TestMethodUsed; ?></td>
                    </tr>
                </tbody></table>
            </div>

            <div class="box_3">
                <h2>4) RETURN INST. TO STORE(opt.)</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr class="firsttd">
                        <td width="50%" align="right"><p>Date instrument <br>sent to store:</p></td>
                        <td><?php echo $form->J_DateInstReturnedToStore; ?></td>
                    </tr>
                    <tr class="sectd" >
                        <td colspan="2" >
                            <div>
                            <input type="button" value="DESPATCH FORM" class="file-1">
                            </div>
                            <div>
                            <input type="button" value="DESPATCH LABEL" class="file-1">
                            </div>
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <div class="box_1">
                <h2>5) TEST START AND END (opt.)</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr class="sectd">
                        <td width="50%" align="center"><h6>Test Start</h6><?php echo $form->J_TestStartDate; ?></td>
                        <td align="center"><h6>Test End</h6><?php echo $form->J_TestEndDate; ?></td>
                    </tr>
                </tbody></table>
            </div>
            <div class="box_1">
                <h2>6) JOB END</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr>
                        <td width="50%" align="center"  class="red_str"><p>Outcome </p></td>
                        <td align="center"><?php echo $form->J_OutCome; ?></td>
                    </tr>
                    <tr class="sectd">
                        <td width="50%" align="center"><p>End Date <strong class="red_str"></strong></p></td>
                        <td align="center"><?php echo $form->J_OutComeDate; ?></td>
                    </tr>
                </tbody></table>
                <h2>REASON</h2>
                <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                    <tbody><tr>
                        <td>
                            <?php echo $form->J_Comments; ?>
                        </td>
                    </tr>
                </tbody></table>
            </div>
    </div>
    <div class="column_2">
        <div id="reports" style="height:800px;">
            <div class="entries" >
                <?php foreach($reports as $report): ?>
                    <iframe scrolling="no" id="frm_rep" class="report" src="<?php echo \Uri::create('reports/mainform_report/'.$report['R_FullNumber_pk'] . '?quote_id='.\Input::get('quote_id')); ?>" style="height: 780px;"></iframe>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>

    
    <div class="column_3">
        <?php echo '<h1>'.$form_text.'</h1>'; ?>
        <div class="box_1">

            <?php
            
                //email client
                echo $form->Email_Client;
                
                //email melb
                $message = rawurlencode($email_melb['message']);
                $subject = rawurlencode($email_melb['subject']);
                
                echo \Form::button('email_melb', 'Email Melb', array('href'=> "mailto:{$email_melb['to']}?Subject={$subject}&body={$message}", 'class' => 'spaced uppercase'));
                
                //delete job
                echo \Form::button('delete', 'Delete', array('class' => 'spaced action-delete uppercase', 'data-object' => 'Job', 'href' => \Uri::create('jobs/delete/'.$job['J_YearSeq_pk']))); 
            ?>
            <div id="job_lock" >
            <h4>OFFICIAL USE ONLY</h4>
            <h4>
                LOCK FORM
                <?php if($current_user['CanLockJob']==1){
                    echo \Form::checkbox('job_tab[J_LockForm]', 1, $job['J_LockForm'] == 0?false:true); 
                }else{
                     echo \Form::checkbox('job_tab[J_LockForm]', 1, $job['J_LockForm'] == 0?false:true,array('disabled'=>'disabled')); 
                }
                
                ?>
            </h4>
            </div>
        </div>
        <div class="box_2" >
            <div class="col_1"><button class="cb spaced iframe button1 uppercase" <?php echo $lock['AdminEdit']; ?> href="<?php echo \Uri::create('jobs/delays/'.$job['J_YearSeq_pk']); ?>">Delays</button></div>

           
        </div>
        <div class="box_4">
            <div class="blk2">
                <input type="submit" name="save" value="Save" class="button1 save_cancel" <?php echo $lock['AdminEdit']; ?> />
                <input type="submit"  class="button1 save_cancel" name="cancel" value="Cancel" />
            </div>
        </div>

    </div>
    
        
        
        
    </div>
    </div>
    </div>
</div>

<script type="text/javascript">
    $("#reports").carousel( { direction: "vertical", nextBtnInsert: 'insertBefore' } );
    
    function changeFeeDue(data){
        $('#J_FeeDue_Set').val(data);
    }
</script>

