<form action="" id="contacts_listing_filter" class="grid_filter">
    
    <table  class="" border="0" width="100%" >
        <tr>
            <td><table  style="margin:5px; border:1px solid #a1a1a1;margin-right:5px" ><tr><td>
                            <div  style="margin:5px;;padding:2px;min-height:18px;padding-left:5px;">
                <label>ORG. TYPE:</label>
                <?php echo \Helper_Form::org_type_contacts('org_type', 'EXTERNAL', array('class'=>'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('org_type'); ?>
                 </div></td></tr></table>
            </td><td width="40%">
                <h1 style="font-size:200%;">PM CONTACTS LISTING</h1>
                
            </td>
            <td>
            <table  class="" border="0" width="100%" >  
                <tr>
            <td  align="left" ><div style="border:1px solid #a1a1a1;margin:5px;margin-right:5px"><div align="center"  style=" margin:5px;padding:2px;">
                    DISPLAY TOP:
        <?php echo \Form::select('export_to_excel_limit', 200, array( 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 5000 => 5000, 10000 => 10000,'ALL'),array('id'=>'visibleSelect','onclick'=>'displayVals()','class'=>'filter_field '));?>
       COUNT:
               <?php //$valueOfCount=new Controller_Contacts() ;
              // $valueOfCount1=$valueOfCount->listing();
               echo '<input  type="text" size="5%" id="disabledCount" value="" disabled="disabled"  />' ?>
                </div></div></td><td><div style="border:1px  solid #a1a1a1;margin:5px;margin-right:5px;"><div align="center"   style="margin:5px;;padding:2px;">SEND TO EXCEL:
        <input class="spaced excel_button excelImg" type="button" name="export_to_excel"  /></div></div>
        </td>
        </tr>
    </table>
            </td>
        </tr>
    </table>
    <table  class="" border="0" width="100%"  >
        <tr><th align="center" id="vNam" style="cursor:default" width="23%" ><u><b><h3>NAME(...click)</h3></b></u></th><td align="center" id="vOrg" width="49%" style="color:#0209c7;cursor:default"><u><b><h3>ORGANISATION(...click)</h3></b></u></td><td align="center"><u><b>CONTACT PHONE</b></u></td><td align="center"><u><b>CONTACT MOBILE</b></u></td></tr>
        </table>
    
    </form>
<script type="text/javascript">
    

    $('.excel_button').on('click',function(){
        var countOfData = $("#disabledCount").val();
            var didConfirm = confirm("Are you sure you to want contact data for "+countOfData+" contact to MS Excel?");
                if (didConfirm == true) {
                    $('#hiddenExportToExcelLimit').val($("select[name=export_to_excel_limit]").val());
                     $('#hiddenOrgType').val($("select[name=org_type]").val());
                     $('#hiddenOrgType').removeAttr('disabled');
                     $('#hiddenExportToExcelLimit').removeAttr('disabled');
                     $('#hoddenExportToExcel').removeAttr('disabled');
                     $('#hoddenExportToExcel').val('55');
                     $("#listing_filter").submit();
                   return true;
                }else{
                    return false;
                }
        });
        
    $("#vOrg").click(function(){
   $("#ORGANISATION").click();
   $(this).css('color', '#0209c7');
   $("#vNam").css('color', '#000000');
});
    
    $("#vNam").click(function(){
   $("#NAME").click();
   $(this).css('color', '#0209c7');
   $("#vOrg").css('color', '#000000');
});
 $("#visibleSelect").on("change",function(){
   $('#limitData').val($("#visibleSelect").val());
});   

jQuery(document).ready(function($){
    
    setInterval(    function(){ 
        
        if($('#DataTables_Table_0_info').html()!=''){
         var arr_spliter =   $('#DataTables_Table_0_info').html().split('to');
         
         if(arr_spliter.length > 1){
        var countOfgrid=arr_spliter[1];

        var val_div = document.getElementById("disabledCount").value=countOfgrid.split('of')[0];
            $('#disabledCount').html($('#DataTables_Table_0_info').html(val_div));}
        }},1000);
    

});
//alert($('#visibleSelect').css('height'));
</script>
