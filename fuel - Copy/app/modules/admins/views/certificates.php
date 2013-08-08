	
    <div id="hours">
    	
        <div class="content">
        	
            <div class="mainbox">
            	
                <div class="div_1">
                    
                    <div class="blk2">
                        <h2>Certificates Offered</h2>
                        <table cellspacing="0" cellpadding="0" border="0" class="table-1">
                            <tr>
                                <td width="50%" valign="top"><p>CO_CertName_pk</p></td>
                                <td width="50%" valign="top"><p>CO_OfferStatement</p></td>
                            </tr>
                            <tr>
								
                                <td valign="top" colspan="5">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table-2">
										<?php foreach($certificates as $cert) {?>
                                        <tr>
											<td></td>
                                            <td width="50%"><?php echo $cert['CO_CertName_pk']; ?></td>
                                            <td width="50%"><?php echo $cert['CO_OfferStatement']; ?></td>
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

