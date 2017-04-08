<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
class ThemeSelector extends Widget{
    public $widget;
	public $currentTheme;
	
	public function build()
	{
		$themes = scandir(P2F_INSTALL_DIR.'/themes');
		$ref = '';
		foreach($_GET as $k => $v){
		   if($k != 'theme') $ref .= $k.'='.$v.'&';
		}
		$options = '<option value=\'#\'>Change Theme</option>';
		foreach($themes as $k => $theme){
		    if($k > 1 && is_dir(P2F_INSTALL_DIR.'/themes/'.$theme)){
			    $options .= '<option value=\''.$theme.'\' >'.ucfirst(strtolower($theme)).'</option>';
			}
		}
		$this->widget = "<span class='ThemeSelector' >Current Theme: 
						".ucfirst(strtolower($this->currentTheme))." 
<select id='freedom_widget_theme_selector' onchange=\"window.location =   ''+window.location.toString().split('/?')[0]+'/?".$ref."theme='+encodeURIComponent(this.value)+''\">
						".$options."</select></span>";
	}
	
}
?>