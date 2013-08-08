<form action="" method="POST" target="_parent">

    <div id="insertnewquote">
    	
        <div class="content">
        	
            <h1><?php echo $title; ?></h1>
            
            
            <div class="box-0">
            	
                <div class="c1">
                	<h3>1) instrument owner type</h3>
			<?php echo $form->build_field('owner_type'); ?>
                </div>
                <div class="c2">
                	<h3>2) instrument owner</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>Organisation:</p></td>
                            <td><?php echo $form->build_field('organisation'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>Contact:</p></td>
                            <td><?php echo $form->build_field('contact_name'); ?><input type="button" class="button1" id="select_owner" value="SELECT" /></td>
                        </tr>
                    </table>
                    </div>
                </div>
				
                
                <div class="c3">
                	<h3>3) work performed by</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>NMI Branch:</p></td>
                            <td><?php echo $form->build_field('WDB_B_Name'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Section:</p></td>
                            <td><?php echo $form->build_field('WDB_S_Name'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Project:</p></td>
                            <td><?php echo $form->build_field('WDB_P_Name'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Area:</p></td>
                            <td><?php echo $form->build_field('WDB_A_Name'); ?></td>
                        </tr>
                        <tr bgcolor="#d9b7ff">
                        	<td><p>Test Officer:</p></td>
                            <td><?php echo \Helper_Form::list_employees('WDB_TestOfficerEmployeeID'); ?></td>
                        </tr>
                    </table>
                    </div>
                </div>
                <div class="c4">
                	<h3>4) instrument / artefact type</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>Type:</p></td>
                            <td><?php echo $form->build_field('A_Type'); ?></select></td>
                        </tr>
                    </table>
                    </div>
                </div>
                
                <div class="c5">
                	<h3>5) instrument / artefact description</h3>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>Make:</p></td>
                            <td><?php echo $form->build_field('A_Make'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>Model:</p></td>
                            <td><?php echo $form->build_field('A_Model'); ?></td>
                        </tr>
                        <tr>
                        	<td><p>Serial No.:</p></td>
                            <td><?php echo $form->build_field('A_SerialNumber'); ?></td>
                        </tr>
                        <tr>
                        	<td valign="top"><p>Range:</p></td>
                            <td><?php echo $form->build_field('A_PerformanceRange'); ?><h6>(eg., -200 to 100degC)</h6></td>
                        </tr>
                        
                    </table>
                    </div>
                    <div class="blk1">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        	<tr>
                            	<td width="70%"><p>DESCRIPTION (Can be edited)</p></td>
                                <td><input type="button" class="button1" id="build_desc" value="Build description" /></td>
                            </tr>
                            <tr>
                            	<td colspan="2" align="center">
                                	<?php echo $form->build_field('A_Description');  ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="c6">
                	<div class="tital">
                    	<div class="right">
                        	<div class="one"><input type="radio" class="no_file_exists radio" /><span>No file exists</span></div>
                            <input type="button" href="<?php echo Uri::create('files/?is_selectable=true');?>" class="cb iframe button1" value="select" />
                        </div>
	                	<h3>6) cb file</h3>
                        
                    </div>
                    <div class="blk">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="15%"><p>file number:</p></td>
                            <td><p>Title:</p></td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $form->build_field('A_CF_FileNumber_fk'); ?></td>
                            <td align="center"><?php echo $form->build_field('FileTitle'); ?></td>
                        </tr>
                        
                    </table>
                    </div>
                    
                </div>
                
            </div>
            
            
            
            
            <div class="box-2">
            	
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button1 " value="INSERT" /></div>
                    <div class="blk"><input type="button" class="button2 cb iframe close" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
        </div>
        <?php echo $form->build_field('A_OR1_OrgID_fk'); ?>
        <?php echo $form->build_field('A_ContactID'); ?>
</form>
<div id="pop_up_data" style="position:absolute; top:20px; width:100%;"></div>