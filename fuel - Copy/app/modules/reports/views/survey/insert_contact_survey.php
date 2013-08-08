<?php echo $form->open();?>

<body class="searchforservey">

	
    <div id="searchforservey">
    	
        <div class="content">
        	
            <h1>INSERT CONTACT SURVEY</h1>
            
            <div class="box-3">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="50%" align="center"><p>RN NUMBER</p></td>
                        <td rowspan="2" align="center"><input type="button" class="button1" value="SELECT REPORT" /></td>
                    </tr>
                    <tr>
                    	<td align="center"><?php echo $form->build_field('rn_number') ?></td>
                    </tr>
                </table>
            </div>
            <div class="box-4">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="50%"><p>TEMPLATE VERSION</p></td>
                        <td><?php echo $form->build_field('template_version') ?></td>
                    </tr>
                    
                </table>
            </div>
            
            
            
            <div class="box-2">
            	
            	<div class="rightside">
                	<div class="blk"><?php echo $form->build_field('submit'); ?></div>
                    <div class="blk"><input type="button" class="button2" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

<?php echo $form->close();?>