<?php
include_once(SRV_ROOT."admin/pages/class.page.php");
include_once(SRV_ROOT."forms/functions.php");
include_once(SRV_ROOT."includes/functions.php");
get_page_details();
$contactemails = $globalSettings['admin_email'];
$fields = formSubmit($contactemails);
include(SRV_ROOT."includes/meta.php");
?>
</head>

<body>

	
	<?php include(SRV_ROOT."includes/header.php"); ?>

	<?php
	switch($view)
	{
		case 'search':
		
			include(SRV_ROOT."includes/content-search.php");

		break;	
		
		case 'page':
		
			include(SRV_ROOT."includes/content-page.php");

		break;
	
	}
	?>
							
	<?php include(SRV_ROOT."includes/footer.php"); ?>
</body>
</html>