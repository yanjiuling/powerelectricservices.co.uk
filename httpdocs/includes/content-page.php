<?php	
global $find,$replace;
//Additional text replacements
array_push($find, 
					"<p>[[FORM:CONTACT]]</p>", 
					"<p>[[FORM:LOGIN]]</p>",
					"<p>[[FORM:FORGOT-PASS]]</p>"
);
					
array_push($replace, 
					getIncludeContents(SRV_ROOT."forms/form-contact.php"), 
					getIncludeContents(SRV_ROOT."forms/form-login.php"),
					getIncludeContents(SRV_ROOT."forms/form-forgot-pass.php")
);

//!PAGE LAYOUTS
switch(strtolower($tr_page->get_page_type()))
{			
	default:
		
		//!DEFAULT PAGE LAYOUT

		$tr_page_path = $tr_page->get_path();
		$tl_page = new page($tr_page_path[0]['id']);
		
		?>
					
		<div id="content">
			
			<?php displayMessage(); ?>
			
			<?php
			if($tr_page->showTitle == 1)
			{
				?>
				<h1 class="content-title"><?=$tr_page->title?></h1>
				<?php
			}
			
			$main_text = $tr_page->get_text_block('primary');
			echo $main_text != '' ? $main_text : "";
					
			?>
			
		</div> <!-- #content -->

		<?php
	break;
}
?>