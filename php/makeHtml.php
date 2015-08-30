<?php
include "node.php";

$secteurTranslation = new Node(Node::TYPE_SECTEUR, "translation", "/translation/index");
$secteurTranslation->addSecteurNodes(array(
	new Node("M","main","/translation/index"),
	new Node("M","simultaneus","/translation/simultaneus"),
	new Node("A","simultaneus/article1","/translation/article1"),
	new Node("A","simultaneus/article2","/translation/article2"),
	new Node("M","simultaneus/submenu1","/translation/submenu1"),
	new Node("M","simultaneus/submenu1/submA","/translation/submA"),
	new Node("M","simultaneus/submenu1/submB","/translation/submB"),
	new Node("A","simultaneus/submenu1/subArtiA","/translation/subArtiA"),
	new Node("A","simultaneus/submenu1/subArtiB","/translation/subArtiB"),
	new Node("M","simultaneus/submenu2","/translation/submenu2"),
	new Node("M","consecutive","/translation/consecutive"),
	new Node("M","exposition","/translation/exposition"),
	new Node("M","compagny","/translation/compagny"),
	new Node("M","contact", "/translation/contact")

//	new Node("A","test/article/exemple", "/translation/testArticle"),
//	new Node("M","test/menu/exemple", "/translation/testMenu")
));

$secteurs = array(
	$secteurTranslation
);

$currentMenuNodes = getCurrentMenuNodes();
$currentMenu = getCurrentMenu();
$currentArticle = getCurrentArticle();
$currentNode = getCurrentNode();
$currentNodePosition = $currentMenu->nodePosition;

function searchItemByAtt($arr, $att, $value, $useDefault = false){
	if($arr==null){
		return -1;
	}
	$defaultItemIndex = -1;
	for($i=0; $i<count($arr); $i++){
		$crtItem = $arr[$i];
		if($crtItem->$att == $value){
			return $i;
		}
		if($useDefault && $defaultItemIndex==null && $crtItem->isDefault){
			$defaultItemIndex = $i;
		}
	}

	return $defaultItemIndex;
}

function searchItemObjectByAtt($arr, $att, $value, $useDefault = false){
	$index = searchItemByAtt($arr, $att, $value, $useDefault);
	if($index==-1){
		return null;
	}
	return $arr[$index];
}

// get current menuNode by level (0:secteur  1:topmenu  ... -1:last level)
function getCurrentMenu($level = -1){
	if($GLOBALS["currentMenuNodes"] = null){
		$menus = $GLOBALS["$currentMenuNodes"];
		$deeth = count($menus);
		if($level==-1){
			return $menus[$deeth-1];
		}else if($level < $deeth){
			return $menus[$level];
		}else{
			return null;
		}
	}else{
		$crtMenu = searchItemObjectByAtt($GLOBALS["secteurs"], "isCurrent", true);
		for($i=1; ($crtMenu->menuNodes!=null) && (($i<$level+1) || ($level==-1)); $i++){
			$searchResult = searchItemObjectByAtt($crtMenu->menuNodes, "isCurrent", true);
			if($searchResult==null){
				break;
			}else{
				$crtMenu = $searchResult;
			}
		}
		return $crtMenu;
	}
}

function getCurrentMenuNodes(){
	$menus = array();
	$crtMenu = getCurrentMenu();
	if($crtMenu != null){
		array_unshift($menus, $crtMenu);
		while($crtMenu->fNode != null){
			array_unshift($menus, $crtMenu->fNode);
			$crtMenu = $crtMenu->fNode;
		}
	}
	return $menus;
}

function getCurrentArticle(){
	$crtMenus = getCurrentMenu();
	return searchItemObjectByAtt($crtMenus->articleNodes, "isCurrent", true);
}

function getCurrentNode(){
	$crtMenu = getCurrentMenu();
	if($crtMenu!=null && $crtMenu->pagePath == $GLOBALS["pagePath"]){
		return $crtMenu;
	}else{
		$crtArticle = $GLOBALS["currentArticle"];
		if($crtArticle!=null && $crtArticle->pagePath == $GLOBALS["pagePath"]){
			return $crtArticle;
		}
	}
	return null;
}

class Item{
	var $name;
	var $isCurrent;
	var $href;
	var $type;
	var $subItems;

	function __construct(){}
}

class SubItems{
	var $articles;
	var $menus;

	function __construct($articles, $menus){
		$this->articles = $articles;
		$this->menus = $menus;
	}
}

function getTopMenu(){
	$crtSecteur = getCurrentMenu(0);
	$crtMenuNodes = $crtSecteur->menuNodes;
	$crtMenuItem = getCurrentMenu(1);

	$link = "/".$GLOBALS["lang_client"];
	
	$topMenus = array();
	for($i = 0; $i<count($crtMenuNodes); $i++){
		$item = new Item();
		$item->name = $crtMenuNodes[$i]->rName;
		$item->type = $crtMenuNodes[$i]->type;
		$item->isCurrent = $crtMenuNodes[$i]->isCurrent;
		$item->href = $link.$crtMenuNodes[$i]->pagePath.".html";
		array_push($topMenus, $item);
	}
	
	return $topMenus;
}


function getLeftMenu(){
	return getDeepMenu(getCurrentMenu(1));
}

function getDeepMenu($node){
	$crtMenuNodes = $node->menuNodes;
	$crtArticleNodes = $node->articleNodes;
	$link = "/".$GLOBALS["lang_client"];
	
	$articles = null;
	if($crtArticleNodes != null){
		$articles = array();
		for($i = 0; $i<count($crtArticleNodes); $i++){
			$item = new Item();
			$item->name = $crtArticleNodes[$i]->rName;
			$item->type = $crtArticleNodes[$i]->type;
			$item->isCurrent = $crtArticleNodes[$i]->isCurrent;
			$item->href = $link.$crtArticleNodes[$i]->pagePath.".html";
			array_push($articles, $item);
		}
	}
	
	$menus = null;
	if($crtMenuNodes != null){
		$menus = array();
		for($i = 0; $i<count($crtMenuNodes); $i++){
			$item = new Item();
			$item->name = $crtMenuNodes[$i]->rName;
			$item->type = $crtMenuNodes[$i]->type;
			$item->isCurrent = $crtMenuNodes[$i]->isCurrent;
			$item->href = $link.$crtMenuNodes[$i]->pagePath.".html";
			$item->subItems = getDeepMenu($crtMenuNodes[$i]);
			array_push($menus, $item);
		}
	}

	if($articles == null && $menus == null){
		return null;
	}

	return new SubItems($articles, $menus);
}

function getCrtNodeAttr($attrName){
	$crtNode = $GLOBALS["currentNode"];
	if($crtNode!=null){
		return getResource($crtNode->rName.".$attrName");
	}else{
		return $attrName;
	}
}

function getPageTitle(){
	return getCrtNodeAttr("title");
}

function getPageKeywords(){
	return getCrtNodeAttr("keyswords");
}

function getPageDescription(){
	return getCrtNodeAttr("description");
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