<div id="header">
	
	<div class="container">
		
			<p id="site_logo">
				<a href="<?=SITE_URL?>"><img src="<?=SITE_URL?>images/logo.png" alt="<?=SITE_NAME?>" /></a>
			</p>
																
	</div> <!-- .container -->
					
</div> <!-- #header -->

<div id="mainNavHolder">

	<div class="container">
	
		<?php
		$mainNav = buildMenu('mainNav',0,'',0,1,'',true,'','');
		echo $mainNav;
		?>		
		
	</div>
	
</div> <!-- #mainNav_holder -->