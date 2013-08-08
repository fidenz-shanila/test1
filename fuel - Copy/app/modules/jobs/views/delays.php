

    <div id="delays">
    	
        <div class="content">
        	
            <h1>DELAYS FOR J<?php echo $J_YearSeq_pk; ?> <span>Use the form to record delays caused by the client</span></h1>
            
            <div class="box-1">
		
		<?php echo $form->open();?>
		
            	<div class="c1">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        <tr>
                            <td width="30%" valign="top" align="center">
                            	<div class="blk1">
	                            	<p>ENTERED BY:</p>
                                    <?php echo $form->build_field('entered'); ?>
                                </div>
                            </td>
                            <td width="20%" valign="top" align="center">
                            	<div class="blk2">
	                            	<p>START DATE:</p>
                                    <?php echo $form->build_field('date'); ?>
                                </div>
                            </td>
                            <td valign="top" width="40%" align="center">
                            	<p>DESCRIPTION:</p>
                                <?php echo $form->build_field('description'); ?>
                            </td>
                            <td valign="top" align="center"><br /><br /><input type="submit" class="spaced" value="Insert" /></td>
                        </tr>
                        
                    </table>
                </div>
		
		

		<?php echo $form->close(); ?>	

                
                <div class="c2">
                	<h2>DELAY LOG</h2>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1" style="text-align:center;">
                    	<tr>
                            <th><p>ENTERED BY</p></th>
                            <th><p>STARTED</p></th>
                            <th><p>ENDED</p></th>
                            <th><p>DESCRIPTION</p></th>
                            <th> </th>
                        </tr>
			

        		    <?php foreach ($log as $lg) { ?>
				<tr>
				    <td><?php echo $lg['JD_EmployeeFullnameNoTitle']; ?></td>
				    <td><?php echo $lg['JD_Startdate']; ?></td>
				    <td>
					<form action="<?php echo \Uri::create('jobs/add_end_date_for_job_delay?JD_DelayID_pk='.$lg['JD_DelayID_pk'].'&J_YearSeq_pk='.$J_YearSeq_pk ); ?>" method="post">
					<input type="text" value="<?php echo $lg['JD_EndDate']; ?>" class="datepicker" name="JD_EndDate"/>
					<input type="submit" value="..." href=""/>
					</form>
				    </td>
				    <td><?php echo $lg['JD_Description']; ?></td>
				    <td><input class="action-delete" data-object="Delay" href="<?php echo \Uri::create('jobs/delete_job_delay?JD_DelayID_pk='.$lg['JD_DelayID_pk'].'&J_YearSeq_pk='.$J_YearSeq_pk ); ?>" type="button" name="delete" value="Delete" /></td>
				</tr>
        		    <?php } ?>
                    </table>
                </div>
                
                
            </div>
            
            
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="button" class="button2 cb iframe close" value="close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
