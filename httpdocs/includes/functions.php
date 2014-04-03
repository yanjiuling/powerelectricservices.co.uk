<?php
function buildMenu($menu,$parent,$build,$level,$depth,$slug,$sef=true,$separator='',$class='',$activeID=0) {
   	global $thisPath,$tr_page_path,$main_page_pos,$active_path,$activeID;

   	if(!isset($active_path))
   	{
		$active_path = array();
		$active = new page($activeID);
		foreach($active->get_path() as $node)
		{
			$active_path[] = $node['id'];
		}
   	}
   	
   	$class = $class == '' ? $menu : $class;
    $query = "SELECT page_id
    			FROM `cms_pages`
    			WHERE page_parent = '$parent'
    			AND page_menu = '$menu'
				AND page_active = '1'
    			ORDER BY page_pos";
    $result = dbQuery($query);

	$count = dbRows($result);
    if ($count > 0) 
	{
		$build .= '<ul class="nav ';
		$build .= $level < 1 ? ' '.$class : '';
		$build .= ' level_'.($level+1);
		$build .= "\"";
		$build .= ">\n";				
		$level++;
		$num = 1;
		$idlist = array();
        while ($row = dbAssoc($result))
		{
			$page = new page($row['page_id'],'','',SITE_LANG);
			if($level == 1) { $idlist[] = $page->id; }
			$path = '';
			
			$page_type = $page->get_page_type();
			if($page_type == 'external' || $page_type == 'anchor')
			{
				$path = $page->type_val;
			}
			else
			{
				if($page_type == 'alias' && $page->type_val != '') //Alias
				{
					$alias = new page($page->type_val);
					$page_path = $alias->get_path();
				}
				else
				{
					$page_path = $page->get_path();
				}
				
				foreach($page_path as $node)
				{
					$path .= $node['slug'] != 'home' ? $node['slug']."/" : '';
				}
				$path = SITE_URL.$path;
			}
						
			$build .= "<li id=\"".$menu."_item_".$page->slug."\" class=\"nav".addLeadingZeros($num);
			$build .= $page->id == $activeID || in_array($page->id, $active_path) ? " active" : "";
			$build .= $page->id == $activeID ? " current" : "";
			$build .= $page->menu_class !='' ? " ".$page->menu_class : '';
			$build .= $num == $count ? " last" : "";
			$build .= $level==1 ? " toplevel" : "";
			$build .= "\"><a href=\"".$path."\"";
			$build .= $page_type == 'external' ? ' target="_blank"' : '';
			$build .= $page->accesskey != "" ? " accesskey=\"".$page->accesskey."\"" : "";
			$build .= ">" . $page->menuTitle . "</a>";
            $build = $level < $depth || $depth == 0 ? buildMenu($menu,$page->id,$build,$level,$depth,$page->slug,$sef,$separator,$class,$activeID) : $build;
            $build .= $separator !='' && $num != $count ? " $separator " : "";
            $build .= "</li>\n";
            $num++;
        }
           
        $build .= "</ul>\n";
   		
    }
 
    return $build;
}

//Get page banner. Traverse up through page tree if not added to this page

function get_banner($tr_page='') {
	
	$banner = false;
	if($tr_page !='')
	{
		foreach($tr_page->get_path() as $step)
		{
			$pathIDs[] = $step['id'];
		}
		$reversePath = array_reverse($pathIDs);
		foreach($reversePath as $id)
		{
			$p = new page($id);
			$h = $p->get_header_image();
			if($h !='')
			{ 
				$ref = $h;
				break;
			}
		}
	
		if(isset($ref))
		{
			$banner = new image($h);
		}
	}
	return $banner;
}

//Get pages from custom field value
function get_pages_from_cf_val($keyword,$val)
{
	$output = array();
	$query = "SELECT val_pageID 
			  FROM cms_page_fields, cms_page_field_values
			  	WHERE val_fieldID = field_id				  	
			  AND field_keyword = '$keyword'
			  AND val_value = '$val'";
	$result = dbQuery($query);
	if(dbRows($result)>0)
	{
		while($row = dbAssoc($result))
		{
			$output[] = $row['val_pageID'];
		}
	}
	return $output;
}

