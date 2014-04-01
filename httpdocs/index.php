<?php
include_once(SRV_ROOT."admin/pages/class.page.php");
include_once(SRV_ROOT."includes/functions.php");
get_page_details();
include(SRV_ROOT."includes/meta.php");
?>
</head>

<body>

	<?php include(SRV_ROOT."includes/header.php"); ?>

	<div id="content">
	
		<div class="container">
			
			<div id="mainContent">
				
				<?php
				$banner = get_banner($tr_page);
				if($banner)
				{
					?>
					<div class="banner"><img src="<?= media($banner->path)?>"></div>
					<?php
				}
				?>

				<?php
				if($tr_page->showTitle == 1)
				{
					$page_title = $tr_page->get_page_title();
					?>
					<h1><?=$page_title['content']?></h1>
					<?php
				}
				$main_text = $tr_page->get_text_block('primary');
				echo $main_text;
				?>					
	
			</div> <!-- #mainContent -->
				
		</div> <!-- .container -->
			
	</div> <!-- #content -->

	<?php include(SRV_ROOT."includes/footer.php"); ?>
</body>
</html>