<body>
<div id="chng_fee_due">
    <div class="changefee">
        <div class="box-1">
            
            <table border="0px" width="100%">
                <tr>
                    <td><h1>CHANGE FEE DUE</h1></td>
                </tr>
                <tr>
                    <td>
                        <p>FEE DUE  </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                       <input class="currency"  type="text" id="fee_due_text" value="<?php echo $val;?>" /> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" id="apply" value="APPLY" class="button-1" />
                                            </td>
                </tr>
            </table>
            
            
        </div>
    </div>
</div>
    <script type="text/javascript">
        $('#apply').click(function(){
            var value = $('#fee_due_text').val();
            parent.change_value(value,<?php echo $x; ?>);
            parent.update_total_due();
            parent.$.colorbox.close();
        })
        </script>
</body>
