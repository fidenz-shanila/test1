<table border="1" class="admin_table clr_administration_inner">
    <tr>
    <th style=text-align:center colspan="2">
        <h1>MANAGER FORM</h1>
    </th>
</tr>
    <tr>
        <td class="clr_manag_stat"><?php echo \Html::anchor('admins/managers/stats_bl', 'STATISTICS', array('class' => 'cb iframe')); ?></td>
        <td class="clr_manag_income"><?php echo \Html::anchor('admins/managers/top_earners', 'INCOME, TOP EARNERS', array('class' => 'cb iframe')); ?></a></td>
    </tr>
    <tr>
        <td class="clr_manag_contact"><?php echo \Html::anchor('admins/managers/search_for_servers', 'CONTACT SURVEYS LISTING', array('class' => 'cb iframe')); ?> </a></td>
        <td class="clr_manag_fees"><?php echo \Html::anchor('admins/managers/fee_listing', 'FEE LISTING', array('class' => 'cb iframe')); ?> </a></td>
    </tr>
    <tr>
        <td class="clr_manag_pm"><a href="#"><?php echo \Html::anchor('admins/managers/pm_structure', 'PM STRUCTURES', array('class' => 'cb iframe')); ?></a></td>
        <td class="clr_manag_hours"><?php echo \Html::anchor('admins/managers/hours_analysis', 'HOURS ANALYSIS', array('class' => 'cb iframe')); ?> </a></td>
    </tr>
    
</table>