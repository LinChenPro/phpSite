<?php
	class MailSender {
		var $senderName;
		var $sender;
		var $reseiver;
		var $title;
		var $textContent;
		var $htmlContent;
		var $attachementPaths;

		function setSenderName($senderName){
			$this->senderName = $senderName;
		}

		function setSender($sender){
			$this->sender = $sender;
		}

		function setReseiver($reseiver){
			$this->reseiver = $reseiver;
		}

		function setTitle($title){
			$this->title = $title;
		}

		function setTextContent($textContent){
			$this->textContent = $textContent;
		}

		function setHtmlContent($htmlContent){
			$this->htmlContent = $htmlContent;
		}

		function setAttachementPaths($attachementPaths){
			$this->attachementPaths = $attachementPaths;
		}

		function sendMail(){
			$message_txt = $this->textContent;
			$message_html = $this->htmlContent;
			$subject = "=?UTF-8?B?".base64_encode($this->title)."?=";
			$senderName = "=?UTF-8?B?".base64_encode($this->senderName)."?=";
			
			// $passage_line selon adresse
			$isMsAddress = preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $this->reseiver);
			$passage_ligne = !$isMsAddress ? "\r\n" : "\n";
			$boundary = "-----=".md5(rand());
			$boundary_alt = "-----=".md5(rand());

			 
			//=====Création du header de l'e-mail.
			$header = "From: \"$senderName\"<".$this->sender.">".$passage_ligne;
			$header.= "MIME-Version: 1.0".$passage_ligne;
			$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
			//==========
			 
			//=====Création du message.
			$message = $passage_ligne."--".$boundary.$passage_ligne;
			$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
			$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
			//=====Ajout du message au format texte.
			$message.= "Content-Type: text/plain; charset=\"uft-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_txt.$passage_ligne;
			//==========
	 
			$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
			 
			//=====Ajout du message au format HTML.
			$message.= "Content-Type: text/html; charset=\"uft-8\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_html.$passage_ligne;
			//==========
			 
			//=====On ferme la boundary alternative.
			$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
			//==========
	  
			//=====Ajout de la pièce jointe.
			if($this->attachementPaths != null){
				foreach($this->attachementPaths as $filePath){
					$message.= $passage_ligne."--".$boundary.$passage_ligne;

					$fichier   = fopen($filePath, "r");
					$attachement = fread($fichier, filesize($filePath));
					$attachement = chunk_split(base64_encode($attachement));
					fclose($fichier);

					$message.= "Content-Type: ".mime_content_type($filePath)."; name=\"".basename($filePath)."\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
					$message.= "Content-Disposition: attachment; filename=\"".basename($filePath)."\"".$passage_ligne;
					$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
				}
			}

			$message.= $passage_ligne."--".$boundary."--".$passage_ligne; 


			//echo $message;





			//=====Envoi de l'e-mail.
			mail($this->reseiver, $subject, $message, $header);
			//==========

		}

		function printObj(){
			echo $this->sender."<br>";
			echo $this->reseiver."<br>";
			echo $this->title."<br>";
			echo $this->textContent."<br>";
			echo $this->htmlContent."<br>";
			echo $this->attachementPaths."<br>";
		}
	}
?>