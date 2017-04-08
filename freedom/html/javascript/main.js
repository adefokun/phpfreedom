/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com

The general js file for the framework
*/


// stores the reference to the XMLHttpRequest object 
var xmlHttp = createXmlHttpRequestObject();  
// retrieves the XMLHttpRequest object 
function createXmlHttpRequestObject()  
{  
  // will store the reference to the XMLHttpRequest object 
  var xmlHttp; 
  // if running Internet Explorer 
  if(window.ActiveXObject) 
  { 
    try 
    { 
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
    } 
    catch (e)  
    { 
      xmlHttp = false; 
    } 
  } 
  // if running Mozilla or other browsers 
  else 
  { 
    try  
    { 
      xmlHttp = new XMLHttpRequest(); 
    } 
    catch (e)  
    { 
      xmlHttp = false; 
    } 
  } 
  // return the created object or display an error message 
  if (!xmlHttp) alert("Error creating the XMLHttpRequest object."); 
  else  
    return xmlHttp; 
}

 
function umchat(sid,i){
    open('http://www.e-supportsystems.com/applications/?appId=1&sid='+sid+'&catId='+i,'_','width=375,height=400,top=10,location=no,status=no,scrollbars=no');
}
 window.onload = function(){
   
   writeServerAlerts();
   
   plus = new Image();
   plus.src = P2F_BASE_URL + '/freedom/images/b_plus.png';
   minus = new Image();
   minus.src = P2F_BASE_URL + '/freedom/images/b_minus.png';
   if(MENU_STYLE == 'freedom'){
	   
   }
   else if(MENU_STYLE == 'progenics'){
   
	  navRoot = document.getElementById("nav-main").getElementsByTagName('ul')[0];
	  for (var i = 0; i < navRoot.childNodes.length; i++) {
		node = navRoot.childNodes[i];
		if (node.nodeName=="LI" ) {
			node.onclick=function() {
			var ul = navRoot.getElementsByTagName('ul');
			for (var j = 0; j < ul.length; j++) {
				if(ul[j].getElementsByTagName('ul').length == 0){
					ul[j].style.backgroundColor = '';
					ul[j].parentNode.style.backgroundColor = '';
					ul[j].style.display = '';
					ul[j].style.zIndex = '';
				}
			  
			}
			
			if(this.getElementsByTagName('ul').length){
				this.getElementsByTagName('ul')[0].parentNode.style.backgroundColor = '#FFF6D8';
				this.getElementsByTagName('ul')[0].style.backgroundColor = '#FFF6D8';
				this.getElementsByTagName('ul')[0].style.display = 'block';
				this.getElementsByTagName('ul')[0].style.zIndex = '1000';
			}
		}
		}
	   }
   }
}

function loadBreadcrumbs(){
   brSpan = document.getElementById('breadcrumbs-links');
   if(brSpan) simpleXHR(prepareUrl('/index/navigation/breadcrumbs'),'','','','breadcrumbs-links');
}
function expandNav(nav){
    var ul;
	if(ul = nav.parentNode.getElementsByTagName('ul')[0]){
	    var cd = nav.src; 
		if(cd == P2F_BASE_URL + '/freedom/images/b_plus.png'){
		    ul.style.display = 'block';
			nav.src = minus.src;
		}
		else{
	     	ul.style.display = 'none';
			nav.src = plus.src;
		}
	}
}
var FElement = {
    get : function(id){
	    return document.getElementById(id);
	},
	show : function(id){
		FElement.get(id).style.display = 'block';
	},
	hide : function(id){
		FElement.get(id).style.display = 'none';
	}
}
var FValidate = {
	email : function(entry){
	    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailPattern.test(entry); 
	},
	notEmpty : function(entry){
		if(entry == '') return false;
		else return true;
	}
}
function unHighlightLinks(){
	var links = document.getElementById('nav-main').getElementsByTagName('a'); 
	for(var i = 0; i < links.length; i++){ 
		if(links[i].className == 'current') {
			links[i].className = '';
			break;
		}
	}
}
function addAttachment(attchName,id){
    var attchBlock = document.getElementById(id);
	var newAttchDiv = document.createElement('div');
	newAttchDiv.innerHTML = "<input type='file' name='"+attchName+"[]'/> Label: <input type='text' name='label[]'/>";
	attchBlock.appendChild(newAttchDiv);
}

