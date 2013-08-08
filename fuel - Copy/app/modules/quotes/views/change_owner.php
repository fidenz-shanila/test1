<?php echo $form->open();

echo $form->build_field('A_OR1_OrgID_fk');
echo $form->build_field('A_ContactID');
echo $form->build_field('Q_YearSeq_pk'); ?>

    <div id="change_owner">
    	
        <div class="content">
        	
            <h1>CHANGE OWNER</h1>
            
            <div class="box-1">
            	
                <div class="c1">
                	<h3>1) NEW INSTRUMENT OWNER TYPE</h3>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                            <td align="center"><select id="owner_type" class="select-1" >
								<option value="EXTERNAL">EXTERNAL</option>
                            	<option value="NMI">NMI</option>
                            </select></td>
                        </tr>
                    </table>
                </div>
                
                <div class="c2">
                	<h3>2) NEW INSTRUMENT OWNER</h3>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    	<tr>
                        	<td width="30%"><p>Organisation:</p></td>
                            <td><input id="new_organisation" name="" type="text" class="textbox-1" disabled="disabled" /></td>
                        </tr>
                        <tr>
                        	<td><p>Conatct:</p></td>
                            <td><input id="new_contact" name="" type="text" class="textbox-2" disabled="disabled" />
                            	<div class="blk"><input id="select_owner" type="button" class="button1" value="Select" /></div>
                            </td>
                        </tr>
                    </table>
                </div>    
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><?php echo $form->build_field('submit'); ?></div>
                	<div class="blk"><input type="button" class="button2 cb iframe close" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<div id="pop_up_data" style="position:absolute; top:20px; width:100%;"></div>
