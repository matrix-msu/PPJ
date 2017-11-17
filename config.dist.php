<?php
// Bases
define("BASE_PATH", "");
define("BASE_URL", "");
define("BASE_PATH_KORA","");
define("BASE_URL_KORA","http://kora.matrix.msu.edu/");
define("COMMUNITY_URL","http://publicphilosophyjournal.org/");

// KORA BASE PATH
require_once(BASE_PATH_KORA.'/includes/koraSearch.php');

//KORA
define("token", 'b5c05a377f5863b06d4b2150');
define("projectID", "118");
define("Object", "700");
define("Comments", "701");
define("Volume","702");
define("Issue","703");
define("KoraUser","");
define("KoraPwd","");


// URLs and PATHS

define("KORA_URL", "http://kora.matrix.msu.edu");
define("IMG_URL", BASE_URL."wp-content/themes/Udu/images");
define("THUMBS_URL", IMG_URL."/thumbs/");
define("THEME_PATH", BASE_PATH."wp-content/themes/Udu/");
define("THEME_URL", BASE_URL."wp-content/themes/Udu/");
define("INCLUDE_PATH", BASE_PATH."wp-content/themes/Udu/includes");
define("IMG_PATH", BASE_PATH."wp-content/themes/Udu/images");
define("THUMBS_PATH", IMG_PATH."/thumbs/");
define("CONTENT_PATH",THEME_PATH."/upload/content/");

// BELOW HERE ARE GLOBAL JAVASCRIPT VARS WE SET FOR FLEXIBLE USE IN APPLICATION
define("globaljsvars", 
		"<script type='text/javascript'>\n" .
	"// MATRIX GLOBAL JS VARS\n" .
	"var BASE_URL =' ".BASE_URL."';\n" .
	"var THEME_URL =' ".THEME_URL."';\n" .
	"var THUMBS_URL =' ".THUMBS_URL."';\n" .
	"var BASE_URL_KORA =' ".BASE_URL_KORA."';\n" .
	"var KORA_projectID = ' ".projectID."';\n" . 
	"var KORA_Object = ' ".Object."';\n" . 
	
	"</script>\n");
?>