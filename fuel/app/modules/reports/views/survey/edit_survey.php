<?php echo $form->open();?>
<body class="editforservey">

	
    <div id="editforservey">
    	
        <div class="content">
        	
            
            
            <div class="box-1">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                <tr>
                <td colspan="9">
                <h1>EDIT CONTACT SURVEY</h1>
                </td>
                </tr>
                	<tr>
                    	<td width="50%" align="center"><p>RN NUMBER</p></td>
                    	<td width="50%" align="center">CONTACT</td>
                    	<td width="50%" align="center">ORGANISATION</td>
                    	<td width="50%" align="center">SURVEY VER.</td>
                    	<td width="50%" align="center">SENT</td>
                    	<td width="50%" align="center">RETURNED</td>
                    	<td width="50%" align="center">CONTACT NOTIFIED</td>
                    	<td width="50%" align="center">OUTCOME</td>
                    	<td width="50%" align="center">OUTCOME DATE</td>
                   	</tr>
                    <tr>
                    	<td align="center"><?php echo $form->CS_R_FullNumber_ind; ?></td>
                    	<td align="center"><?php echo $form->CS_ContactFullName; ?></td>
                    	<td align="center"><?php echo $form->CS_OrganisationFullName; ?></td>
                    	<td align="center"><?php echo $form->CS_SurveyVersion; ?></td>
                    	<td align="center"><?php echo $form->CS_DateSent; ?></td>
                    	<td align="center"><?php echo $form->CS_DateReturned; ?></td>
                    	<td align="center"><?php echo $form->CS_ContactNotifiedOfOutcome; ?></td>
                    	<td align="center"><?php echo $form->CS_Outcome; ?></td>
                    	<td align="center"><?php echo $form->CS_OutcomeDate; ?></td>
                   	</tr>
                </table>
                <table>
                <tr>
                <td>COMMENTS</td>
                <td><input type="text" class="comment" ></td>
                <td>RETURNED BY:</td>
                <td><input type="text" ></td>
                <td>CAR NO.:</td>
                <td><input type="text" ></td>
                </tr>
              </table>
          </div>

            
            
            
<div class="box-2">
            	
            	<div class="rightside">
                	<div class="blk"><input type="button" value="Save" class="button2" /></div>
                    <div class="blk"><input type="button" class="button2" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php //echo $form->close();?>