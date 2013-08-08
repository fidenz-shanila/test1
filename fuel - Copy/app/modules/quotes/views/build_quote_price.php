
    <div id="build_quote_price">
    	
        <div class="content">
        	
            <h1>BUILD QUOTE PRICE</h1>
           
            <div class="box-1">
            	<table cellpadding="0" cellspacing="0" border="0" class="table-1">
                	<tr>
                    	<td width="10%"><p>Section:</p></td>
                        <td width="40%"><input type="text" class="textbox-1" readonly='readonly' value="<?php echo $wdb['WDB_S_Name']; ?>"/></td>
                        <td width="10%"><p>Area:</p></td>
                        <td><input type="text" class="textbox-1" readonly='readonly' value="<?php echo $wdb['WDB_A_Name']; ?>"/></td>
                    </tr>
                    <tr>
                    	<td><p>Project:</p></td>
                        <td><input type="text" class="textbox-1"  readonly='readonly' value="<?php echo $wdb['WDB_P_Name']; ?>"/></td>
                        <td></td>
                        <td>
                        	<table cellpadding="0" cellspacing="0" border="0" class="table-1 one">
                            	<tr>
                                    <td width="20%"><p>Test Officer:</p></td>
                                    <td><?php echo \Form::input('test_officer', $wdb['Employee'], array('class' => 'textbox-1', 'disabled' => 'disabled'));?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="box-3">
            	<div class="c1">
                	<div class="inc1">
                        <h3>SELECTED MODULES FOR QUOTE</h3>
                        <h4>(NOTE : New Modules appear at the top.)</h4>
                        <div class="blk1">
			    
			    <p style="text-align:center;">PRICE COMPOSITION</p>
			    
			    <?php foreach ($selected_modules as $modules) { ?>
				
			    
			    <div class="price_com">
                               
				<div class="price_top_row">
				    <p>Code :</p><br /><input type=text class="textbox" readonly='readonly' value=<?php echo $modules['QM_F_Code']; ?>>
				    <textarea ><?php echo $modules['QM_F_Description']; ?></textarea>
				</div>
				<br/>
				<div class="price_bottom_row">
                                    
                                    
				    <form action="<?php echo \Uri::create("quotes/update_module/{$modules['QM_QuoteModuleID_pk']}/?WDB_WorkDoneBy_pk={$wdb['WDB_WorkDoneBy_pk']}"); ?>" method="post">
                                        
                                        <p class="sp">
                                        FEE :<input class="currency"  readonly='readonly' type=text name="QM_F_Fee" value=<?php echo $modules['QM_F_Fee']; ?>>
					Qty :<input type=text readonly='readonly' name="QM_Quantity" value=<?php echo $modules['QM_Quantity']; ?>>
					Discount(%):<input type=text readonly='readonly' name="QM_DiscountPercentage" value=<?php echo $modules['QM_DiscountPercentage']; ?>>
					<input type="submit" value="..">
                                        </p>
                                        
                                
					<p>Due :</p><input type=text class='currency' readonly='readonly' value=<?php echo $modules['QM_FeeDue']; ?>>
					<p><button class="action-delete" data-object="Module" href="<?php echo \Uri::create("quotes/delete_module/{$modules['QM_QuoteModuleID_pk']}/?WDB_WorkDoneBy_pk={$wdb['WDB_WorkDoneBy_pk']}"); ?>">Delete</button></p>
				    </form>
				
			    </div>
                            </div>
			    
				<?php } ?>
                           
                        </div>
                    </div>
                    <div class="inc2">
                    	<table cellpadding="0" cellspacing="0" border="0" class="table-2">
                        	<tr>
                            	<td width="40%"><p>QUOTED PRICE:</p></td>
                                <td><input type="text" readonly='readonly' class="textbox-1 currency" value="<?php echo round($wdb['WDB_QuotedPrice'], 2); ?>" /></td>
                            </tr>
                            <tr>
                            	<td class="one"><p>FULL QUOTED PRICE:</p></td>
                                <td class="one"><input readonly='readonly' type="text" class="textbox-1 currency" value="<?php echo round($wdb_quote_price['Q_QuotedPrice'], 2); ?>" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="c2">
                	<div class="inc1">
                        <h3>AVAILABLE MODULES</h3>
                        <div class="blk1">
                            <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                                <tr>
                                    <th><p>DESCRIPTION</p></th>
                                </tr>
				
				<?php foreach ($all_modules as $all) { ?>
				
                                <tr>
                                    <td>
                                    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                            	<td align="center" width="10%"><button class="button1" href="<?php echo \Uri::create("quotes/push_module/{$all['F_FeeID_pk']}/{$wdb['WDB_WorkDoneBy_pk']}"); ?>">&lt;&lt;</button> </td>
                                                <td colspan="2"><textarea readonly='readonly' cols="" rows="" class="textarea-1"><?php echo $all['CodeAndDescription']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                            	<td></td>
                                                <td width="10%"><p>FEE</p></td>
                                                <td><input type="text" readonly='readonly'  class="textbox-1 currency" value="<?php echo $all['F_Fee']; ?>"/></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
				
				<?php } ?>
                               
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="box-2">
            	<div class="rightside">
                    <div class="blk"><input type="button" class="button2" onclick="javascript:opener.DoTheRefresh();window.close();" value="close" /></div>
                </div>
            </div>
            
            
            
            
            
        </div>
        
    </div>
    
    
  
    
