<?php echo $form->open(array('enctype' => 'multipart/form-data')); ?>

    <div id="employee_form">
    	
        <div class="content">
        	
            <h1>EMPLOYEE FORM</h1>
            
            <div class="name"><h1><?php echo $topic ?></h1></div>
            
            
            <div class="column1-e">
            	
                <div class="box-1">
                	<table cellpadding="0" cellspacing="0" border="0" class="table-1  ">
                    	<tr>
                        	<td width="18%"><p>Title:</p></td>
                            <td width="32%"><?php echo $form->build_field('title'); ?></select></td>
                            <td width="18%"><p>Initials:</p></td>
                            <td><?php echo $form->build_field('initials'); ?></td>
                    	</tr>
                        <tr>
                        	<td><p>First Name:</p></td>
                            <td><?php echo $form->build_field('fname'); ?></td>
                            <td><p>Last Name:</p></td>
                            <td><?php echo $form->build_field('lname'); ?></td>
                    	</tr>
                        <tr>
                        	<td></td>
                            <td colspan="3">
                            	<div class="blk1">
                                	<p>Position ( Line 1): </p><?php echo $form->build_field('postion1'); ?>
                                    <div class="clr"></div>
                                    <p>Position ( Line 2): </p><?php echo $form->build_field('postion2'); ?>
                                    <div class="clr"></div>
                                    <p>Position ( Line 3): </p><?php echo $form->build_field('postion3'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        	<td><p>Phone:</p></td>
                            <td><?php echo $form->build_field('phone'); ?></td>
                            <td><p>Mobile:</p></td>
                            <td><?php echo $form->build_field('mobile'); ?></td>
                    	</tr>
                        <tr>
                        	<td><p>Fax:</p></td>
                            <td><?php echo $form->build_field('fax'); ?></td>
                            <td><p>Email:</p></td>
                            <td><?php echo $form->build_field('email'); ?><input href="mailto:<?php echo $email; ?>" style="float:left;" type="button" class="button1" value=".."  /></td>
                    	</tr>
                        <tr>
                        	<td><p>Username:</p></td>
                            <td><?php echo $form->build_field('username'); ?></td>
                            <td></td>
                            <td></td>
                    	</tr>
                        <tr>
                        	<td><p>Currency Status:</p></td>
                            <td><?php echo $form->build_field('currency'); ?></td>
                            <td></td>
                            <td></td>
                    	</tr>
                        <tr>
                        	<td><p>Employment type:</p></td>
                            <td><?php echo $form->build_field('employment'); ?></td>
                            <td></td>
                            <td></td>
                    	</tr>
                        <tr>
                        	<td><p>Site:</p></td>
                            <td><?php echo $form->build_field('site'); ?></td>
                            <td></td>
                            <td></td>
                    	</tr>
                        <tr>
                        	<td><p>Room:</p></td>
                            <td><?php echo $form->build_field('room'); ?></td>
                            <td></td>
                            <td></td>
                    	</tr>
                        <tr>
                        	<td valign="top"><p>Comments:</p></td>
                            <td colspan="3"><?php echo $form->build_field('comments'); ?></td>
                        </tr>
                    </table>
                </div>
                
                <div class="box-2">
                	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td colspan="2">
                            	<h2>default filter setting for listings</h2>
                                <div class="r1">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td width="10%" align="right"><?php echo $form->build_field('quick_quote'); ?></td>
                                            <td width="30%"><h6>Quick Quote</h6></td>
                                            <td><h6>QUOTE CREATION PREFEERENCE</h6></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td><h6>Feild Lock flag for Branch, Section, Project and Area Listing</h6></td>
                        </tr>
                    	<tr>
                        	<td width="18%"><p>NMI Branch:</p></td>
                            <td width="50%"><?php echo $form->build_field('branch'); ?></td>
                            <td><h6><?php echo $form->build_field('chk_branch'); ?> </h6></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Section:</p></td>
                            <td><?php echo $form->build_field('section'); ?></td>
                            <td><h6><?php echo $form->build_field('chk_section'); ?> </h6></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Project:</p></td>
                            <td><?php echo $form->build_field('project'); ?></td>
                            <td><h6><?php echo $form->build_field('chk_project'); ?> </h6></td>
                        </tr>
                        <tr>
                        	<td><p>NMI Area:</p></td>
                            <td><?php echo $form->build_field('area'); ?></td>
                            <td><h6><?php echo $form->build_field('chk_area'); ?> </h6></td>
                        </tr>
                    </table>
                </div>
            	
            </div>
            
            <div class="column2-e">
            	<div class="box-3">
                    <img style="max-width:463px;margin:20px;" src="<?php echo $profile_image; ?>" alt="" />   
                </div>
                <div class="laststrip">
                    	<p>Image:</p>
                        <?php echo $form->build_field('image'); ?>
                    </div>
                    <p>&nbsp;</p><?php //print_r(); ?>
                    <div class="blk1"><?php echo $form->build_field('resetpass'); ?></div>
                    <div class="blk1"><?php echo $form->build_field('resetrole'); ?></div>
                    
                     <div class="blk2"><?php echo $form->build_field('save'); ?><input type="button" class="button1" value="CLOSE" onclick="javascript:parent.jQuery.fn.colorbox.close();document.location='<?php echo \Uri::create('employees/');?>'" /></div>
                </div>
            </div>
            			
        
        
    </div>
<?php echo $form->close(); ?>	