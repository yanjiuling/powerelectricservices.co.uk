<form id="contactForm" method="post" action="index.php">

	<label for="login">Username</label>
	<input id="username" type="text" name="username"  />

	<label for="password">Password</label>
	<input id="password" type="password" name="password" />

	<div class="inline-group">
		<label><input type="checkbox" class="radio" name="remember_me" id="remember_me" value="1" /> Keep me logged in for <?php echo getCookieLength(REMEMBER_ME_LENGTH);?></label>
	</div>
	
	<input name="submit" type="submit" class="button submit" value="Log in"/>

</form>
