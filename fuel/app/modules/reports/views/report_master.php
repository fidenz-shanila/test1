<?php echo $form->open(); ?>

    <div id="report_master">
    	
        <div class="content">
        	
            
            <h1>REPORT MASTER</h1>
            
            
            <div class="mainbox">
            	
                <div class="box-0">
                	<div class="c1">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        	<tr>
                            	<td width="50%"><h6>Report Number:</h6></td>
                                <td valign="top"><?php echo $form->build_field('RML_ReportNumber_pk'); ?></td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                                    	<tr>
                                        	<td width="10%"><p>Prefix:</p></td>
                                            <td width="15%"><?php echo $form->build_field('RML_Prefix'); ?></td>
                                            <td width="25%"><p>Sequential:</p></td>
                                            <td><?php echo $form->build_field('RML_RnSeq_ind'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td><p>Report year:</p></td>
                                <td><?php echo $form->build_field('RML_RnYear'); ?></td>
                            </tr>
                            <tr>
                            	<td><p>Date of report (DOR)</p></td>
                                <td><?php echo $form->build_field('RML_DateOfReport'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="c2">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        	<tr>
                            	<td width="50%"><h6>Quote Number:</h6></td>
                                <td valign="top"><?php echo $form->build_field('RML_QuoteNumber'); ?></td>
                            </tr>
                            <tr>
                            	<td><p>Sequential:</p></td>
                                <td><?php echo $form->build_field('RML_QnSeq'); ?></td>
                            </tr>
                            <tr>
                            	<td><p>Quote Date</p></td>
                                <td><?php echo $form->build_field('RML_QuoteDate'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="box-1">
                	<h2>atrefact details</h2>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
	                    	<td width="20%"><p>Make:</p></td>
    	                    <td width="30%"><?php echo $form->build_field('RML_Make'); ?></td>
        	                <td width="20%" bgcolor="#d7adf5"><p>Test Officer:</p></td>
            	            <td bgcolor="#d7adf5"><?php echo $form->build_field('RML_TestOfficer'); ?></td>
                        </tr>
                        <tr>
	                    	<td><p>Model:</p></td>
    	                    <td><?php echo $form->build_field('RML_Model'); ?></td>
        	                <td bgcolor="#fffcb5"><p>File Number:</p></td>
            	            <td bgcolor="#fffcb5"><?php echo $form->build_field('RML_FileNumber'); ?></td>
                        </tr>
                        <tr>
	                    	<td><p>Serial Number:</p></td>
    	                    <td><?php echo $form->build_field('RML_SerialNumber'); ?></td>
        	                <td></td>
            	            <td></td>
                        </tr>
                        <tr>
	                    	<td><p>Description:</p></td>
    	                    <td colspan="3"><?php echo $form->build_field('RML_Description'); ?></td>
        	            </tr>
                    </table>
                </div>
                
                <div class="box-2">
                	<h2>Owner Detials</h2>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
	                    	<td width="20%"><p>Organisation:</p></td>
    	                    <td><?php echo $form->build_field('RML_OrganisationFullName'); ?></td>
        	            </tr>
                        <tr>
	                    	<td><p>Contact:</p></td>
    	                    <td><?php echo $form->build_field('RML_Contact'); ?></td>
        	            </tr>
                    </table>
                </div>
                
                <div class="box-3">
                	<h2>Quote Details</h2>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
	                    	<td width="20%"><p>Services offered:</p></td>
    	                    <td><?php echo $form->build_field('RML_ServicesOffered'); ?></td>
        	            </tr>
                        <tr>
	                    	<td><p>Special requirements:</p></td>
    	                    <td><?php echo $form->build_field('RML_SpecialRequirements'); ?></td>
        	            </tr>
                    </table>
                </div>
                
                <div class="box-4">
                	
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
	                    	<td width="20%"><p>Comments:</p></td>
    	                    <td colspan="3"><?php echo $form->build_field('RML_Comments'); ?></td>
        	            </tr>
                        <tr>
	                    	<td><p>Source:</p></td>
    	                    <td><?php echo $form->build_field('RML_RecordDerivedFrom'); ?></td>
                            <td></td>
                            <td></td>
        	            </tr>
                        <tr>
	                    	<td><p>Date Created:</p></td>
    	                    <td width="30%"><?php echo $form->build_field('RML_DateCreated'); ?></td>
                            <td width="20%"><p>Date last updated:</p></td>
    	                    <td><?php echo $form->build_field('RML_LastUpdated'); ?></td>
        	            </tr>
                    </table>
                </div>
                
            	
            </div>
            
            <div class="box-5">
                <div class="rightside">
                    <div class="blk"><?php echo $form->build_field('submit'); ?>
					</div>
					
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo $form->close(); ?>