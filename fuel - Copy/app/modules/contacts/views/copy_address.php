<body class="copyaddress">

	
    <div id="copyaddress">
    	
        <div class="content">
        	
            <h1>SELECT POSSIBLE ADDRESS</h1>
            
            <div class="box-1">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-2">
                	<tr>
                    	<td><?php echo $form->OR1_FullName; ?></td>
                    </tr>
                </table>
            	<div class="c1">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        <tr>
                            <td width="50%" valign="top"><p>Postal address:</p></td>
                            <td valign="top"><p>Physical address:</p></td>
                        </tr>
                        <tr>
                            <td valign="top">
                                  <div style="background-color: #ffffff;margin:2px;">
                                <?php echo $form->OR2_Postal1; ?>
                                <?php echo $form->OR2_Postal2; ?>
                                <?php echo $form->OR2_Postal3; ?>
                                <?php echo $form->OR2_Postal4; ?>
                                </div>
                                
                            </td>
                            <td valign="top">
                                  <div style="background-color: #ffffff; margin:2px;">
                                <?php echo $form->OR2_Physical1; ?>
                                <?php echo $form->OR2_Physical2; ?>
                                <?php echo $form->OR2_Physical3; ?>
                                <?php echo $form->OR2_Physical4; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="button" id="sel_postel" class="button1" value="SELECT POSTAL" /></td>
                            <td valign="top"><input type="button" id="sel_physical" class="button1" value="SELECT PHYSICAL" /></td>
                        </tr>
                        <tr>
                            <td valign="top"><p>Invoice address:</p></td>
                            <td valign="top"></td>
                        </tr>
                        <tr>
                            <td valign="top">
                               <div style="background-color: #ffffff">
                                <?php echo $form->OR2_Invoice1; ?>
                                <?php echo $form->OR2_Invoice2; ?>
                                <?php echo $form->OR2_Invoice3; ?>
                                <?php echo $form->OR2_Invoice4; ?>
                                </div>
                            </td>
                            <td valign="top"></td>
                        </tr>
                        <tr>
                            <td valign="top"><input id="sel_invo" type="button" class="button1" value="SELECT INVOICING" /></td>
                            <td valign="top"></td>
                        </tr>
                    </table>
                </div>
                
                
                
                
            </div>
            
            
            
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="button" class="button2" onclick="Javascript:parent.jQuery.fn.colorbox.close();" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
    <script type="text/javascript">
        
        $("#sel_postel").click(function(){
           var div_id = '<?php echo $div_id; ?>'; 
           var sub_div_id = '<?php echo $sub_div_id;?>'
           var data = new Array();
            data[0] = $('#pos_1').val();
            data[1] = $('#pos_2').val();
            data[2] = $('#pos_3').val();
            data[3] = $('#pos_4').val();          
           load_data(div_id,sub_div_id,data);           
           parent.jQuery.fn.colorbox.close();
        });
        
         $("#sel_physical").click(function(){
           var div_id = '<?php echo $div_id; ?>';
           var sub_div_id = '<?php echo $sub_div_id;?>'
           var data = new Array();
            data[0] = $('#phy_1').val();
            data[1] = $('#phy_2').val();
            data[2] = $('#phy_3').val();
            data[3] = $('#phy_4').val();

           load_data(div_id,sub_div_id,data);          
            parent.jQuery.fn.colorbox.close();
        });
        
         $("#sel_invo").click(function(){
           var div_id = '<?php echo $div_id; ?>';
           var sub_div_id = '<?php echo $sub_div_id;?>'
           var data = new Array();
            data[0] = $('#invo_1').val();
            data[1] = $('#invo_2').val();
            data[2] = $('#invo_3').val();
            data[3] = $('#invo_4').val();

           load_data(div_id,sub_div_id,data);           
            parent.jQuery.fn.colorbox.close();
        });
        
        
        
        
    function load_data(div_id,sub_div_id,data){ 
            parent.$("#"+div_id+" #"+sub_div_id+'1').val(data[0]);
            parent.$("#"+div_id+" #"+sub_div_id+'2').val(data[1]);
            parent.$("#"+div_id+" #"+sub_div_id+'3').val(data[2]);
            parent.$("#"+div_id+" #"+sub_div_id+'4').val(data[3]);
    }
        
        </script>