<?php echo $form->open();?>		
<div id="artefact_des">
        
        <div class="content">
            
            <h1>ARTEFACT DESCRIPTION</h1>
            
            <div class="box-1">
                <div class="c1">
                    <table cellpadding="0" cellspacing="0" border="0" class="quote_tab_lock">
                        <tr>
                            <td width="15%"><p>Type:</p></td>
                            <td colspan="3">
                            <?php echo $form->build_field('A_Type'); ?>
                            <span>(limit to list)</span></td>
                        </tr>
                        <tr>
                            <td><p>Make:</p></td>
                            <td><?php echo $form->build_field('A_Make'); ?></td>
                            <td width="15%"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><p>Model:</p></td>
                            <td><?php echo $form->build_field('A_Model'); ?></td>
                            <td><p>Range:</p></td>
                            <td><?php echo $form->build_field('A_PerformanceRange'); ?></td>
                        </tr>
                        <tr>
                            <td valign="top"><p>S/N:</p></td>
                            <td colspan="3"><?php echo $form->build_field('A_SerialNumber'); ?></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-2">
                        <tr>
                            <td width="80%"><p>DESCRIPTION (Van be edited, or use 'BUILD' for basing on above)</p></td>
                            <td><input type="button" class="button1"  value="BUILD" id="build"  /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><?php echo $form->build_field('A_Description'); ?></td>
                        </tr>
                    </table>
                </div>
                
            </div>
            
  
            <div class="box-2">
                <div class="rightside">
                    <div class="blk"><input type="button" class="button2" value="close" id="btn_close" onclick="parent.jQuery.fn.colorbox.close();" /></div>
                    <div class="blk"><?php echo $form->build_field('Save'); ?></div>
                </div>
            </div>
            
        </div>
        
    </div>
    
<script type="text/javascript">
    
    $('#build').click(function(){
        
        var A_Type = $('#A_Type').val();
        var A_Make = $('#A_Make').val();
        var A_Model = $('#A_Model').val();
        var A_PerformanceRange = $('#A_PerformanceRange').val();
        var A_SerialNumber = $('#A_SerialNumber').val();
        var A_Description = $('#A_Description').val();
        
        $.ajax({
            url : "<?php echo \Uri::create('Artefacts/build_description'); ?>",
            data : {'A_Type':A_Type, 'A_Make':A_Make, 'A_Model':A_Model, 'A_PerformanceRange':A_PerformanceRange, 'A_SerialNumber':A_SerialNumber, 'A_Description':A_Description},
            method:"post",
            dataType : "json",
            success : function(data){
                    $('#A_Description').val(data.A_Description);
            },
        });
    });
        
        
</script>
