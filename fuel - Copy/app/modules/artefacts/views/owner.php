 <div class="c1">
<h2>CLIENT / OWNER: NMI ORGANISATIONS</h2>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <?php echo $form->A_YearSeq_pk; ?>
            <td colspan="3" align="center"><?php echo $form->OR1_FullName; ?></td>
        </tr>
        <tr>
            <td><p>CONTACT:</p></td>
            <td align="center"><?php echo $form->ContactName; ?>
			
            <td>
                <?php echo $form->buttonContact;?></td>
            <!--<button class="cb iframe button1" id="btn_contact_load"  href="" >...</button>-->
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
//this code currently not in use
$("#btn_contact_load").click(function(){
	var contact_id = $("#hid_contact_id").val();
	$("button#btn_contact_load").attr("value",'<?php //echo \Uri::create('employees/employee_profile/?id=');?>'+contact_id);
});
</script>