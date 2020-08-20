<!-- /*1904362*/ -->
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<link rel="stylesheet" href="assets/stylesheets/mainstylesheet.css" type = "text/css">

<?php 
/*
$url = $_SERVER['REQUEST_URI'];
var_dump($url);
switch($url){
    case "/ce154/catalogueTemplate.php":
        echo "<link rel=\"stylesheet\" href=\"stylesheet.css\" type = \"text/css\">";
    case "/ce154/login.php":
        echo "<link rel=\"stylesheet\" href=\"stylesheet.css\" type = \"text/css\">";
        echo "<link rel=\"stylesheet\" href=\"loginstylesheet.css\" type = \"text/css\">";
    case "/ce154/register.php":
        echo "<link rel=\"stylesheet\" href=\"stylesheet.css\" type = \"text/css\">";
        echo "<link rel=\"stylesheet\" href=\"loginstylesheet.css\" type = \"text/css\">";
}*/
session_start();
include("database.php");
include("functions.php");
include("accessright.php");
include("nav.php");
echo "<title>".$pagetitle."</title>";

?>