function getMultipleSelection(formName,elementName,array){
   var selected = new Array();
   var mySelect = document.forms[formName].elements[elementName];
 
   for(i = 0; i < mySelect.options.length; i++)
   {       
      if(mySelect.options[i].selected)       
	  {
          selected.push(mySelect.options[i].value);
      }
   }
	if(array != 'true') return selected.toString();
	else return selected;
}

function changeClass(id,class1,class2){

    var currClass = document.getElementById(id).className;
	var currClassArray = currClass.split(' ');
	var newClass = ''; 

	for(var i = 0; i < currClassArray.length; i++){
	    if (currClassArray[i] == class1)newClass += class2;		
		else newClass += currClassArray[i];
		if (i != currClassArray.length) newClass += ' ';
	}
	document.getElementById(id).className = newClass;
}
function checkFields(fn){
    var returnVal = true;
    if(fn){
	    var f = document.forms[fn];
		for(var i = 0; i < f.elements.length; i++){
		    if(f.elements[i].value == '') returnVal = false;
			break;
		}
	}
	return returnVal;
}
function highlightRow(tr){
    var currColor = tr.style.backgroundColor;
	tr.style.backgroundColor = 'beige';
	tr.onmouseout = function(){
	    tr.style.backgroundColor = currColor;
	}
}
function doSelect(fName,iName,e){
    var boxes = document.forms[fName].elements[iName];
	if(boxes.length > 1){
	    for(i = 0; i < boxes.length; i++){
		    if(e)boxes[i].checked = true;
		    else boxes[i].checked = false;
	    }
	}
	else if(boxes != null) {
	    if(e)boxes.checked = true;
		else boxes.checked = false;
	}
}
function selectChecked(dForm,dName,dInput){
  var selectedItems = document.forms[dForm].elements[dName];
  var itemsList = document.forms[dForm].elements[dInput];
  var cnt = 0;
  if(selectedItems.length > 1){
	  for(i = 0; i < selectedItems.length; i++){  
	    if(selectedItems[i].checked == true && selectedItems[i].value != 0){
	      itemsList.value += selectedItems[i].value+',';
	      cnt++;
	    }
	  }
  }
  else if(selectedItems != null){
      if(selectedItems.checked == true && selectedItems.value != 0){
	      itemsList.value += selectedItems.value+',';
	      cnt = 1;
	    }
  }
  if(cnt == 0){
    alert('No items are selected for the operation.');
    return false;
  }
  else return true;
}
//time for a little AJAX much more to come!

