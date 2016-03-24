<?php
require_once('../libs/MailSender.php');

$ref = basename($_SERVER["REQUEST_URI"]);
$folder = "../userUploads/$ref";

if(file_exists($folder)){
	$sub = scandir($folder);
	if($sub != false){
		$files = array();
		foreach ($sub as $file) {
			if(!is_dir("$folder/$file")){
				$files[] = "$folder/$file";
			}
		}

		if(!empty($files)){
			$sender = new MailSender();
			$sender->setSenderName("IRISO Site Web");
			$sender->setSender("contact@iriso-service.com");
			$sender->setReseiver("contact@iriso-service.com");
			$sender->setTitle("DEVIS DOCS");
			$sender->setTextContent("devis docs - ref:$ref");
			$sender->setHtmlContent("<html><body>devis docs - ref:$ref </body></html>");
			$sender->setAttachementPaths($files);
			$sender->sendMail();

			echo "can not get docs : targets removed.";
			exit();
		}
	}
}

echo "can not get docs : targets already removed.";

?>

