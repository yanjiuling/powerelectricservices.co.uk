<div class="project">
	
	<div class="text">

		<h1><?=$proj->title?></h1>
		<?= $proj->text; ?>

	</div> <!-- .text -->
	
	<div class="sidebar">
		<?php
		$proj_items = $proj->get_items();
		if(count($proj_items)>0)
		{
			foreach($proj_items as $itemrow)
			{
				$item = new project_item($itemrow['item_id']);
				?>
				<div class="sec-slideshow">
					<?php
					if($item->embedcode !='')
					{
						echo($item->embedcode);
					}
					else
					{
						$img = new image('',$item->id,'project');
						if($img->id != '')
						{
							?>
							<a href="<?=media($img->path)?>" class="zoom" rel="gallery">
								<img src="<?=media($img->path_tn)?>" alt="<?=$img->alt?>" />
							</a>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
		}
		?>
	</div>		
		
</div> <!-- .project -->