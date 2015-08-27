<?php
class Node{
	const TYPE_SECTEUR = "S";
	const TYPE_MENU = "M";
	const TYPE_ARTICLE = "A";

	public $type; // secteur, menu, article  
	public $name;
	public $nodePosition;
	public $pagePath;
	public $isDefault = false;
	public $isCurrent = false;
	public $showInMenu = true;
	public $menuNodes;
	public $articleNodes;
	
	function __construct($type, $nodePosition, $pagePath=null, $isDefault=false, $showInMenu = true, $isCurrent=false){
		
		$this->type = $type;
		$positionArr = explode("/",$nodePosition);
		$this->name = array_pop($positionArr);
		$this->nodePosition = $nodePosition;
		$this->pagePath = $pagePath;
		$this->isDefault = $isDefault;
		$this->isCurrent = $isCurrent;
		$this->showInMenu = $showInMenu;
	}
	
	function toString(){
		return $this->type.", ".$this->name.", ".$this->nodePosition.", ".$this->pagePath;
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
			
			$level = count($positionArr);
			for($j=0; $j<$level; $j++){
				if($j+1==$level){
					$crtParent->addNode($node);
				}else{
					$crtParent = $crtParent->getOrCreateSubmenu($positionArr[$j]);
				}
			}
		}
	}
}
?>