function loadError(){
    FAlert.write('The page could not be loaded at the moment please try again later.');
}
var Form = {
    getFormParams : function(obj){
		var parameters = ''
		for(var i = 0; i < obj.length; i++){
		    var input = obj.elements[i];
			var type = input.getAttribute('type');
		    if(type == 'radio' || type == 'checkbox'){
			    if(input.checked == true) parameters += input.name + "=" + encodeURIComponent(input.value ) + "&";
			}
			else parameters += input.name + "=" + encodeURIComponent(input.value ) + "&";
		}
		return parameters;
	},
	getFormParamsById : function(id){
		var obj = document.getElementById(id);
		return Form.getFormParams(obj);
	},	
	getFormParamsByName : function(name){
		var obj = document.forms[name];
		return Form.getFormParams(obj);
	}
}
function writeServerAlerts(id){
	url = prepareUrl('index/ajax/alerts');
	simpleXHR(url,'FAlert.writeAll','loadError','json','');
}
var XHRPost = {
    save : function(formName,callback,href){
		var c = (callback != undefined && callback != '') ? callback : 'XHRPost.saveResponse';
		XHRPost.doSend(formName,c,href,'json');
	},
	saveResponse : function(resp,formName){
		loadingAlert(0);
	    FAlert.writeAll(resp.response);
	    FAlert.writeErrors(resp.errors.values,formName);
	},
	insert : function(formName,callback,id,href){
	    var c = (callback != undefined && callback != '') ? callback : 'writeServerAlerts';
		XHRPost.doSend(formName,c,href,'',id);
	},
	post : function(formName,callback,id,href){
	    var c = (callback != undefined && callback != '') ? callback : '';
		XHRPost.doSend(formName,c,href,'',id);
	},
    doSend : function(formName,callback,href,type,id,loadError){
	    loadingAlert();
		var blockId = (id == undefined || id == '') ? 'mainblock' : id;
		var form = document.getElementById(formName);
		var le = (loadError != '' && loadError != undefined) ? loadError : 'loadError';
		var url = (href != '' && href != undefined) ? prepareUrl(href) : prepareUrl(form.getAttribute('action'));
		var parameters = Form.getFormParamsById(formName);	
		XHRPost.send(url,formName,parameters,callback,le,type,blockId);
	},
	send : function(url,formName,parameters,callback,error,type,id){
		if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0){

			xmlHttp.open('POST', url, true);

			
			xmlHttp.onreadystatechange = function(){
			    if(xmlHttp.readyState == 4){
				    if(xmlHttp.status == 200){
					    if(type == 'json'){ 
							setTimeout(callback + '('+ xmlHttp.responseText +',\'' + formName + '\')',50);
						}
						else if(type == 'xml'){
						
						}
						else {
						   	if(callback == ''){
								var block = document.getElementById(id);
								block.innerHTML = xmlHttp.responseText;								
					            loadingAlert(0);
							}
							else{
								pageInHTML = xmlHttp.responseText;
								var block = document.getElementById(id);
								if(block != null && block != undefined){
									block.innerHTML = pageInHTML;	
									pageInHTML = null;
								}
								if(callback != '') setTimeout(callback + '(\''+id+'\')',50);
							}
						}
					}
					else eval(error + '()');
				}
			};
		}
		else setTimeout('XHRPost.send(\''+url+'\',\''+name+'\',\''+parameters+'\',\''+callback+'\',\''+error+'\',\''+type+'\',\''+id+'\')',1000);		
		
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.setRequestHeader("Content-length", parameters.length);
		xmlHttp.setRequestHeader("Connection", "close");
		xmlHttp.send(parameters);
	}
}
function simpleXHR(url,callback,error,type,id){
	if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0){
		xmlHttp.open("GET",url,true);
		xmlHttp.onreadystatechange = function(){
		    
			if(xmlHttp.readyState == 4){
			    if(xmlHttp.status == 200){
				    
				    if(type == 'json'){ 
						setTimeout(callback + '('+ xmlHttp.responseText +')',50);
					}
					else if(type == 'xml'){}
					else {
						if(callback == ''){
							var block = document.getElementById(id);
							block.innerHTML = xmlHttp.responseText;							
					        loadingAlert(0);
						}
						else{
							pageInHTML = xmlHttp.responseText;
							var block = document.getElementById(id);
							if(block != null && block != undefined){
								block.innerHTML = pageInHTML;	
								pageInHTML = null;
							}
							if(callback != '') setTimeout(callback + '(\''+id+'\')',50);
						}
					}
				}
				else if(error) setTimeout(error + '()',50);
			}
		};
		xmlHttp.send(null);
	}
	else setTimeout('simpleXHR(\''+url+'\',\''+callback+'\',\''+error+'\',\''+type+'\',\''+id+'\')',1000);	
}
   function loadMainByPage(page){
        var url = P2F_BASE_URL + '/index/pages/display/?page=' + encodeURIComponent(page) + '&ajax=true';
		callXHR(url,'','loadError','',"mainblock");
   }
   function loadMainById(id){
        var url = P2F_BASE_URL + '/index/pages/display/?content_id=' + encodeURIComponent(id) + '&ajax=true';
		callXHR(url,'','loadError','',"mainblock");
   }
   function callXHR(url,callback,error,type,id){
        loadingAlert();
		simpleXHR(url,callback,error,type,id);
   }
   function prepareUrl(href){    
         
	   if(href.indexOf('?') != -1) href += '&ajax=true';
	   else if(href.indexOf('?') == -1 && href.charAt(href.length - 1) == '/') href += '?ajax=true';
	   else href += '/?ajax=true';
	   
	   var url; 
	   if(href.substr(0,4) == 'http'){
	        url = href;
	   }
	   else{
		   url = P2F_BASE_URL;
		   if(href.charAt(0) == '/') url += href;
		   else url += '/' + href;  
	   }
	   return url;
   }
	function loadUrl(href,block, f){
	    var id = (block == undefined || block == '' || block == null) ? 'mainblock' : block;
	    var callback = (f == undefined || f == '' || f == null) ? '' : f;
		url = prepareUrl(href);
		callXHR(url,callback,'loadError',false,id);
	}
   function loadPage(id){
		var block = document.getElementById(id);
		block.innerHTML = pageInHTML;
		pageInHTML = null;
		loadingAlert(0);
   }
	function loadingAlert(off){
		if(off == 0) {
			FAlert.clear();
		}
		else {
			FAlert.write('Loading... Please wait.');
		}
	}
	var FAlert = {
	    div : document.getElementById('ProcessAlert'),
		holder : document.getElementById('ProcessAlert_holder_content'),
		main : document.getElementById('mainblock'),
		write : function(c){
		   FAlert.div.style.display = 'block';
		   FAlert.holder.innerHTML = '<span>' + c + '</span>';
		},
		clear : function(){
		   FAlert.div.style.display = 'none';
		   FAlert.holder.innerHTML = '';
		},
		writeAll : function(obj){
		    if(obj.length > 0){
			    FAlert.clear();
			    FAlert.div.style.display = 'block';
			    for(var i = 0; i < obj.length; i++){
				    var span = document.createElement('span');
					span.appendChild(document.createTextNode(obj[i].toString()));
					FAlert.holder.appendChild(span);
				}
			}
		},
		writeErrors : function(obj,name){
		    var id = 'errors_' + name;
		    var ul = document.getElementById(id);
		    if(obj.length > 0){
			    
			    if(ul == undefined || ul == null){
					var ul = document.createElement('ul');
					ul.setAttribute('id',id);
				}
				else ul.innerHTML = '';
				var form = document.getElementById(name);
				ul.className = 'alert';
			    for(var i = 0; i < obj.length; i++){
				    var li = document.createElement('li');
					li.appendChild(document.createTextNode(obj[i].toString()));
					ul.appendChild(li);
				}
				form.parentNode.insertBefore(ul,form);
			}
			else if(ul != undefined && ul != null) ul.parentNode.removeChild(ul);
		}
	}
	
	function selectedOption(form,input){
	    var select = document.forms[form].elements[input];
		var index = select.selectedIndex;
		return select.options[index].value;
	}
	var ContentController = {
		allowedExtensions : function(type){
		   document.getElementById('content_attach_ext_div').innerHTML = 'Loading...';
		   var url = prepareUrl('admin/content/checkext/?content_type_key=' + type);
           simpleXHR(url,'','loadError',false,'content_attach_ext_div');
		},
		loadAttachments : function(resp,formName){
		    loadingAlert(0);
		    FAlert.writeAll(resp.response);
		    FAlert.writeErrors(resp.errors.values,formName);
			document.getElementById('content_attachments_list').innerHTML = 'Loading attachments...';
			var url = prepareUrl('admin/content/attachments/?eid=' + resp.identifier.value); 
  		    simpleXHR(url,'ContentController.displayAttachments','ContentController.loadAttachmentsError');
		},
		displayAttachments : function(){
		    document.getElementById('content_attachments_list').innerHTML = pageInHTML;
		},
		loadAttachmentsError : function(){
		    document.getElementById('content_attachments_list').innerHTML = 'Opps... some errors occured!';
		}
	}
	