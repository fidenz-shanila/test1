<!-- artefact descroption in main form header area -->
<?php  if($quote['Q_LockForm']==1){$class = 'locked';}else{$class='quote_tab_lock';}?>
<div class="<?php echo $class;?>">
<div style="background-color: #C0C0C0; margin: 5px;">
<table cellpadding="0" cellspacing="0" border="0" width="100%" >
    <tbody><tr>
        <td valign="top">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tbody><tr>
                    <td width="70%">
                        <h2>artefact description</h2>
                        <div class="c1">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tbody><tr>
                                    <td width="20%"><p>TYPE</p></td>
                                    <td width="2%"><?php echo $form->A_Type; ?></td>
                                    <td><p>(Limit to List)</p></td>
                                </tr>
                            </tbody></table>
                        </div>
                    </td>
                    <td align="center" width="10%">
                        <?php echo $form->ViewA_Button; ?>
                    <td>
                        <div class="gethelp">
                            <p>GET <br>HELP</p>
                            <input type="button" class="button1" value="?">
                        </div>
                    </td>
                </tr>   
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <div class="c2">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody><tr>
                        <td width="12%"><p>make:</p></td>
                        <td width="28%"><?php echo $form->A_Make; ?></td>
                        <td width="10%"><span>(Opt.)</span></td>
                        <td width="10%"><p>s/n:</p></td>
                        <td width="28%"><?php echo $form->A_SerialNumber; ?></td>
                        <td><span>(Opt.)</span></td>
                    </tr>
                    <tr>
                        <td><p>model:</p></td>
                        <td><?php echo $form->A_Model; ?></td>
                        <td><span>(Opt.)</span></td>
                        <td><p>range:</p></td>
                        <td><?php echo $form->A_PerformanceRange; ?></td>
                        <td><span>(Opt.)</span></td>
                    </tr>
                </tbody></table>
            </div>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <div class="c3">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody><tr>
                        <td><p>DESCRIPTION (can be edited, or use 'BUILD' for basing on above)</p></td>
                        <td><input <?php echo $lock['AdminEdit'];?> type="button" class="button2" name="build" value="BUILD" id="build"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><?php echo $form->A_Description; ?></td>
                    </tr>
                </tbody></table>
            </div>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>

<?php  echo $form->A_YearSeq_pk; ?>

<script type="text/javascript">
    
    $('#build').click(function(){
        
        var A_Type = $('#A_Type').val();
        var A_Make = $('#A_Make').val();
        var A_Model = $('#A_Model').val();
        var A_PerformanceRange = $('#A_PerformanceRange').val();
        var A_SerialNumber = $('#A_SerialNumber').val();
        var A_Description = $('#A_Description').val();
        
        $.ajax({
            url : "<?php echo \Uri::create('Artefacts/build_description'); ?>",
            data : {'A_Type':A_Type, 'A_Make':A_Make, 'A_Model':A_Model, 'A_PerformanceRange':A_PerformanceRange, 'A_SerialNumber':A_SerialNumber, 'A_Description':A_Description},
            method:"post",
            dataType : "json",
            success : function(data){
                    $('#A_Description').val(data.A_Description);
            },
        });
    });
        
        
</script>
