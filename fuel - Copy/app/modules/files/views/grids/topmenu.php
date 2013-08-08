<form action="" id="contacts_listing_filter" class="grid_filter mainForm">
    
    <table  class="" border="0" width="100%" >
        <tr>
            <td width="17%"><table  style="margin:5px; border:1px solid #a1a1a1;margin-right:5px" ><tr><td>
                             <div  style="margin:5px;padding:2px;min-height:18px;">
                <label >OWNER TYPE:</label>
                <select name="owner_type" class="filter_field" id="wdb_ownerType"></select>
                <?php echo \Helper_Form::clear_select('owner_type',array('style'=>'max-width:4%;')); ?>
                 </div></td></tr></table>
                
            </td>
            <td width="13%"><table  style="margin:5px; border:1px solid #a1a1a1;margin-right:5px" ><tr><td>
                 
                <div  style="margin:5px;;padding:2px;min-height:18px;padding-left:5px;">
                    <label >FILE TYPE:</label>
                <select name="file_type" class="filter_field" id="wdb_fileType"></select>
                <?php echo \Helper_Form::clear_select('file_type',array('style'=>'max-width:4%;')); ?>
                 </div></td></tr></table>
                
            </td><td align="center">
                <h1 style="font-size:200%;">SELECT CB FILE</h1>
                
            </td>
            <td>
            <table  class="" border="0" width="100%" >  
                <tr>
                     
                    <td><div style="border:1px solid #a1a1a1;margin:5px;margin-right:5px"><div align="center"  style=" margin:5px;padding:2px;"><input type="checkbox" class="checkbox filter_field  checkBoxStl" name="optShowCatchAlls" id="optShowCatchAlls" value="no" /><label >Show CatchAlls</label></div></div></td>
            <td   align="left" ><div style="border:1px solid #a1a1a1;margin:5px;margin-right:5px"><div align="center"  style=" margin:5px;padding:2px;">DISPLAY TOP:
        <?php echo \Form::select('export_to_excel_limit', 200, array( 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 5000 => 5000, 10000 => 10000,'ALL'),array('id'=>'visibleSelect','onclick'=>'displayVals()','class'=>'filter_field'));?>
       RECORD COUNT:
               <?php //$valueOfCount=new Controller_Contacts() ;
              // $valueOfCount1=$valueOfCount->listing();
               echo '<input  type="text" size="5%" id="disabledCount" value="" disabled="disabled"  />' ?>
                </div></div></td>
                
                <td ><div style="border:1px  solid #a1a1a1;margin:5px;margin-right:5px;"><div align="center"   style="margin:5px;;padding:2px;"><u>SEND TO EXCEL:</u>
        <input class="spaced excel_button excelImg" type="button" name="export_to_excel"  /></div></div>
        </td>
        </tr>
    </table>
            </td>
        </tr>
    </table>
    <table  class="" border="0" width="100%"  >
        <tr><th align="center" id="vNumber" style="color:#0209c7;cursor:default" width="15%" ><u>NUMBER...CLICK</u></th><td align="center" id="vArtrfact" style="cursor:default" width="72%"><u><b>TITLE...CLICK</b></u></td><td align="left" id="vCansO" width="13%" style="cursor:default" ><u><b>LOCATION...CLICK</b></u></td></tr>
        </table>
    
    </form>

<script type="text/javascript">
    $('.excel_button').on('click',function(){
        var countOfData = $("#disabledCount").val();
            var didConfirm = confirm("Are you sure you to want to send CB file data for "+countOfData+" CB files to MS Excel?");
                if (didConfirm == true) {
                    $('#hiddenExportToExcelLimit').val($("select[name=export_to_excel_limit]").val());
                     $('#hiddenOrgType').val($("#owner_type").val());
                     $('#hiddenFileType').val($("#wdb_fileType").val());
                     $('#hiddenOptShowCatchAlls').val($("#optShowCatchAlls").val());
                     $('#hoddenExportToExcel').val('55');
                     $("#contacts_listing_filter_job").submit();
                   return true;
                }else{
                    return false;
                }
        });
    
   $("#vNumber").click(function(){
   $("#col2").click();
   $(this).css('color', '#0209c7');
   $("#vArtrfact").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
  
  
   
});

 $("#vArtrfact").click(function(){
   $("#col4").click();
   $(this).css('color', '#0209c7');
   $("#vNumber").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   
  
   
});
$("#vCansO").click(function(){
   $("#col5").click();
   $(this).css('color', '#0209c7');
   $("#vNumber").css('color', '#000000');
   $("#vArtrfact").css('color', '#000000');
   $("#vStatus").css('color', '#000000');
  
   
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
    
    $('#orgType').change(function(){ 
    $('#orgType').html('<option >'+$(this).val()+'</option>');
    });
    
    $('#clearBtn').click(function(){ 
    $('#orgType').html('<option ></option><option value="EXTERNAL" >EXTERNAL</option><option value="NMI" >NMI</option>');
   // alert('ee');
    dt.fnDraw();
    });
    
      $('input[type="checkbox"]').click(function(){
            if($(this).is(':checked')){
                $(this).attr('value','yes');
            }else{
                $(this).attr('value','no');
            }
            dt.fnDraw();
        });
    
</script>

