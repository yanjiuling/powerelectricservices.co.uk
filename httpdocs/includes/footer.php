		<div id="footer">
			
			<div class="container">
		
				<div id="footer_text">
					<?= str_replace($find,$replace,$globalSettings['footer_text'])?>
					
					<div class="footerNavHolder">
							
						<?= buildMenu('footerNav',0,'',0,1,'',true,' | ','footerNav2'); ?>
					</div>

				</div> <!-- #footer_text -->
				
			</div> <!-- .container -->
							
		</div> <!-- #footer -->
			
	</div> <!-- #content_wrap -->

</div> <!-- #full_wrap -->

<?php
if($user->loggedin == false)
{
	echo $globalSettings['tracker_code'];
}
?>