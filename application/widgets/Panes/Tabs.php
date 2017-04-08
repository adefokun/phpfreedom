<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: tomiwa.adefokun@gmail.com
*/
class Panes_Tabs extends Widget{
    public $widget;
	public $containerName;
	public $tabs;
	public $panes;
	public $defaultTab;
	public $tabNum = 0;
	function setContainerName($name){
		$this->containerName = $name;
	}
	public function build(){

		$tabs = <<< EOF
		<div class="Panes_Tabs_panes" id="Panes_Tabs_{$this->containerName}">
			<div class="Panes_Tabs_tabContainer">
				{$this->tabs}
			</div>
				{$this->panes}
		</div>
EOF;
	    
		$this->widget = $tabs;
	}
	function addTab($label,$url = false,$refresh = false){
		$current = ($this->isCurrentTab()) ? 'Panes_Tabs_currentTab' : '';
		
		$tab = <<< EOF
		<a class="Panes_Tabs_tab {$current}" href="javascript:void(0);" onclick="javascript:Panes_Tabs.showPane('{$this->containerName}','{$this->tabNum}','{$url}','{$refresh}')" id="Panes_Tabs_tab_{$this->containerName}_{$this->tabNum}">{$label}</a>
EOF;
	if(isset($this->tabs)) $this->tabs .= $tab;
	else $this->tabs = $tab;
	}	
	
	function addPane($content){
	  
	    $current = ($this->isCurrentTab()) ? 'Panes_Tabs_currentPane' : '';
		$pane = <<< EOF
			<div class="content Panes_Tabs_paneContent {$current}" id="Panes_Tabs_pane_{$this->containerName}_{$this->tabNum}">{$content}</div>
EOF;
	if(isset($this->panes)) $this->panes .= $pane;
	else $this->panes = $pane;
	}
	function add($label,$content,$fromUrl = false,$refresh = false){
		$this->tabNum += 1;
		if($fromUrl == false) {
		    $this->addTab($label);
			$this->addPane($content);
		}
		else {
			$this->addTab($label,$content,$refresh);
			$this->addPane('');
		}
		
	}
	
	function isCurrentTab(){
		if(isset($this->defaultTab)){
			if($this->defaultTab == $this->tabNum) return true;
		}
		else if($this->tabNum == 1) return true;
	}
	
}

?>