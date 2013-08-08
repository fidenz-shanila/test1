<form id="login_box">
	<div class="content">
		<input type="text" placeholder="Username" id="username" name="username" />
		<input type="password" placeholder="Password" id="password" name="password" />
		<input type="submit" class="signin" name="login" value="Sign In" />
	</div>
</form>
<script type="text/javascript">
	$('#login_box').submit(function(){

		var username = $('#username').val();
		var password = $('#password').val();
		$('.signin').val('Please wait..');
		$.ajax({
		  type: "POST",
		  dataType: 'json',
		  url: "<?php echo \Uri::create('auth/login'); ?>",
		  data: { "username": username, "password": password }
		}).done(function( msg ) {
		  if(msg.status == 'success') {
		  	window.location = '<?php echo \Uri::create('dashboard'); ?>';
		  }
		  else {
		  	$('.signin').val('Sign In');
		  	alert(msg.msg);
		  }
		});

		return false;

	});
</script>