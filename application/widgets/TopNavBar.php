<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
class TopNavBar extends Widget{
    public $widget;
	public $links;
	
	public function build()
	{
		$this->widget = "<div class=\"TopNavBar imgbg\">
	<span class='siteSearch'>
		<input type=\"text\" id=\"site_search\" value=\"- Search -\" onfocus=\"if(this.value == '- Search -') this.value = '';\" />
		<a href=\"#\" >
			<img style='border: 0px;' src=\"".P2F_BASE_URL."/themes/".P2F_THEME."/images/go.png\" 
			onclick=\"if(document.getElementById('site_search').value != '- Search -') window.location='".P2F_BASE_URL."/index/index/search/?q=' + encodeURIComponent(document.getElementById('site_search').value)+'';\" />
		</a>
	</span>".$this->links."</div>";
	}
	function addLink(Link $link){
	    $l = $link->prepare();
		$this->links .= ' '.$l;
	}
	function createLink($text,$href){
		$link = new Link($text,$href);
		return $link;
	}
	function addLinks(Array $data){
	    foreach($data as $link){
		    $thisLink = $this->createLink($link['text'],$link['href']);
			foreach($link['attributes'] as $attribute => $value){
				$thisLink->setAttribute($attribute,$value);
			} 
			$this->addLink($thisLink);
		}
	}

}

class Link{
   public $link;
   public $attributes;
   public $text;
   
   function __construct($text,$href){
        $this->text = $text;
		$this->link = "<a href=\"".$href."\" ";
   }

   function setAttribute($name,$value){
		$this->link .= ' ' . $name . '=' . '\''.$value.'\'';
   }
   
   function prepare(){
		if($this->attributes) $this->link .= $this->attributes . ' ';
		$this->link .= ' >';
		$this->link .= $this->text;
		$this->link .= '</a>';
		
		return $this->link;
   }
}
?>