//Get twitter feed
function twitter_feed($args)
{
	$output = array();
	if(is_string($args))
	{
		parse_str($args, $args);
	}
	$defaults = array(
	    'oauth_access_token' 		=> "164466328-tDDkkPW6hzPUBH2l9sGgTTGycve5ytRapczbSEwg",
	    'oauth_access_token_secret' => "ajGdvYNQnmSOeSTZnEnf8ThiIRO1dCQYhJxzUfnmlM",
	    'consumer_key' 				=> "MSji7PUivWYCoFeSd2Sw",
	    'consumer_secret' 			=> "3joO70G8eW914JwCOUJq8L0Tg0c4McyRrBbBhlV5jAY",
	    'screen_name' 				=> 'trafficwebsites',
	    'count' 					=> 4,
	    'exclude_replies' 			=> true
	);
	$set = array_intersect_key($args + $defaults, $defaults);
	extract($set);

	//!Twitter access tokens - see: https://dev.twitter.com/apps/
	$access = array(
	    'oauth_access_token' => $set['oauth_access_token'],
	    'oauth_access_token_secret' => $set['oauth_access_token_secret'],
	    'consumer_key' => $set['consumer_key'],
	    'consumer_secret' => $set['consumer_secret']
	);
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name='.$set['screen_name'].'&count='.$set['count'].'&exclude_replies='.$set['exclude_replies'];
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($access);
	$result =  $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
	
	$tw_arr = json_decode($result, true);

	foreach($tw_arr as $tweet)
	{
		$tfind = array();
		$treplace = array();
		foreach($tweet['entities']['hashtags'] as $hash)
		{
			$tfind[] = '#'.$hash['text'];
			$treplace[] = '<a href="https://twitter.com/search?q=%23'.$hash['text'].'&src=hash" target="_blank">#'.$hash['text'].'</a>';
		}
		foreach($tweet['entities']['urls'] as $url)
		{
			$tfind[] = $url['url'];
			$treplace[] = '<a href="'.$url['url'].'" target="_blank">'.$url['url'].'</a>';
		}
		foreach($tweet['entities']['user_mentions'] as $mention)
		{
			$tfind[] = "@".$mention['screen_name'];
			$treplace[] = '<a href="https://twitter.com/'.$mention['screen_name'].'" target="_blank">@'.$mention['screen_name'].'</a>';
		}								
		$output[] = array('tweet' => str_ireplace($tfind,$treplace,$tweet['text']),
							'time' => $tweet['created_at'],
							'source' => $tweet['source']);
	}
	return $output;
}

function image_html($img,$args='')
{
	$output = '';
	if(is_string($args))
	{
		parse_str($args, $args);
	}
	$defaults = array(
	    'link_class'	=> "",
	    'img_class'		=> "",
	    'link_title'	=> "",
	    'size'			=> "full"
	);
	$set = array_intersect_key($args + $defaults, $defaults);
	
	if($img->url !='')
	{
		$output .= '<a';
		if($set['link_class'] != '')
		{
			$output .= ' class="'.$set['link_class'].'"';
		}
		$output .= ' href="'.$img->url.'" target="'.$img->target.'"';
		if($set['link_title'] != '')
		{
			$output .= ' title="'.$set['link_title'].'"';
		}
		$output .= '>';
		
	}
	
	$output .= '<img src="';
	switch($set['size'])
	{
		case "full":
			$output .= media($img->path);
		break;
		case "thumbnail":
			$output .= media($img->path_tn);
		break;
	}
	$output .= '"';
	if($set['img_class'] != '')
	{
		$output .= ' class="'.$set['img_class'].'"';
	}
	if($img->alt != '')
	{
		$output .= ' alt="'.$img->alt.'"';
	}
	$output .= '/>';
	
	if($img->url !='')
	{
		$output .= '</a>';
	}
	
	return $output;
}
function count_proj_children($projID)
{
	$query = "SELECT COUNT(*) as 'count' FROM projects WHERE proj_parent = '$projID'";
	$result = dbQuery($query);
	if(dbRows($result)>0)
	{
		$row = dbAssoc($result);
		return $row['count'];
	}
	
}

function serviceNav($class='')
{
	global $proj;
	$build = '';
	$projects = build_project_menu('active_only=true');
	//print_r($projects);
	$proj_count = count($projects);
	if($proj_count > 0)
	{
	    $build .= "<ul";
	    $build .= $class !='' ? ' class="'.$class.'"' : '';
	    $build .= ">\n";
	    $level = 1;
	    $i=1;
		foreach($projects as $project)
		{
			
			$mproj = new project($project['id']);
			if($mproj->id !='')
			{
				$proj_link = SITE_URL."services/".$mproj->slug;
				
				if($i>1)
				{
					if($project['level'] > $level) 
					{
						$build .= "\n<ul class=\"level_".$project['level']."\">\n";
					}
					else
					{
						$build .= "</li>\n";
						if($project['level'] < $level) 
						{
							$build .= "\n</ul>\n";
						}
					}
				}
				$build .= "<li";
				if(isset($proj) && ($proj->id == $mproj->id || $proj->parent == $mproj->id))
				{
					$build .= ' class="active"';
					$arr_class = "contract";
				}
				else
				{
					$arr_class = "expand";
				}
				$build .= "><a href=\"$proj_link\">{$mproj->menuTitle}</a>";
				$build .= count_proj_children($mproj->id) > 0 ? "<a href=\"#\" class=\"arrow $arr_class\">+</a>" : "";
			}
			if($i==$proj_count)
			{
				$build .= "</li>\n";
			}
			else
			{
				$i++;
			}
			$level = $project['level'];
		}

		
		if($level > 1) 
		{
			$build .= "\n</ul>\n";
			$build .= "</li>\n";
			$build .= "\n</ul>\n";
		}
	}
	if($level <= $project['level']) $build .= "</ul>\n";

	return $build;
}
?>