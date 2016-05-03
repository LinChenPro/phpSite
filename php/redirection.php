<?php
if(isset($_SERVER["REDIRECT_URL"])){
	$urlOrigine = $_SERVER["REDIRECT_URL"];
}
$prefixPos = strpos($urlOrigine, $url_prefix);
$urlValid = $urlOrigine;
if($prefixPos===0){
	$urlValid = substr($urlValid, $prefixPos+strlen($url_prefix));
}
$url_segms = explode("/", $urlValid);

if(count($url_segms)>0){
	// language
	getLangByUrlSegms($url_segms);

	if(count($url_segms)>0){
		// content path
		$file = array_pop($url_segms);
		$contentPosition = $url_segms;
		
		// type , name
		if(strlen($file)!=0){
			$fileArray = explode(".", $file);
			if(count($fileArray)==1){
				$contentPosition[] = $file;
			}else if(count($fileArray)==2){
				if(in_array($fileArray[1], $html_support)){
					$contentType = "html";
					$contentName = $fileArray[0];
					$contentSuffix = $fileArray[1];
				}else if(in_array($fileArray[1], $source_support)){
					$contentType = "source";
					$contentName = $fileArray[0];
					$contentSuffix = $fileArray[1];
				}else if(in_array($fileArray[1], $media_support)){
					$contentType = "media";
					$contentName = $fileArray[0];
					$contentSuffix = $fileArray[1];
				}else if(in_array($fileArray[1], $doc_support)){
					$contentType = "doc";
					$contentName = $fileArray[0];
					$contentSuffix = $fileArray[1];
				}else{
					$contentType = "html";
					$contentName = "error_notfind";
					$contentSuffix = $fileArray[1];
				}
			}else if(count($fileArray)>2){
					$contentType = "html";
					$contentName = "error_notfind";
					$contentSuffix = $fileArray[1];
			}
		}
	}
}

$pagePath = "/".implode("/", $contentPosition)."/".$contentName;

// by url /fr/translation/abc.html
function oldfonction_getLangByUrlSegms(&$url_segms){
	if(in_array($url_segms[0], $GLOBALS["lang_support"])){
		$GLOBALS["lang_client"] = $url_segms[0];
		array_shift($url_segms);
	}

	return $GLOBALS["lang_client"];
}

// by url /translation/abc_fr.html
function getLangByUrlSegms(&$url_segms){
	$fileNameInUrl = $url_segms[count($url_segms)-1];
	preg_match('/(?<=_)[A-Za-z0-9_]+(?=\.[A-Za-z0-9_]+)/', $fileNameInUrl, $match);
	if(count($match)==1){
		if(in_array($match[0], $GLOBALS["lang_support"])){
			$GLOBALS["lang_client"] = $match[0];
			$url_segms[count($url_segms)-1] = str_replace("_".$GLOBALS["lang_client"].".", ".", $fileNameInUrl);
		}
	}
	return $GLOBALS["lang_client"];
}

// content file
function getContentFilePath(){
	$typeDirPath = "contents/".$GLOBALS["contentType"]."/";
	$fileDirPath = $typeDirPath;
	if(count($GLOBALS["contentPosition"])!=0){
		$fileDirPath .= implode("/",$GLOBALS["contentPosition"])."/";
	}
	
	if($GLOBALS["contentType"]=="html"){
		$fileByLang = getFileByLang($fileDirPath, $GLOBALS["contentName"], "html");
		if($fileByLang == null){
			$fileByLang = getFileByLang($fileDirPath, "error", "html");
			header("location:/");
			exit; 
			if($fileByLang == null){
				$fileByLang = getFileByLang($typeDirPath, "error", "html");
			}
		}
		return $fileByLang;
	}else if($GLOBALS["contentType"]=="doc"){
		return getFileByLang($fileDirPath, $GLOBALS["contentName"], $GLOBALS["contentSuffix"]);
	}else if($GLOBALS["contentType"]=="source"){
		return getFileByLang($fileDirPath, $GLOBALS["contentName"], $GLOBALS["contentSuffix"]);
	}else if($GLOBALS["contentType"]=="media"){
		return getFileByLang($fileDirPath, $GLOBALS["contentName"], $GLOBALS["contentSuffix"]);
	}
}

function getFileByLang($dir, $fileName, $suffix){
	$filePathWithLang = null;
	$dir = "../".$dir;
	if(file_exists($filePathWithLang = $dir.$fileName."_".$GLOBALS["lang_client"].".".$suffix)){
		return $filePathWithLang;
	}else if(file_exists($filePathWithLang = $dir.$fileName."_".$GLOBALS["lang_navi"].".".$suffix)){
		return $filePathWithLang;
	}else if(file_exists($filePathWithLang = $dir.$fileName."_".$GLOBALS["lang_sys"].".".$suffix)){
		return $filePathWithLang;
	}else if(file_exists($filePathWithLang = $dir.$fileName.".".$suffix)){
		return $filePathWithLang;
	}else{
		return null;
	}
}
?>