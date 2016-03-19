<?php
$menuItems = getDeepMenu(getCurrentMenu(0));

				showSlideMenu($menuItems);


function showSlideMenu($subMenu, $level=1){
	if($subMenu->articles != null){
?>
		<ul class="slide_ul" data-level="<?=$level?>">
<?php
		foreach($subMenu->articles as $itemArticle){
			if(!$itemArticle->showInMenu){
				continue;
			}

			$icon = def($itemArticle->name.'.icon', "/icon_team_small.png");
			if($itemArticle->isCurrent){
?>
			<li class="slide_li active" data-level="<?=$level?>">
				<span 
					class="slide_item active" 
					data-level="<?=$level?>"
					style="background-image:url('<?=$icon?>')"
				><?=srs($itemArticle->name)?></span>
			</li>
<?php
			}else{
?>
			<li class="slide_li" data-level="<?=$level?>">
				<a 
					class="slide_item" 
					data-level="<?=$level?>" 
					href="<?=$itemArticle->href?>"
					style="background-image:url('<?=$icon?>')"
				><?=srs($itemArticle->name)?><span class="icon_arrow"></span></a>
			</li>
<?php
			}
?>
<?php
		}
?>
		</ul>	
<?php	
	}

	if($subMenu->menus != null){
?>
		<ul class="slide_ul" data-level="<?=$level?>">
<?php
		foreach($subMenu->menus as $itemMenu){
			if(!$itemMenu->showInMenu){
				continue;
			}

			$icon = def($itemMenu->name.'.icon', "/icon_team_small.png");
			if($itemMenu->isCurrent){
?>
			<li class="slide_li active" data-level="<?=$level?>">
				<span 
					class="slide_item active" 
					data-level="<?=$level?>"
					style="background-image:url('<?=$icon?>')"
				><?=srs($itemMenu->name)?></span>
<?php
			}else if($itemMenu->subItems!=null){
?>
			<li class="slide_li" data-level="<?=$level?>">
				<span 
					class="slide_item" 
					data-level="<?=$level?>"
					style="background-image:url('<?=$icon?>')"
				><?=srs($itemMenu->name)?></span>
<?php
			}else{
?>
			<li class="slide_li" data-level="<?=$level?>">
				<a 
					class="slide_item" 
					data-level="<?=$level?>" 
					href="<?=$itemMenu->href?>"
					style="background-image:url('<?=$icon?>')"
				><?=srs($itemMenu->name)?><span class="icon_arrow"></span></a>
<?php
			}

			if($itemMenu->subItems!=null){
				showSlideMenu($itemMenu->subItems, $level+1);
			}
?>

			</li>
<?php
		}
?>
		</ul>	
<?php	
	}
}
?>
