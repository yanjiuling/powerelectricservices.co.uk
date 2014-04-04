<?php
include_once(SRV_ROOT."admin/pages/class.page.php");
include_once(SRV_ROOT."admin/extensions/projects/functions.php");
include_once(SRV_ROOT."includes/functions.php");
get_page_details();
include(SRV_ROOT."includes/meta.php");
?>
</head>

<body id="home">

	<div id="wraper">
	
		<?php include(SRV_ROOT."includes/header.php"); ?>

        <?php include(SRV_ROOT."includes/slideshow.php"); ?>

        <div id="main">
        
        	<div class="container">

	        	<?php include(SRV_ROOT."includes/serviceNav.php"); ?>
	        	
                    <div id="content">
                    
	                    <div class="text">
	                    
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
								                     
	                    </div><!--text-->
	                    
	                    <div class="sidebar">
		                    <?php
							$page_images = $tr_page->get_images();
							foreach($page_images as $img)
							{
								$image = new image($img['med_id']);
								
								echo "<div class=\"sec-slideshow\">\n";
								echo image_html($image);
								echo "</div><!--sec-slideshow-->\n";
									
							}
							?>
	                    </div>
                    
                    </div><!--content-->
                </div> <!--container -->
        </div> <!-- #main -->
        
        
   	    <!--<div class="push"></div>-->
    
	</div><!--wraper--> 

	<?php include(SRV_ROOT."includes/footer.php"); ?>
</body>
</html>