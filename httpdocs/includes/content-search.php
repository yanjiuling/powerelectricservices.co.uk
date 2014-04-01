<?php
$search_results = array();
if ($searchText != '')
{
	// Trim query
	$searchText=ltrim($searchText);
	$searchText=rtrim($searchText);
	
	if (tableExists($db_name, 'people'))
	{
		include_once(SRV_ROOT."admin/extensions/people/functions.php");
		// Search people
		$query  = "SELECT pp_id FROM people 
					WHERE CONCAT(pp_firstNames,pp_surname) LIKE '%$searchText%'  
					AND pp_active = '1' 
					ORDER BY pp_surname";
	
		$result = dbQuery($query);
		if (dbRows($result) > 0)
		{
			while ($row = dbAssoc($result))
			{
				$pp = new person($row['pp_id']);
				$pp_excerpt = str_replace($find,$replace,$pp->summary);
				$pp_excerpt = substrws($pp_excerpt, 300);
				$search_results[] = array(	'title'		=> $pp->fullName,
											'header'	=> $pp->position,
											'excerpt'	=> $pp_excerpt,
											'url'		=> SITE_URL."people/profile/".$pp->slug
										);
			}
		}
	}
	
	// Search pages
	$query = "SELECT 	page_id,
						page_menu,
						page_title,
						page_slug,
						text_header,
						text_content
				FROM 	cms_pages, cms_page_text
			WHERE MATCH	(text_header,
						text_content) 
				AGAINST('$searchText')
				AND		text_pageID = page_id
				AND		page_active = '1'";
	$result = dbQuery($query);
	if (dbRows($result) > 0)
	{
		while ($row = dbAssoc($result))
		{
			$s_page = new page($row['page_id']);
			extract($row,EXTR_PREFIX_ALL,"s");
			
			
			$s_text_header = str_replace($find,$replace,$s_text_header);
			$s_text_content = str_replace($find,$replace,$s_text_content);
			$s_text_content = substrws($s_text_content, 300);
			//$s_text_content = str_replace($searchText, '<span class="highlight">'.$searchText.'</span>',$s_text_content);					
			$s_page_path = $s_page->get_path();

			$path='';
			foreach($s_page_path as $node)
			{
				$path .= $node['slug']."/";
			}
			$search_results[] = array(	'title'		=> $s_page->title,
										'header'	=> $s_text_header,
										'excerpt'	=> $s_text_content,
										'url'		=> SITE_URL.$path
									);
		}
	}

}
?>
			
<div id="content">

	<h1><?=lang("SEARCH_RESULTS_FOR")?> "<?=$searchText?>"</h1>
	
	<div class="search-results">
		<?php
		if(count($search_results)>0)
		{
			foreach($search_results as $res)
			{
				?>
				<div class="result">
					<h2><a href="<?= $res['url'] ?>"><?= $res['title']; ?></a></h2>
					<?= $res['header'] !='' ? "<h3>".$res['header']."</h3>" : ""; ?>
					<?= $res['excerpt']; ?>
				</div>									
				<?php
			}
		}
		else
		{
			?>
			<p><?=lang("EMPTY_SEARCH")?></p>
			<?php
		}
		?>
	</div> <!-- .search-results -->
	
</div> <!-- #content -->