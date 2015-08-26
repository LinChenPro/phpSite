<?php
$resource = array(
	"cn"=>array(
"company_name" => "睿思国际",
"secteur_translate" => "翻译和口译服务",
"company_name_lang2" => "<span>IRISO</span> <span>Service International</span>",
"secteur_translate_lang2" => "Interprète et Tranduction",

"main" => "首页",
"index.title" => "睿思国际",
"index.keyswords" => "睿思国际,睿思,IRISO,专业,法国,巴黎,中法,法中,翻译,口译,同传,交传,笔译,展会,同声传译,交替传译",
"index.description" => "睿思翻译是睿思国际服务有限公司下属的一个专业翻译团队。公司设于巴黎。我公司承接各类在法国及欧洲进行的中法同声传译，交替传译，中法商务会议翻译，法语展会翻译，法语陪同翻译等业务，以及来自世界各地的中英法文件的笔译业务。",

"simultaneus" => "中法同传",
"simultaneus.title" => "睿思国际-中法同声传译",
"simultaneus.keyswords" => "睿思国际,睿思,IRISO,专业,法国,巴黎,中法,法中,翻译,口译,同传,同声传译",
"simultaneus.description" => "我公司为您提供高质量的中法、法中同声传译服务。我们的同传人员都具有在国家或世界顶级学府深造或任教的经历，并从事职业翻译工作多年，有的曾是外交部或中联部的翻译官，有扎实的语言功底和丰富的同传经验。",

"consecutive" => "中法交传",
"consecutive.title" => "睿思国际-中法交替传译",
"consecutive.keyswords" => "睿思国际,睿思,IRISO,专业,法国,巴黎,中法,法中,翻译,口译,交传,交替传译",
"consecutive.description" => "交替传译是我公司承接的主要业务之一。我公司有一批专业过硬，责任心强的交传翻译员，具有丰富的从业经验。",

"exposition" => "展会翻译",
"exposition.title" => "睿思国际-展会翻译",
"exposition.keyswords" => "睿思国际,睿思,IRISO,专业,法国,巴黎,中法,法中,翻译,口译,展会",
"exposition.description" => "展会翻译的质量对于企业的进一步开拓国际市场关系重大。我公司以合理的价格，提供优质的展会翻译服务。",

"compagny" => "陪同翻译",
"compagny.title" => "睿思国际-陪同翻译",
"compagny.keyswords" => "睿思国际,睿思,IRISO,专业,法国,巴黎,中法,法中,翻译,口译,陪同,谈判",
"compagny.description" => "陪同翻译的内容和形式比较灵活多变，我公司会根据每位客户的具体出行目的和计划，为您提供最合理的翻译服务方案，最大限度地保障您在国外期间的交流顺畅",

"contact" => "联系我们",
"contact.title" => "睿思国际-联系我们",
"contact.keyswords" => "睿思国际,睿思,IRISO,联系方式",
"contact.description" => "睿思国际联系方式"
	),
	"fr"=>array(
"pageTitle" => "Iriso Service International"
	),
);

function getResource($key){
	if(array_key_exists($key, $GLOBALS["resource"][$GLOBALS["lang_client"]])){
		return $GLOBALS["resource"][$GLOBALS["lang_client"]][$key];
	}else if(array_key_exists($key, $GLOBALS["resource"][$GLOBALS["lang_navi"]])){
		return $GLOBALS["resource"][$GLOBALS["lang_navi"]][$key];
	}else if(array_key_exists($key, $GLOBALS["resource"][$GLOBALS["lang_sys"]])){
		return $GLOBALS["resource"][$GLOBALS["lang_sys"]][$key];
	}else{
		return $key;
	}
}

function srs($key){
	return getResource($key);
}
?>
