<?php			
//!PAGE LAYOUTS
$page_type = $tr_page->get_page_type();
switch($page_type)
{
	case 'contact':
		
		?>
        <div class="contact-form">
        	
			<?php
			displayMessage();
			if($tr_page->showTitle == 1)
			{
				$page_title = $tr_page->get_page_title();
				?>
				<h1><?=$page_title['content']?></h1>
				<?php
			}
        	
            include(SRV_ROOT."forms/form-contact.php");
            ?>
         
        </div><!--contact-form-->
        
        <div class="email">
        	<?php
        	$main_text = $tr_page->get_text_block('primary');
			echo $main_text;
			?>
       </div><!--email-->
		<?php
	
	break;

	case 'people':
		//!PEOPLE PAGE LAYOUT
		?>

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
	    </div>
	    <div class="clear"></div>
		<?php
		include_once(SRV_ROOT."admin/extensions/people/functions.php");
		$people = get_people_list();
		if(count($people)>0)
		{
			foreach($people as $pp_id)
			{
				?>
				<div class="text">
					<?php
					$pp = new person($pp_id);
					?>					
					<div class="pp_details column fourcol">
						<div class="pp_head">
							<h3 class="pp_name"><?=$pp->fullName?></h3>
							<h4 class="pp_position"><?=$pp->position?></h4>
						</div>
						<?=$pp->details?>
					</div> <!-- .pp_details -->
					
				</div> <!-- .text -->
				<div class="sidebar">
						
						<?php
						$ppic = $pp->get_profile_pic();
						?>
						<img src="<?=media($ppic->path_tn)?>" alt="<?=$ppic->alt?>" />
						
				</div> <!-- .sidebar -->
				<div class="clear"></div>	
				
				<?php
			}
		}

	break;
	
	default:
		//!DEFAULT PAGE LAYOUT
		?>
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
				if($image->url !='')
				{
					echo "<a href=\"".$image->url."\" target=\"".$image->target."\">";
				}
				else
				{
					echo "<a href=\"".media($image->path)."\" target=\"".$image->target."\" class=\"zoom\" rel=\"gallery\">";
				}
				echo "<img src=\"".media($image->path_tn)."\" alt=\"".$image->alt."\" />";
				echo "</a>\n";
				echo "</div><!--sec-slideshow-->\n";
					
			}
			?>
	    </div>
	    <?php
	break;
}
?>
		
