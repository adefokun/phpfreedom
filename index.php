<?php
/**
Author: ADEFOKUN Tomiwa M.
Year: 2009 
Email: tomiwa.adefokun@gmail.com
*/

//Set the path to application directory.
//Main library is in /application. 
$path_to_application_directory  = './application'; 

//For security reasons it is essential that the /application  folder is moved outside of your web server, so that it can not be accessed via a url 
//$path_to_application_directory  = 'C:\projects\php\phpfreedom\application'; 

define('P2F_APP_DIR',$path_to_application_directory);

set_include_path(get_include_path() . PATH_SEPARATOR . P2F_APP_DIR . '/includes');

require_once('FController.php');
$master = new FController();

define('P2F_BASE_URL',$master->getBaseUrl());
define('P2F_INSTALL_DIR',$master->getConf(true)->path['installDir']);
define('P2F_WEB_DIR',$master->getConf(true)->path['webDir']);
define('P2F_WEB_URL',$master->getWebUrl());

include_once('Constants.inc');

$module = $master->getModule();
$controller = $master->getController();
$action = $master->getAction();

$theme = $master->getTheme();

define('P2F_MODULE',$module);
define('P2F_THEME',$theme);

if($master->getParam('nav')) $master->addToSession('navId',$master->getParam('nav')); 

$content = $master->buildBlock(array('controller' => $controller,'module' => $module,'action' => $action),false);
$content->doPageAction();


if($content->useLayout == true)
{	
	include_once('FScriptLoader.php');
	FScriptLoader::cleanAll();
	
	require_once(P2F_INSTALL_DIR . '/themes/'.$theme.'/layout/'.$content->getLayout().'.phtml');	

}
else $content->displayContent();


?>