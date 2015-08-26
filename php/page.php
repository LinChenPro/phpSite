<?php
$contentFilePath = getContentFilePath();
if($contentSuffix=="html"){
	include "makeHtml.php";
//	include makeAjax.php;
//	include makeError.php;
}else if($GLOBALS["contentType"]=="doc"){
	if($contentFilePath != null){
		Header ( "Content-type: application/octet-stream" );  
		Header ( "Accept-Ranges: bytes" );  
		Header ( "Accept-Length:".filesize ($fileCompletPath) );  
		Header ( "Content-Disposition:attachment;filename=".$contentName.".".$contentSuffix);  
		include $contentFilePath;
		exit();
	}
}else{
	if($contentFilePath != null){
		Header ( "Content-type: text/css" );  
		Header ( "Accept-Ranges: bytes" );
		include $contentFilePath;
	}
	exit();
}
?>