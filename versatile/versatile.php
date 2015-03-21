<?php
// config
$title = "versatile";
$subtitle = "the textfile cms.";

addFile("./File1.txt");
addFile("./File2.txt");

// code
function addFile($file) {
  $handle = fopen($file,"r");
  $text = fread($handle, filesize($file));
  $text = parseToHTML($text);
  
  updateContent($text);
  updateMenu($text);
}
 
function updateContent($text) {
  global $content;
  $content = $content . $text;
}

function updateMenu($text) {
  global $menu;

  $lines = explode(PHP_EOL, $text);

  foreach($lines AS $current) {
    if(strpos($current, "h1 ") == true) {
      $header = preg_replace('/(.*)<h1 id=\"(.*)\">(.*)/', '\2',$current);
      $menu = $menu . "<a class=\"navbar\" href=\"#$header\">$header</a>\n";
    }
    if(strpos($current, "h2 ") == true) {
	  $color = stringToColorCode($current);

      $header = preg_replace('/(.*)<h2 id=\"(.*)\">(.*)/', '\2',$current);
      $menu = $menu . "<a title=\"$header\" style=\"background: #$color;\" class=\"navbar-sub\" href=\"#$header\">&nbsp;</a>\n";
    }
  }
}

function parseToHTML($text) {
  $text = htmlentities($text, ENT_NOQUOTES, "UTF-8");
  $text = preg_replace('/^(.+)([\r?\n?])^(====)(.*)([\r?\n?])/m', '<h1 id="\1">\1</h1>',$text);  // h1 ====
  $text = preg_replace('/^(.+)([\r?\n?])^(----)(.*)([\r?\n?])/m', '<h2 id="\1">\1</h2>\2',$text);  			// h2 ----
  $text = preg_replace('/^##\040(.*)([\r?\n?]|\z)/m', '<h3>\1</h3>\2',$text);  						// h3 ## 
  $text = preg_replace('/^(\040\040|\t)(.*)([\r?\n?]|\z)/m', '<pre>\2</pre>\3',$text);  			// code "  text"
  $text = preg_replace('/([a-z]{2,7}:\/\/.+)(\040|\t|[\r\n])/mU', '<a href="\1">\1</a>\2',$text);  	// url e.g "http://(.+)"
  
  return $text;
}

function stringToColorCode($str) {
  $code = dechex(crc32($str));
  $code = substr($code, 0, 6);

  $redhex  = substr($code,0,2);
  $greenhex = substr($code,2,2);
//  $bluehex = substr($code,4,2);
  $bluehex = "55";

  $greenhex = preg_replace('/[a-f](.*)/mU', '5$1', $greenhex);

  $code = $redhex . $greenhex . $bluehex;
  return $code;
}
?>
