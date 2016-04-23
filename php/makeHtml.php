<?php
include "node.php";

$secteurTranslation = new Node(Node::TYPE_SECTEUR, "translation", "/translation/index");
$allNodes = array(
	new Node("M","main","/translation/index"),
	(new Node("M","aboutus", "/translation/ourcompany"))->setShowInSitemap(false), // directly to ourcompany
	new Node("A","aboutus/ourcompany","/translation/ourcompany"),
	new Node("A","aboutus/ourteam","/translation/ourteam"),
	(new Node("M","ourservices", "/translation/written"))->setShowInSitemap(false), // directly to simultaneous TODO: page ourservices
	new Node("A","ourservices/written","/translation/written"),
	new Node("A","ourservices/simultaneous","/translation/simultaneous"),
	new Node("A","ourservices/consecutive","/translation/consecutive"),
	(new Node("A","ourservices/accompany","/translation/accompany"))->setSupportLangs(array("cn")),
	(new Node("A","ourservices/exposition","/translation/exposition"))->setSupportLangs(array("cn")),
	new Node("M","message", "/translation/message"),
	(new Node("M","joinus", "/translation/joinus"))->setSupportLangs(array("cn")),
	new Node("M","contact", "/translation/contact"),
	(new Node("M","feedback", "/translation/feedback", false, false))->setSupportLangs(array("cn"))->setShowInSitemap(false)
);

$secteurTranslation->addSecteurNodes($allNodes);
$secteurs = array(
	$secteurTranslation
);

$currentMenuNodes = getCurrentMenuNodes();
$currentMenu = getCurrentMenu();
$currentArticle = getCurrentArticle();
$currentNode = getCurrentNode();
$currentNodePosition = $currentMenu->nodePosition;

function getLangLink($langSelected){
	$link = getLangLinkWhenExit($langSelected);
	if($link!=null){
		return $link;
	}else{
		return "/".$langSelected."/translation/index.html";
	}
}

function getLangLinkWhenExit($langSelected){
	if($GLOBALS["currentNode"]->isSupportLang($langSelected)){
		return "/".$langSelected.$GLOBALS["currentNode"]->pagePath.".html";
	}else{
		return null;
	}
}

function getLangLinks(){
	$lang_client = $GLOBALS["lang_client"];
	$linksCode = "";
	foreach($GLOBALS["lang_support"] as $lang_i){
		if(true || $lang_client != $lang_i){ // TODO : do not show actuel lang link
			$linksCode .= '<a class="langicon lg'.$lang_i.'" href="'.getLangLink($lang_i).'">'.$GLOBALS["lang_support_txt"][$lang_i].'</a>';
		}
	}
	return $linksCode;
}

function getHrefLangLinkTags(){
	$lang_client = $GLOBALS["lang_client"];
	$tagsCode = "";
	foreach($GLOBALS["lang_support"] as $lang_i){
		$href = getLangLinkWhenExit($lang_i);
		if($href != null){ // TODO : do not show actuel lang link
			$tagsCode .= '<link rel="alternate" href="http://'.$_SERVER['HTTP_HOST'].$href.'" hreflang="'.$GLOBALS["lang_support_hreflang"][$lang_i].'" />'."\r\n";
		}
	}
	if($GLOBALS["currentNode"]->nodePosition=="translation/main"){
			$tagsCode .= '<link rel="alternate" href="http://'.$_SERVER['HTTP_HOST'].'/" hreflang="x-default" />'."\r\n";
	}

	return $tagsCode;
}

