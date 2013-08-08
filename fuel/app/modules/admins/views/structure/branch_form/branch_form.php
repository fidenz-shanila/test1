    <div id="branch_form">
    	
        <div class="content">
        	
            <h1>BRANCH FORM</h1>
            
            <div class="box-0">
            	<p>branch:</p> 
                <input type="text" class="textbox-1" value="<?php echo $name; ?>"/>
            </div>       
            
            <div class="box-1">
            	
                <h2>Sections within '<?php echo $name; ?>'</h2>
                
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
		    
		    <?php foreach ($sections as $section) {?>
                    <tr>
                    	<td width="3%" align="center"><button href="<?php echo \Uri::create('admins/structures/section_form?S_SectionID_pk='.$section['S_SectionID_pk'].'&name='.urlencode($section['S_Name_ind']).'&s_code='.$section['S_Code']); ?>" class=button1>..</button></td>
                        <td width="90%"><input type="text" class="textbox-1" value="<?php echo $section['S_Name_ind']; ?>"/></td>
                        <td><input type="button" value="DELETE" class="button2 action-delete" data-object="Section" href="<?php echo \Uri::create('admins/structures/delete_section?S_SectionID_pk='.$section['S_SectionID_pk']).'&name='.$name.'&B_BranchID_pk='.$B_BranchID_pk; ?>"/></td>
                    </tr>
		    <?php }?>
                </table>
            </div>
            
            <div class="box-2">
            	<div class="leftside">
                	<p>export to excel</p>
                	<div class="blk1">
                        <?php echo \Form::input('export_excel', 'All (Excluding Fees)', array('class' => 'button1', 'type' => 'button', 'href' => \Uri::create('admins/structures/export_branches/allexcludingfees'), 'target' => '_blank')); ?>
                        <?php echo \Form::input('export_excel', 'All', array('class' => 'button1', 'type' => 'button', 'href' => \Uri::create('admins/structures/export_branches/all'), 'target' => '_blank')); ?>
                    </div>
                    <div class="blk1">
                        <input type="button" value="CLOSE" class="button1 cb iframe close" />
                    </div>
                </div>
            	<div class="rightside">
                	<div class="blk1">
			    <button href="<?php echo \Uri::create('admins/structures/insert_section?S_BranchID_fk='.$B_BranchID_pk); ?>" class=button1>INSERT SECTION</button>
			</div>
                    <div class="blk1"><input type="button" value="CLOSE" class="button1 cb iframe close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

