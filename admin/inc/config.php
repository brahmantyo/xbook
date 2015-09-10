<?php
if(!isset($_SESSION)){
    session_start();
}

// site domain name with http
defined("SITE_URL")
    || define("SITE_URL","http://".$_SERVER['SERVER_NAME']."/admin");

// directory separator
defined("DS")
    || define("DS",DIRECTORY_SEPARATOR);

// root path
defined("ROOT_PATH")
    || define("ROOT_PATH",  realpath(__DIR__.DS."..".DS));

// system path
defined("SYSTEM_DIR")
    || define("SYSTEM_DIR", "system");

// classes folder
defined("CLASSES_DIR")
    || define("CLASSES_DIR",  "classes");

// pages folder
defined("PAGES_DIR")
    || define("PAGES_DIR",  "pages");

// modules folder
defined("MOD_DIR")
    || define("MOD_DIR",  "mod");

// inc folder
defined("INC_DIR")
    || define("INC_DIR",  "inc");

// templates folder
defined("TEMPLATE_DIR")
    || define("TEMPLATE_DIR",  "template");

// emails path
defined("EMAILS_PATH")
    || define("EMAILS_PATH",  ROOT_PATH.DS."emails");

// catalogue images path
defined("CATALOGUE_PATH")
    || define("CATALOGUE_PATH",  ROOT_PATH.DS."media".DS."catalogue");

//die(realpath(ROOT_PATH.DS."..".DS.SYSTEM_DIR));
// add all above directories to the include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH.DS."..".DS.SYSTEM_DIR),
    realpath(ROOT_PATH.DS."..".DS.CLASSES_DIR),
    realpath(ROOT_PATH.DS.PAGES_DIR),
    realpath(ROOT_PATH.DS.MOD_DIR),
    realpath(ROOT_PATH.DS.INC_DIR),
    realpath(ROOT_PATH.DS.TEMPLATE_DIR),
    get_include_path()
)));

// Database configuration
defined("DB_HOST")
    || define("DB_HOST", "localhost");
defined("DB_USER")
    || define("DB_USER", "root");
defined("DB_PASSWORD")
    || define("DB_PASSWORD", "");
defined("DB_NAME")
    || define("DB_NAME", "xbookdb");
    
define('HASH_PASSWORD_KEY', 'NicoAthanEndaAronSitepuMonikaGinting');


