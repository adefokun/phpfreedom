/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com

The general Widget js file for the framework
*/

//Panes_Tab
var Panes_Tabs = {
    showPane : function(container,paneId,url,refresh){
		var panes = document.getElementById('Panes_Tabs_'+container).getElementsByTagName('div');
		for(var i = 0; i < panes.length; i++){
			if(id = panes[i].getAttribute('id')){
			    var idArr = id.split('_');

				var content_id = idArr[idArr.length - 1];
				if(id == 'Panes_Tabs_pane_'+container+'_'+content_id){
					changeClass('Panes_Tabs_pane_'+container+'_'+content_id,'Panes_Tabs_currentPane','');
					changeClass('Panes_Tabs_tab_'+container+'_'+content_id,'Panes_Tabs_currentTab','');
				}
			}
		}
		if(document.getElementById('Panes_Tabs_pane_'+container+'_'+paneId) != null) {
			document.getElementById('Panes_Tabs_pane_'+container+'_'+paneId).className += ' Panes_Tabs_currentPane'; 
			document.getElementById('Panes_Tabs_tab_'+container+'_'+paneId).className += ' Panes_Tabs_currentTab'; 
		}
		var block = 'Panes_Tabs_pane_'+container+'_'+paneId;
		if(url != '' && block != null){
	        
			if(refresh) loadUrl(url,block);
			else if(document.getElementById(block).innerHTML == '') loadUrl(url,block);
		}
	}
}
