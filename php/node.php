<?php
class Node{
	const TYPE_SECTEUR = "S";
	const TYPE_MENU = "M";
	const TYPE_ARTICLE = "A";

	public $fNode = null;
	public $type; // secteur, menu, article  
	public $name;
	public $nodePosition;
	public $rName;
	public $pagePath;
	public $isDefault = false;
	public $isCurrent = false;
	public $showInMenu = true;
	public $menuNodes;
	public $articleNodes;
	public $supportLangs;

	function __construct($type, $nodePosition, $pagePath=null, $isDefault=false, $showInMenu = true, $isCurrent=false){
		
		$this->type = $type;
		$positionArr = explode("/",$nodePosition);
		$this->name = array_pop($positionArr);
		$this->nodePosition = $nodePosition;
		$this->pagePath = $pagePath;
		$this->isDefault = $isDefault;
		$this->isCurrent = $isCurrent;
		$this->showInMenu = $showInMenu;
		$this->supportLangs = $GLOBALS["lang_support"];
		$this->updateRName();
	}

	function setSupportLangs($langs){
		$this->supportLangs = $langs;
		return $this;
	}

	function setNoSupportLangs($langs){
		$newLangs = array();
		foreach($this->supportLangs as $lang){
			if(!in_array($lang, $langs)){
				$newLangs[] = $lang;
			}
		}
		$this->supportLangs = $newLangs;

		return $this;
	}	

	function isSupportLang($lang){
		return in_array($lang, $this->supportLangs);
	}

	function toString(){
		return $this->type.", ".$this->name.", ".$this->nodePosition.", ".$this->pagePath;
	}

	function setCurrent($crt){
		$this->isCurrent = $crt;
		if($crt && $this->fNode!=null && $crt){
			$this->fNode->setCurrent($crt);
		}
	}

	function addNode($node){
		if($node->type==Node::TYPE_MENU){
			if($this->menuNodes == null){
				$this->menuNodes = array();
			}
			array_push($this->menuNodes, $node);
		}else if($node->type==Node::TYPE_ARTICLE){
			if($this->articleNodes == null){
				$this->articleNodes = array();
			}
			array_push($this->articleNodes, $node);
		}

		$node->fNode = $this;
		return $node;
	}
	
	function getOrCreateSubmenu($name){
		if($this->menuNodes != null){
			foreach($this->menuNodes as $menuItem){
				if($menuItem->name==$name){
					return $menuItem;
				}
			}
		}
		
		return $this->addNode(new Node("M", $this->nodePosition."/".$name));
	}
	
	function addSecteurNodes($nodes){
		for($i=0; $i<count($nodes); $i++){
			$node = $nodes[$i];
			$positionArr = explode("/",$node->nodePosition);
			$crtParent = $this;
			$node->nodePosition = $this->nodePosition."/".$node->nodePosition;
			$node->updateRName();

			$level = count($positionArr);
			for($j=0; $j<$level; $j++){
				if($j+1==$level){
					$crtParent->addNode($node);
				}else{
					$crtParent = $crtParent->getOrCreateSubmenu($positionArr[$j]);
				}
			}

			if($node->pagePath==$GLOBALS["pagePath"]){
				$node->setCurrent(true);
			}
		}
	}

	function updateRName(){
		$this->rName = str_replace("/", "_", $this->nodePosition);
	}
}
?>