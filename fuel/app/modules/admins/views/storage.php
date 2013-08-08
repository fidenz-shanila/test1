	
    <div id="hours">
    	
        <div class="content">
        	
            <div class="mainbox">
            	
                <div class="div_1">
                    
                    <div class="blk2">
                        <h2>File Storage Locations</h2>
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tr>
                                <td valign="top"></td>
                            </tr>
                            <tr>
                                <td valign="top" colspan="5">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table-2">
										<?php foreach($storage as $s) {?>
                                        <tr>
											<td></td>
                                            <td ><?php echo $s['FSL_LocationName_pk']; ?></td>
                                        </tr>
										<?php } ?>
                                    </table>
                                </td>
                            </tr>
                           
                        </table>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>

