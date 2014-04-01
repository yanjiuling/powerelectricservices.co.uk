<?php
$page_slug = isset($tr_page->slug) ? $tr_page->slug : (isset($this_slug) ? $this_slug : '');
$page_id = isset($tr_page->id) ? $tr_page->id : '';
$activeID = $page_id;

$seo_refID = isset($seo_refID) ? $seo_refID : $page_id;
$seo_slug = isset($seo_slug) ? $seo_slug : $page_slug;
$seo_keyword = isset($seo_keyword) ? $seo_keyword : '';

if($seo_refID != '')
{
	//SEO
	$seo = new seo($seo_refID,$seo_keyword,SITE_LANG);
}
$pageTitle = isset($seo) && $seo->pageTitle != '' ? $seo->pageTitle : $tr_page->title." - ".SITE_NAME;

//!LANGUAGES
//Calculate equivalent page URLs for other languages
$languages = get_languages();
$langs = array();
foreach($languages as $language)
{
	$langs[] = $language['code'];
}
switch($view)
{
	case "page":
		foreach($langs as $l)
		{
			${$l."_page"} = new page($tr_page->id,'','',$l);
			${$l."_page_path"} = ${$l."_page"}->get_path();
			
			${$l."_path"}='';
			foreach(${$l."_page_path"} as $node)
			{
				${$l."_path"} .= $node['slug']."/";
			}
		}
	break;
	
	case "home":
	default:
		foreach($langs as $l)
		{
			${$l."_path"} = "";
		}
	break;
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- 
  Made by
  ______           _________         _       __     __         _ __           
 /_  __/________ _/ __/ __(_)____   | |     / /__  / /_  _____(_) /____  _____
  / / / ___/ __ `/ /_/ /_/ / ___/   | | /| / / _ \/ __ \/ ___/ / __/ _ \/ ___/
 / / / /  / /_/ / __/ __/ / /__     | |/ |/ /  __/ /_/ (__  ) / /_/  __(__  ) 
/_/ /_/   \__,_/_/ /_/ /_/\___/     |__/|__/\___/_.___/____/_/\__/\___/____/  

                                                  www.trafficwebsites.co.uk
 -->
<head>
<meta charset="utf-8" />

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

<title><?php echo $pageTitle; ?></title>
<?php
echo isset($seo->metaDesc) && $seo->metaDesc != '' ? "<meta name=\"description\" content=\"".htmlentities($seo->metaDesc)."\" />\n" : '';
echo isset($seo->metaRobots) && $seo->metaRobots != '' ? "<meta name=\"robots\" content=\"".htmlentities($seo->metaRobots)."\" />\n" : '';
echo isset($seo->metaKeywords) && $seo->metaKeywords != '' ? "<meta name=\"keywords\" content=\"".htmlentities($seo->metaKeywords)."\" />\n" : '';
echo isset($seo->canonLink) && $seo->canonLink != '' ? "<link rel=\"canonical\" href=\"".$seo->canonLink."\" />\n" : '';

foreach($languages as $l)
{
	$lc = $l['code'];
	$ldom = $l['domain'];
	if($lc != SITE_LANG && $lc !='us')
	{
		echo "<link rel=\"alternate\" hreflang=\"$lc\" href=\"".$ldom.${$lc."_path"}."\" />\n";
	}
}
?>
<link rel="stylesheet" type="text/css" media="all" href="<?=MASTER_URL?>css/styles.css"/>
<link rel="stylesheet" media="screen" href="<?php echo MASTER_URL; ?>css/responsive.css"/>
