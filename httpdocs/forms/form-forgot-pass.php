<?php
//Prevent the user visiting this page if he/she is already logged in
global $user;
if($user->loggedin == 1) { 
	printf("<script>location.href='".SITE_URL."admin/users/routing.php'</script>");
}
?>
<form id="contactForm" method="post" action="">

	<input type="hidden" name="form" value="forgot-pass"/>
	<input type="hidden" name="type" value="login"/>

	<label for="username">Username</label>
	<input id="username" type="text" name="username" value="<?=isset($fields['username'])?$fields['username']:''?>"/>

	<label for="email">Email</label>
	<input id="email" type="text" name="email" value="<?=isset($fields['email'])?$fields['email']:''?>"/>
			
	<input name="submit" type="submit" class="button submit right" value="Submit"/>

</form>
