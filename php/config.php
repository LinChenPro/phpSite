<?php
$url_prefix = "/";

// language
//$lang_support = array("cn","cntr","fr","en");
$lang_support = array("cn", "fr");
$lang_support_txt = array("cn"=>"中","cntr"=>"漢","en"=>"EN","fr"=>"FR");
$lang_support_hreflang = array("cn"=>"zh-Hans","cntr"=>"zh-Hant","en"=>"en","fr"=>"fr");
$lang_navi = getNaviLang();
$lang_sys = getSysLang();
$lang_client = getClientLang();

$html_support = array("html", "php");
$source_support = array("js","css","htc");
$media_support = array("jpg","jpeg","png","gif","bmp", "ico");
$doc_support = array("doc","docx","pdf");

$urlOrigine = "/translation/index.html";

$contentPosition = array();
$contentType = "html";
$contentName = "index";
$contentSuffix = "html";
$pagePath = "/translation/index";

function getNaviLang(){
	$lang = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if($lang==null){
		return getDefalutLang();
	}else if(substr($lang, 0, 2)=="fr"){
		return "fr";
	}else if(substr($lang, 0, 2)=="en"){
//		return "en"; // TODO
		return "fr";
	}else if(substr($lang, 0, 2)=="zh"){
		if($lang=="zh-cn" || $lang=="zh-sg"){
			return "cn";
		}else{
//			return "cntr"; // TODO
			return "cn";
		}
	}
}

function getSysLang(){ // TODO
	return getNaviLang();
}

function getDefalutLang(){
	return "fr";
}

function getClientLang(){
	return getNaviLang();
}

?>