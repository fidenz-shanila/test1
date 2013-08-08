<?php //echo $form->open();?>
	<form onsubmit="return validate();" method="post">
    <div id="insert_new_employee">
    	
        <div class="content">
        	
            <h1>INSERT NEW EMPLOYEE</h1>
            
            <div class="box-1">
            	
                <table cellpadding="0" cellspacing="0" border="0" class="table-1">
                    <tr>
                        <td width="20%" valign="top"><p>Tital:</p></td>
                        <td valign="top"><?php echo $form->build_field('title'); ?><h6>(Not limited to list)</h6></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>First Name:</p></td>
                        <td valign="top"><?php echo $form->build_field('fname'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Last Name:</p></td>
                        <td valign="top"><?php echo $form->build_field('lname'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Initials:</p></td>
                        <td valign="top"><?php echo $form->build_field('initials'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Position:</p></td>
                        <td valign="top"><?php echo $form->build_field('position'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Phone:</p></td>
                        <td valign="top"><?php echo $form->build_field('phone'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Email:</p></td>
                        <td valign="top"><?php echo $form->build_field('email'); ?><input type="button" class="button1" value="Build" /><div id="msg_email"></div></td>
                    </tr>
                    
                      <tr>
                        <td  colspan="2">
                        <table class="blk2">
                       <tr>
                        <td valign="top"><p>User Role:</p></td>
                        <td valign="top"><?php //echo $form->build_field('userrole'); ?><?php echo $form->build_field('chk_role'); ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><p>Username:</p></td>
                        <td valign="top"><?php echo $form->build_field('uname'); ?><div id="msg"></div><input type="hidden" id="hidstatus"/></td>
                    </tr>
                    
                   <tr>
                        <td valign="top"><p>Password:</p></td>
                        <td valign="top"><?php echo $form->build_field('password'); ?></td>
                    </tr>
                        </table>
                        </td>
                      </tr>
                     
                    
                </table>
                
                
          </div>
            
            <div class="box-2">
            	<div class="rightside">
		    <div class="blk"><?php echo $form->build_field('submit'); ?></div>
                    <div class="blk"><input type="button" class="cb iframe close button2" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>


</body>
</html>

<script type="text/javascript">

function validate(){ 
	var usrname = $("#hidstatus").val();
	if(usrname == 1){
		alert('This username is not valid username');
		return false;
	}else{
		return true;
	}
}

function emailcheck(){
		var email = $("#email").val();
		$("#hidstatus").val(0);
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) 
		{
			$("#msg_email").html('<span style="color:green; font-wight:bold;">This email is OK</span>');
			return true;
		}else{
			$("#msg_email").html('<span style="color:red; font-wight:bold;">label must be a valid email address</span>');
			$("#hidstatus").val(1);
			return false;
			
		}
}

function check_user_id(){ 
if(emailcheck()){}else{alert('email address is not valid email address'); return false;}
var usrname = $("#txt_uname").val();
$("#hidstatus").val(0);

var xhr =$.ajax({
	url: "<?php echo \Uri::create('employees/check_emp_id/');?>"+usrname,
	//context: document.body
	}).done(function(msg) {
	
		var s = usrname.indexOf("@");
			s = s+usrname.indexOf(".");
			s = s+usrname.indexOf(" ");
		if(s<=-1){
			if(msg==1){
				$("#msg").fadeTo("slow");
				$("#msg").html('<span style="color:red; font-wight:bold;">This username alrady in use</span>');
				$("#hidstatus").val(1);
				return false;
			}else{
				$("#msg").fadeTo("slow");
				$("#msg").html('<span style="color:green; font-wight:bold;">You can use this id</span>');
				return true;
			}
		}else{
			$("#msg").fadeTo("slow");
			$("#msg").html('<span style="color:red; font-wight:bold;">This username not valid username please remove "@ or dot(.) or spaces". </span>');
			$("#hidstatus").val(1);
			return false;
		}
	});
//setTimeout(xhr.abort(),3000);
}



</script>