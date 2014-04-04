<div class="sec-nav">
    
	<div class="hidden mobile nav_control">
		<span class="action">Show</span> services 
		<div class="nav_control_arrow"><img src="<?=SITE_URL?>images/navarrow@2x.png" alt="" width="22" height="20" /></div>
	</div>
	<div class="services_container">
		<?= serviceNav(); ?>

		<div id="service-logos">
			<?=str_ireplace($find,$replace,$globalSettings['sidebar_foot'])?>
		</div>
	</div>
		
</div><!--sec-nav-->