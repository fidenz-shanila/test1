<form action="" id="contacts_listing_filter" class="grid_filter">
    
    <table  class="" border="0" width="100%" >
        <tr>
            <td width="20%">
            </td><td width="40%" align="center">
                <h1 style="font-size:200%;font-family:Arial,Helvetica,sans-serif;">NMI EMPLOYEE LISTING</h1>
                
            </td>
            <td>
            <table  class="" border="0" width="100%" >  
                <tr>
            <td  align="left" ><div style="border:1px solid #a1a1a1;margin:5px;margin-right:5px"><div align="center"  style=" margin:5px;padding:2px;">
       SEND TO EXCEL:<input class="spaced excel_button excelImg" type="button" name="export_to_excel"  />
      
                </div></div></td><td><div style="border:1px  solid #a1a1a1;margin:5px;margin-right:5px;"><div align="center"   style="margin:5px;;padding:2px;">
         RECORD COUNT:
               <?php //$valueOfCount=new Controller_Contacts() ;
              // $valueOfCount1=$valueOfCount->listing();
               echo '<input  type="text" size="5%" id="disabledCount" value="" readonly="readonly" style="text-align:center" />' ?></div></div>
        </td>
        </tr>
    </table>
            </td>
        </tr>
    </table>
    <table  class="" border="0" width="100%"  >
        <tr><th align="center" id="vNumber" style="color:#0209c7;cursor:default" width="17%" ><u>FULLNAME...CLICK</u></th><td align="center" id="vArtrfact" style="cursor:default" width="15%"><u><b>PHONE</b></u></td><td align="center" id="vCansO" style="cursor:default" width="46%"><u><b>POSITION</b></u></td><td align="center" id="vStatus" style="cursor:default" width="22%"><u><b>SITE...CLICK</b></u></td></tr>
        </table>
    
    </form>
<script type="text/javascript">
    $('.excel_button').on('click',function(){
        var countOfData = $("#disabledCount").val();
          //  var didConfirm = confirm("Are you sure you to want to send job data for "+countOfData+" job to MS Excel?");
                //if (didConfirm == true) {
                    $('#hiddenExportToExcelLimit').val($("select[name=export_to_excel_limit]").val());
                     $('#hiddenOrgType').val($("select[name=org_type]").val());
                     $('#hoddenExportToExcel').val('55');
                     $("#contacts_listing_filter_job").submit();
                  // return true;
               // }else{
                   // return false;
               // }
        });
    
   $("#vNumber").click(function(){
   $("#col2").click();
   $(this).css('color', '#0209c7');
   $("#vArtrfact").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
   $("#vStatus").css('color', '#000000');
  
   
});

 

$("#vStatus").click(function(){
   $("#col5").click();
   $(this).css('color', '#0209c7');
   $("#vNumber").css('color', '#000000');
   $("#vArtrfact").css('color', '#000000');
   $("#vCansO").css('color', '#000000');
  
   
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
    dt.fnDraw();
    });
    
</script>