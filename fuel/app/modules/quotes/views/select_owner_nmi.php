<div style="background:#FFF; width:94%; padding:2%; margin:auto;">
	<div style="float:left; width:55%; padding:0 2% 0 0;">Select NMI Project
    	<select id="nmi_project" name="nmi_project" size="25" style="width:100%;">
			<?php foreach($nmi_projects as $nmi_projects_item) { ?>
                <option value="<?php echo $nmi_projects_item['OR1_OrgID_pk']; ?>"><?php echo $nmi_projects_item['OR1_FullName']; ?></option>
            <?php } ?>
		</select>
    </div>
    <div style="float:left; width:41%; padding:0 0 0 2%">Select NMI Contact
    	<select id="nmi_contact" name="nmi_contact" size="25" style="width:100%;">
			<?php foreach($nmi_contacts as $nmi_contacts_item) { ?>
                <option value="<?php echo $nmi_contacts_item['EM1_EmployeeID_pk']; ?>"><?php echo $nmi_contacts_item['EM1_FullNameNoTitle']; ?></option>
            <?php } ?>
		</select>
    </div>
    <div style="clear:both; height:15px;"></div>
    <input id="select_ok" type="button" class="button1" value="Select" />
    <input type="button" class="button1" value="Cancel" onclick="javascript:popup_close();" />
</div>
