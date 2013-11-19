<?php
/**
* All requests routed through here. This is an overview of what actaully happens during
* a request.
*
* @package KaisanCore
*/
//
// PHASE: BOOTSTRAP
//
define('KAISAN_INSTALL_PATH', dirname(__FILE__));
define('KAISAN_SITE_PATH', KAISAN_INSTALL_PATH . '/site');

require(KAISAN_INSTALL_PATH.'/src/bootstrap.php');

$ka = CKaisan::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
//
$ka->FrontControllerRoute();


//
// PHASE: THEME ENGINE RENDER
//
$ka->ThemeEngineRender(); 
