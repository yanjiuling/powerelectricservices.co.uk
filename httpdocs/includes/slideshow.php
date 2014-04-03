<?php
if(isset($proj))
{
	$banner = $proj->get_header_image();
}
else
{
	$banner = get_banner($tr_page);
}
if($banner->id !='')
{
	?>
	<div id="slideshow">
	    <div class="container">
	        <img class="static" src="<?=media($banner->path)?>" alt="<?=$banner->alt?>"/>
	    </div><!-- end container slideshow-->
	</div><!--end slideshow-->
	<?php
}
?>