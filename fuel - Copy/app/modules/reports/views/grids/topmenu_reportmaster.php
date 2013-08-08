<form action="" id="contacts_listing_filter" class="grid_filter mainForm">
    
    <table  class="" border="0" width="100%" >
        <tr>
            <td width="20%">
            </td><td width="40%" align="center">
                <p style="font-size:200%;font-weight:650">REPORTS MASTER LISTING <span style="font-size:70%;font-weight:normal;">(Contains all known reports)</span></p>
                
            </td>
            <td>
            <table  class="" border="0" width="100%" >  
                <tr>
            <td  align="left" ><div style="border:1px solid #a1a1a1;margin:5px;margin-right:5px"><div align="center"  style=" margin:5px;padding:2px;">DISPLAY TOP:
        <?php echo \Form::select('export_to_excel_limit', 200, array( 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 5000 => 5000, 10000 => 10000,'ALL'),array('id'=>'visibleSelect','onclick'=>'displayVals()','class'=>'filter_field'));?>
       RECORD COUNT:
               <?php //$valueOfCount=new Controller_Contacts() ;
              // $valueOfCount1=$valueOfCount->listing();
               echo '<input  type="text" size="5%" id="disabledCount" value="" disabled="disabled"  />' ?>
                </div></div></td><td><div style="border:1px  solid #a1a1a1;margin:5px;margin-right:5px;"><div align="center"   style="margin:5px;;padding:2px;"><u>SEND TO EXCEL:</u>
        <input class="spaced excel_button excelImg" type="button" name="export_to_excel"  /></div></div>
        </td>
        </tr>
    </table>
            </td>
        </tr>
    </table>
    <table  class="" border="0" width="100%"  >
        <tr><th align="center" id="vRNumber" style="color:#0209c7;cursor:default" width="11%" ><u>REPORT NUMBER ...click</u></th><td align="center" id="vQNumber"  width="9%" style="cursor:default" ><u><b>QUOTE NUMBER ...click</b></u></td><td align="center" id="vDescrip"  width="30%" style="cursor:default" ><u><b>DESCRIPTION</b></u></td><td align="center" id="vCansO" width="20%" style="cursor:default" ><u><b>CLIENT / OWNER...click</b></u></td><td align="center" id="vTO" width="10%" style="cursor:default" ><u><b>T.O. ...click</b></u><td align="center" id="vDor" width="8%" style="cursor:default" ><u><b>DOR...click</b></u></td><td align="center" id="vFile" width="6%" style="cursor:default" ><u><b>FILE</b></u></td><td align="center" id="vSource" width="6%" style="cursor:default" ><u><b>SOURCE</b></u></td></td></tr>
        </table>
    
    </form>
<script type="text/javascript">
    $('.excel_button').on('click',function(){
        var countOfData = $("#disabledCount").val();
            var didConfirm = confirm("Are you sure you to want to send report data for "+countOfData+" reports to MS Excel?");
                if (didConfirm == true) {
                    $('#hiddenExportToExcelLimit').val($("select[name=export_to_excel_limit]").val());
                     //$('#hiddenOrgType').val($("select[name=org_type]").val());
                     $('#hoddenExportToExcel').val('55');
                     $("#contacts_listing_filter_job").submit();
                   return true;
                }else{
                    return false;
                }
        });
    
   $("#vRNumber").click(function(){
   $("#col2").click();
   $(this).css('color', '#0209c7');
   $("#vQNumber").css('color', '#000000');
   $("#vDescrip").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   $("#vTO").css('color', '#000000');
   $("#vDor").css('color', '#000000');
   $("#vFile").css('color', '#000000');
   $("#vSource").css('color', '#000000');
  
   
});

 $("#vQNumber").click(function(){
   $("#col3").click();
   $(this).css('color', '#0209c7');
   $("#vRNumber").css('color', '#000000');
   $("#vDescrip").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   $("#vTO").css('color', '#000000');
   $("#vDor").css('color', '#000000');
   $("#vFile").css('color', '#000000');
   $("#vSource").css('color', '#000000');
  
   
});
$("#vCansO").click(function(){
   $("#col5").click();
   $(this).css('color', '#0209c7');
   $("#vRNumber").css('color', '#000000');
   $("#vDescrip").css('color', '#000000');
   $("#vQNumber").css('color', '#000000');
   $("#vTO").css('color', '#000000');
   $("#vDor").css('color', '#000000');
   $("#vFile").css('color', '#000000');
   $("#vSource").css('color', '#000000');
  
   
});
$("#vTO").click(function(){
   $("#col6").click();
   $(this).css('color', '#0209c7');
   $("#vRNumber").css('color', '#000000');
   $("#vDescrip").css('color', '#000000');
   $("#vQNumber").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   $("#vDor").css('color', '#000000');
   $("#vFile").css('color', '#000000');
   $("#vSource").css('color', '#000000');
  
   
});

$("#vDor").click(function(){
   $("#col7").click();
   $(this).css('color', '#0209c7');
   $("#vRNumber").css('color', '#000000');
   $("#vDescrip").css('color', '#000000');
   $("#vQNumber").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   $("#vTO").css('color', '#000000');
   $("#vFile").css('color', '#000000');
   $("#vSource").css('color', '#000000');
  
   
});

    
    $("#visibleSelect").on("change",function(){
    $('#limitData').val($("#visibleSelect").val());
    });   

    
    jQuery(document).ready(function($){
    
    setInterval(function(){ 
        
        if($('#DataTables_Table_0_info').html()!=''){
         var arr_spliter =   $('#DataTables_Table_0_info').html().split('to');
         
         if(arr_spliter.length > 1){
        var countOfgrid=arr_spliter[1];

        var val_div = document.getElementById("disabledCount").value=countOfgrid.split('of')[0];
            $('#disabledCount').html($('#DataTables_Table_0_info').html(val_div));}
        }},1000);
    

    });
   
    

    
</script>