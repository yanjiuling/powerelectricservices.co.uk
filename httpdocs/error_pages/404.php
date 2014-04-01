<?php
include_once(SRV_ROOT."admin/pages/class.page.php");
include_once(SRV_ROOT."includes/functions.php");

$level1 = "404";
$this_slug = $level1;
$parent_slug = '';

$tr_page = new page('',$this_slug,$parent_slug,SITE_LANG);

if($tr_page->active == 1 || ( $user->loggedin && $user->user_groupID < 3))
{	
	$tr_page_path = $tr_page->get_path();
	
	$path='';
	foreach($tr_page_path as $node)
	{
		$path .= $node['slug']."/";
	}
	
	//Redirect to first child?
	if($tr_page->leaf == false && $tr_page->parentAsPage == '0')
	{
		$child = $tr_page->get_first_child();
		if(!is_null($child))
		{
			$tr_child = new page($child);
			header("location: ".SITE_URL.$path.$tr_child->slug);
			exit;
		}
	}
}
else
{
	$tr_page->id = '';
}

if($tr_page->id =='')
{
	die("Page not found");
}


include(SRV_ROOT."includes/meta.php");
?>
</head>

<body>

	<?php include(SRV_ROOT."includes/header.php"); ?>

	<div id="content">
	
		<div class="container">
			
			<div id="mainContent">
				<?php
				displayMessage();

				if($tr_page->showTitle == 1)
				{
					echo "<h1>";
					echo $tr_page->title;
					echo "</h1>\n";
				}
					
				$main_text = $tr_page->get_text_block('primary');
				echo $main_text;

				if(count($tr_page->images)>0)
				{
					?>
					<!--!images-->
					<div class="images">
						<?php
						foreach($tr_page->images as $image)
						{
							$img = new image($image['med_id'],'','','image',SITE_LANG);
							$img_small = media($img->dir_path.substr($img->filename, 0,-strlen(".".$img->ext))."_small.".$img->ext);
							$img_medium = media($img->dir_path.substr($img->filename, 0,-strlen(".".$img->ext))."_medium.".$img->ext);
							$img_large = media($img->dir_path.substr($img->filename, 0,-strlen(".".$img->ext))."_large.".$img->ext);
							?>
							<a class="zoom" rel="gallery" href="<?=$img_large?>" target="_blank"><img src="<?=$img_small?>" alt="<?=$img->alt?>"/></a>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div> <!-- #mainContent -->
			
	
		</div> <!-- .container -->
			
	</div> <!-- #content -->

	<?php include(SRV_ROOT."includes/footer.php"); ?>
</body>
</html>