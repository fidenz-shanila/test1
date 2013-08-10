<div width="100%"  style="background-color:#8FA5FA;overflow:hidden;border:none;">
<form action="" method="post" >
    
    <div class="" style="width:100%;background-color: #8FA5FA;height:350px;">
	<h2  style="text-align:center;margin-top:5px; margin-left:20%;margin-right:20%;">SELECT CATEGORY(S) TO APPLY TO CONTACT LIST</h2>
            
	   <table  class=""   border="0" style="height:300px;width:80%;margin-left:10%;margin-top:0px; background-color: #8fa8f7;">
	        <tr>
	            <td class="" style="height:25%;width:80%;background-color: #FFD9C6;text-align: center;"></br>
                        <h3 style="padding-bottom:5px" ><u>CONTACT CATEGORY</u></h3>
                        <?php $a=array(''=>''); ?>
	                 <?php  echo \Form::select('contact_cat', '', array_merge($a,$contact_cats),array('class'=>' center'), array('id'=>'visibleContactCat')); ?>
                        <?php echo \Helper_Form::clear_select('contact_cat'); ?>
                        
	            </td>
                    </tr><tr style="height:10px;width:100%;background-color: #cedecc;"></br></br></tr>
	            
                    <tr>
	            <td style="height:25%;width:80%;background-color: #CFDECB; text-align: center;"></br>
                        <h3 style="padding-bottom:5px"><u>ORGANISATION CATEGORY</u></h3>
                        <?php echo \Form::select('org_cat', '', array_merge($a,$org_cats), array('class'=>' center'),array('id'=>'visibleOrgCat')); ?>
                        <?php echo \Helper_Form::clear_select('org_cat'); ?>
                        
	            </td>
	            </tr>
                    <tr>
                        <td> 
<!--                           <button href="" onClick="setDataJs();" id="abc" style="height:40px;width:15%;margin-left:80%; margin-right:5px;;" class=""><b>APPLY</b></button>-->
                          <div style=" float: right;border: 1px solid #A2A2A2;margin: 0 0 0 5px;padding: 5px;"> <input type="button" style="height:40px;width:100%; margin-right:5px;font-weight:bold;" onClick="setDataJs();" value="APPLY"/></div>
                        </td>
                        
                    </tr>
	                
	         	
	    </table>
            
       </div>
       </div>
<script type="text/javascript">


    function setDataJs(){
    var contact_cat=document.getElementsByName("contact_cat")[0].value;
    var org_cat=document.getElementsByName("org_cat")[0].value;
     parent.setData(contact_cat,org_cat);
      parent.$('body').css('overflow','auto');
     parent.$('#CatWendow').dialog('close');
    }
        
</script>
<style>
    .center
    {
        margin-left:10%; 
        margin-right:4px;
        margin-top:5px;
        width:60%;
    }
</style>

</form>