function getServiceTel(){
	$lang_client = $GLOBALS["lang_client"];

	if($lang_client=="cn" || $lang_client=="cnt"){
		$TelCode = '<span class="tel400">国内客服热线<span class="tel400_number">4000 - 460 - 480</span></span>';
		return $TelCode;
	}else{
		return "";
	}
}

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
		if(!$crtMenuNodes[$i]->isSupportLang($GLOBALS["lang_client"])){
			continue;
		}

		$item = new Item();
		$item->name = $crtMenuNodes[$i]->rName;
		$item->type = $crtMenuNodes[$i]->type;
		$item->isCurrent = $crtMenuNodes[$i]->isCurrent;
		$item->href = $link.$crtMenuNodes[$i]->pagePath.".html";
		$item->showInMenu = $crtMenuNodes[$i]->showInMenu;

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
			if(!$crtArticleNodes[$i]->isSupportLang($GLOBALS["lang_client"])){
				continue;
			}

			$item = new Item();
			$item->name = $crtArticleNodes[$i]->rName;
			$item->type = $crtArticleNodes[$i]->type;
			$item->isCurrent = $crtArticleNodes[$i]->isCurrent;
			$item->showInMenu = $crtArticleNodes[$i]->showInMenu;
			$item->href = $link.$crtArticleNodes[$i]->pagePath.".html";
			array_push($articles, $item);
		}
	}
	
	$menus = null;
	if($crtMenuNodes != null){
		$menus = array();
		for($i = 0; $i<count($crtMenuNodes); $i++){
			if(!$crtMenuNodes[$i]->isSupportLang($GLOBALS["lang_client"])){
				continue;
			}

			$item = new Item();
			$item->name = $crtMenuNodes[$i]->rName;
			$item->type = $crtMenuNodes[$i]->type;
			$item->isCurrent = $crtMenuNodes[$i]->isCurrent;
			$item->showInMenu = $crtMenuNodes[$i]->showInMenu;
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

function getCommonCssFile(){
	return "/css/mainstyle.css";
}

function getLangueCssFile(){
	return "/".$GLOBALS["lang_client"]."/css/languestyle.css";
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?=$lang_support_htmllang[$lang_client]?>">
<head>
<title><?=getPageTitle()?></title>

<?=getHrefLangLinkTags()?>

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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<script src="/js/jquery.js"></script>

<script src="/js/jquery-ui.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
<link rel="stylesheet" href="/css/jquery-ui.css">
<!--link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"-->
<link href="<?=getCommonCssFile()?>" rel="stylesheet" type="text/css" />
<link href="<?=getLangueCssFile()?>" rel="stylesheet" type="text/css" />

</head>
	<body>
	<?php include_once("stats.php") ?>
	<div id="slide_menu">
		<div class="slide_top">
			<img class="small_logo" alt="iriso" src="/small_logo.jpg"/>
			<a href="#" id="slideclose">
				<img alt="slide close" src="/slideCloseIcon.png"/>
			</a>
		</div>

		<?php include 'slideMenu.php'; ?>


	</div>
	<div id="page_cover"></div>
	<div id="content_container">
		<?php include 'topMenu.php'; ?>

		<div class="total_container" id="container_center">
			<div id="center">
			<?php include 'leftMenu.php'; ?>
			<?php include $contentFilePath; ?>
			</div>
		</div>
		<?php include 'foot.php'; ?>

		<script>
			$(function(){
				$("#slideopen").click(trogleSlideMenu);
				$("#page_cover").click(trogleSlideMenu)
				$("#page_cover").on("touchstart",trogleSlideMenu);
				$("#slideclose").click(trogleSlideMenu);

				$(window).scroll(bodyScroll);
				$(window).on("orientationchange",windowResize);
				$(window).resize(windowResize);

				//traider window resize et orientation event
				function windowResize(){
					if($(window).width()<700){
						bodyScroll();		
					}else{
						$("#topFunctionArea .small_logo").css("opacity","0");
						hiddeSlideMenu();
					}
				}

				// traiter scroll event
				function bodyScroll(){
					if($(window).width()<700){
						var scrollTop = $("body").scrollTop();
						var logoHeight = $("#logoarea").outerHeight();
						var $smallLogo = $("#topFunctionArea .small_logo");
						if(scrollTop<=logoHeight && $smallLogo.css("opacity")==1){
							$smallLogo.css("opacity", "0");
						}else if(scrollTop>logoHeight && $smallLogo.css("opacity")==0){
							$smallLogo.css("opacity", 1);
						}
					}
				}

				var $cover = $("#page_cover");
				var $slideMenu = $("#slide_menu");
				// affiche et cache slide menu
				function trogleSlideMenu(evt){
					evt.preventDefault();
					if($cover.css("display")=="none"){
						$slideMenu.css("visibility", "visible");
						$cover.css("display", "block");
						$slideMenu.css("left","0px");

						setTimeout(function(){
	//						$("html").css("overflow", "hidden");
						},500);


					}else{
						hiddeSlideMenu();
					}

				}

				function hiddeSlideMenu(){
					if($cover.css("display")=="none"){
						return;
					}

					$slideMenu.css("left","-250px");
//					$slideMenu.css("display", "none");

					$cover.css("display", "none");
					setTimeout(function(){
						//$("body").css("overflow", "auto");
						$slideMenu.css("visibility", "hidden");
//						$("html").css("overflow", "auto");
					},500);
				}

		});
		</script>
		</div>
	</body>
</html>