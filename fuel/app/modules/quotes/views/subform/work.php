<div id="contact_un">  <div class="part-2">  <div class="box-2">
    
<div id="worklog">
<div class="entries">

<?php 
foreach($work_log as $entry):
extract($entry); 
?>
<div class="c1 worklog_entry">
    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
        <tbody><tr>
            <td><h2><?php echo $WDB_WorkGroupNumberString; ?></h2></td>
            <td><input type="button" class="button1 cb iframe delete_workgroup"  id ="btn_wok_delete"  href="<?php echo \Uri::create('quotes/delete_workgroup/'.$WDB_WorkDoneBy_pk) ;?>"  <?php echo $lock['AdminEdit'] ; ?>    value="DELETE" /></td>
            <td></td>
        </tr>
    </tbody></table>
    <div class="b1">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="70%">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody><tr>
                            <td width="20%"><p>SECTION:</p></td>
                            <td><input type="text" value="<?php echo $WDB_S_Name; ?>" readonly class="textbox-1"></td>
                        </tr>
                        <tr>
                            <td><p>PROJECT:</p></td>
                            <td><input type="text" value="<?php echo $WDB_P_Name; ?>" readonly class="textbox-1"></td>
                        </tr>
                        <tr>
                            <td><p>AREA:</p></td>
                            <td><input type="text" value="<?php echo $WDB_A_Name; ?>" readonly class="textbox-1"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="par">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody><tr>
                                            <td width="40%"><p>TEST OFFICER</p></td>
                                            <td><input type="text" value="<?php echo $Employee; ?>" readonly  class="textbox-1"></td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
                <td>
                    <div class="dottb1">
                        <p>quoted price</p>
                        <input type="text" class="textbox-1 currency" value="<?php echo $WDB_QuotedPrice ; ?>" readonly="readonly">
                        <?php //echo $form->BuildEditPrice;?>
                        <input type='button' <?php echo $lock['AdminEdit']; ?> target="_blank" href="<?php echo \Uri::create("quotes/build_quote_price/".$WDB_WorkDoneBy_pk); ?>" value='Build/Edit Price' />
                    </div>
                </td>
            </tr>
        </tbody></table>
    </div>
    
    <div class="work_log_pricing">       
    <?php foreach($quote_pricing as $pentry) : ?>    
    <div class="b2">
        <h6>price composition</h6>
        <h5><?php echo $pentry['CodeAndDescription']; ?></h5>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="70%">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                        <tbody><tr>
                            <td width="10%"><p>FEE:</p></td>
                            <td width="10%"><input type="text" readonly="readonly" value="<?php echo $pentry['QM_FeeDue']; ?>" class="textbox-1 currency"></td>
                            <td><p>QTY:</p></td>
                            <td><input type="text"  readonly="readonly" value="<?php echo $pentry['QM_Quantity']; ?>" class="textbox-1"></td>
                            <td><p>DISCOUNT(%)</p></td>
                            <td><input type="text" readonly="readonly" value="<?php echo $pentry['QM_DiscountPercentage']; ?>" class="textbox-1"></td>
                        </tr>
                    </tbody></table>
                </td>
                <td>
                    <p>DUE:</p>
                    <input type="text" readonly="readonly" value="<?php echo $pentry['QM_FeeDue']; ?>" class="textbox-2 currency">
                </td>
            </tr>
        </tbody></table>
    </div>
    <?php endforeach; ?>
        <br /><br /><br /><br />
    </div>

</div>
<?php endforeach; ?>
</div><!-- entries -->
</div>
</div> </div> </div>

<?php echo \Asset::js('carousel.js'); ?>
<script type="text/javascript">$("#worklog").carousel( { direction: "vertical", nextBtnInsert: 'insertBefore' } );</script>

<script type="text/javascript">
    // On the parent...
function DoTheRefresh()
{
    location.reload();
}
</script>