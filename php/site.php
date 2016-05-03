<?php
// redirect for /*/translation/xxx.html
$isOldUrl = preg_match("@(?P<lang>(/cn|/fr))*/translation/(?P<file>[1-9a-zA-Z_]+)\.html@i", $_SERVER["REQUEST_URI"], $matches);
if($isOldUrl){
	$urlOldToNew = array(
		'index' => 'index',
		'ourcompany' => 'agence-traduction-france',
		'ourteam' => 'traducteurs-interpretes-professionnels',
		'written' => 'traduction-chinois-anglais-francais',
		'simultaneous' => 'interpretation-simultanee',
		'consecutive' => 'interpretation-consecutive',
		'accompany' => 'interpretation-accompagnement',
		'exposition' => 'interpretation-exposition',
		'message' => 'traduction-devis-gratuit',
		'joinus' => 'espace-traducteurs-interpretes',
		'contact' => 'contact',
		'feedback' => 'feedback'
	);

	$newFile = $urlOldToNew[$matches["file"]];
	if(strlen($newFile)==0){
		$newFile = "index";
	}
	$newUrl = "/agence-traduction-interpretation-chinois/".$newFile.str_replace("/", "_", $matches["lang"]).".html";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://".$_SERVER["HTTP_HOST"].$newUrl);
	exit();
}


include 'device.php'; //mobile ou pc
include 'config.php'; // definition des params du site et de page, default values
include 'resource.php';
include 'redirection.php'; //analyser request
include 'page.php'; //menus, submenus, headers, footers, realisation du page
?>