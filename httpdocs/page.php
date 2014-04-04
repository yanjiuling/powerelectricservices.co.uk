<?php
include_once(SRV_ROOT."admin/pages/class.page.php");
include_once(SRV_ROOT."admin/extensions/projects/functions.php");
include_once(SRV_ROOT."forms/functions.php");
include_once(SRV_ROOT."includes/functions.php");
get_page_details();
$contactemails = $globalSettings['admin_email'];
$fields = formSubmit($contactemails);
include(SRV_ROOT."includes/meta.php");
?>
</head>

<body class="<?=$tl_page->slug?> <?=$tr_page->slug?>">

	<div id="wraper">
	
		<?php include(SRV_ROOT."includes/header.php"); ?>

        <?php include(SRV_ROOT."includes/slideshow.php"); ?>

        <div id="main">
        
        	<div class="container">

	        	<?php include(SRV_ROOT."includes/serviceNav.php"); ?>
	        	
                    <div id="content">
	
						<?php
						switch($view)
						{
							case 'search':
							
								include(SRV_ROOT."includes/content-search.php");
					
							break;	
							
							case 'page':
							
								include(SRV_ROOT."includes/content-page.php");
					
							break;
							case 'project':
							
								include(SRV_ROOT."includes/content-project.php");
					
							break;
						
						}
						?>
							
                    </div><!--content-->
                </div> <!--container -->
        </div> <!-- #main -->
        
        
   	    <!--<div class="push"></div>-->
    
	</div><!--wraper--> 

	<?php include(SRV_ROOT."includes/footer.php"); ?>
</body>
</html>