<?php
//content stucture corresponds au $contentPosition
// secteurs
$contents = array(
	"defaultSecteurIndex"=>0,
	"secteurs"=>array(
		//secteur translation
		array(
			"name"=>"translation",
			"defaultMenuIndex"=>-1,
			"defaultArticleIndex"=>0,			
			"menuPosition"=>"top",
			// secteur translation, menu level 1
			"menus"=>array(
				
				// top menu 1
				array(
					"name"=>"main",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"index",
							"showLink"=>false			
						)
					)					
				),
				array(
					"name"=>"simultaneus",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"simultaneus",
							"showLink"=>false			
						)
					)					
				),
				array(
					"name"=>"consecutive",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"consecutive",
							"showLink"=>false			
						)
					)					
				),
				array(
					"name"=>"exposition",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"exposition",
							"showLink"=>false			
						)
					)					
				),
				array(
					"name"=>"compagny",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"compagny",
							"showLink"=>false			
						)
					)					
				),
				array(
					"name"=>"contact",
					"level"=>1,
					"showLink"=>true,
					"defaultMenuIndex"=>-1,
					"defaultArticleIndex"=>0,			
					"menuPosition"=>"left",

					// secteur translation, menu 1, articles
					"articles"=>array(
						array(				
							"name"=>"contact",
							"showLink"=>false			
						)
					)					
				)
			),
			// secteur translation, articles
			"articles"=>null
		)
		
		//secteur exposition:a venir
	)
);

function searchItemByAtt($arr, $att, $value){
	if($arr==null){
		return null;
	}
	
	for($i=0; $i<count($arr); $i++){
		if($arr[$i][$att] == $value){
			return $i;
		}
	}
	
	return null;
}

function searchItemObjectByAtt($arr, $att, $value){
	if($arr==null){
		return null;
	}
	
	for($i=0; $i<count($arr); $i++){
		if($arr[$i][$att] == $value){
			return $arr[$i];
		}
	}
	
	return null;
}

function getCurrentTopMenu(){
	$position_array = $GLOBALS["contentPosition"];
	$crtMenu = searchItemByAtt($GLOBALS["contents"]["secteurs"], "name", $position_array[0]);
	
	for($i=1; $i<count($position_array); $i++){
		if($crtMenu["menus"] != null){
			$index = searchItemByAtt($crtMenu["menus"], "name", $position_array[$i]);
			if($index == null){
				$index = $crtMenu["menus"]["defaultMenuIndex"];
			}
			$crtMenuIndex = $index;
			$crtMenu = $crtMenu["menus"][$index];
		}
	}
}

function getCurrentArticle(){
	$position_array = $GLOBALS["contentPosition"];
	$crtMenus = searchItemObjectByAtt($GLOBALS["contents"]["secteurs"], "name", $position_array[0]);
	for($i=1; $i<count($position_array); $i++){
		$name = $position_array[$i];
		$crtMenus = searchItemObjectByAtt($crtMenus["menus"], "name", $name);
		if($crtMenus==null){
			return null;
		}
	}

	return searchItemObjectByAtt($crtMenus["articles"], "name", $GLOBALS["contentName"]);
}

class Item
{
	var $color;
	var $name;
	var $isCurrent;
	var $title;
	var $href;
	function Item(){}
}

function getTopMenu(){
	$position_array = $GLOBALS["contentPosition"];
	$crtMenuIndex = $GLOBALS["contents"]["defaultSecteurIndex"];
	$crtMenu = $GLOBALS["contents"]["secteurs"][$crtMenuIndex];
	$crtPageItem = $crtMenu["defaultMenuIndex"];

	if(count($position_array)>1){
		$index = searchItemByAtt($crtMenu["menus"], "name", $position_array[1]);
			
		if($index >-1){
			$crtPageItem = $index;
		}
	}
	 
	$link = "/".implode("/",array($GLOBALS["lang_client"], $crtMenu["name"]))."/";
	
	$topMenus = array();
	for($i = 0; $i<count($crtMenu["menus"]); $i++){
		$item = new Item();
		$item->name = $crtMenu["menus"][$i]["name"];
		$item->isCurrent = $i==$crtPageItem;
		$item->title = $item->name;
		$item->href = $link.$crtMenu["menus"][$i]["name"]."/".$crtMenu["menus"][$i]["articles"][$crtMenu["menus"][$i]["defaultArticleIndex"]]["name"].".html";
		array_push($topMenus, $item);
	}
	
	return $topMenus;
}

function getLeftArticleMenu(){
	$position_array = $GLOBALS["contentPosition"];
	$crtMenuIndex = $GLOBALS["contents"]["defaultSecteurIndex"];
	$crtMenu = $GLOBALS["contents"]["secteurs"][$crtMenuIndex];
	$crtPageItem = $crtMenu["defaultMenuIndex"];

	if(count($position_array)>1){
		$index = searchItemByAtt($crtMenu["menus"], "name", $position_array[1]);
		if($index >-1){
			$crtPageItem = $index;
		}
	}
		
	$link = "/".implode("/",array($GLOBALS["lang_client"], $crtMenu["name"]))."/";
	
	$leftArticleMenus = array();

	if($crtPageItem!=-1 && count($crtMenu["menus"][$crtPageItem]["articles"]>1)){
		foreach($crtMenu["menus"][$crtPageItem]["articles"] as $article){
			if($article["showLink"]){
				$item = new Item();
				$item->name = $article["name"];
				$item->isCurrent = $item->name == $GLOBALS["contentName"];
				$item->title = $item->name;
				$item->href = $link.$crtMenu["menus"][$crtPageItem]["name"]."/".$article["name"].".html";
				array_push($leftArticleMenus, $item);
			}
		}
	}
	return $leftArticleMenus;	
}

function getPageTitle(){
	$crtArticle = getCurrentArticle();
	return getResource($crtArticle["name"].".title");
}

function getPageKeywords(){
	$crtArticle = getCurrentArticle();
	return getResource($crtArticle["name"].".keyswords");
}

function getPageDescription(){
	$crtArticle = getCurrentArticle();
	return getResource($crtArticle["name"].".description");
}

function getCssFile(){
	return "/css/mainstyle.css";
}
?>

<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=$lang_client?>">
<head>
<title><?=getPageTitle()?></title>

<meta name="Keywords" content="<?=getPageKeywords()?>">
<?php
if(getPageDescription()!=null){
?>
<meta name="description" content="<?=getPageDescription()?>"/>
<?php
}
?>
<?php
if(isMobile()){
?>
<!--meta name="viewport" content="width=device-width, initial-scale=1" /-->
<?php
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="<?=$lang_client?>"/>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
<link href="<?=getCssFile()?>" rel="stylesheet" type="text/css" />
</head>
	<body>
	<?php
	include 'topMenu.php';
	?>
	<div id="middle_area">
		<?php
		include 'leftMenu.php';
		?>
		<div id="main_content_out">
			<?php
			include $contentFilePath;
			?>
		</div>
		<div class="FCL"></div>
	</div>
	<?php
	include 'foot.php';
	?>
	</body>
</html>