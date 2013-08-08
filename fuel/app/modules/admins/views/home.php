
<table border="1"  class="admin_table clr_administration_inner">

<tr>
    <th style=text-align:center colspan="2">
        <h1>DB ADMINISTRATION</h1>
    </th>
</tr>
    <tr>
        <td class="clr_admin_nmi_structure"><?php echo \Html::anchor('admins/structures/nmi_branches', 'NMI STRUCTURE', array('class' => 'cb iframe')); ?></td>
        <td class="clr_admin_manager"><?php echo \Html::anchor('admins/managers', 'MANAGER', array('class' => 'cb iframe')); ?></td>
    </tr>
    <tr>
        <td class="clr_admin_file_storage"><?php echo \Html::anchor('admins/file_storage_locations', 'FILE STORAGE LOCATIONS', array('class' => 'cb iframe')); ?></td>
        <td class="clr_admin_site_details"><?php echo \Html::anchor('admins/site_details_listing', 'SITE DETAILS LISTING', array('class' => 'cb iframe')); ?></td>
    </tr>
    <tr>
        <td class="clr_admin_manage_sign"><?php echo \Html::anchor('admins/manage_signs', 'MANAGE SIGNATORIES', array('class' => 'cb iframe')); ?></td>
        <td class="clr_admin_paths"> <a href="#">PATHS </a></td>
    </tr>
    <tr>
        <td class="clr_admin_certificates"><?php echo \Html::anchor('admins/certificates_offered', 'CERTIFICATES OFFERED', array('class' => 'cb iframe')); ?></td>
        <td class="clr_admin_contact"><?php echo \Html::anchor('admins/contact_categories', 'CONTACT CATEGORIES', array('class' => 'cb iframe')); ?></td>
    </tr>
    <tr>
        <td class="clr_admin_org_cat"><?php echo \Html::anchor('admins/organisation_catergories', 'ORGANISATION CATEGORIES', array('class' => 'cb iframe')); ?></td>
        <td class="clr_admin_set_global"> <a href="#">SET GLOBAL PARAMETERS </a></td>
    </tr><tr>
        <td class="clr_admin_who"><a href="#">WHO'S IN </a></td>
        <td></td>
    </tr>
</table>