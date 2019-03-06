<?php

                       /// ******************** connect the database ******************** /// 
include "connect.php";

                       /// ********************** routes ********************** ///
$tpl    =  "includes/templates/";   //template directory
$css    =  "themes/default/css/";   //css directory
$js     =  "themes/default/js/" ;   //javascript directory
$func 	=  "includes/functions/";  //function directory
$lang   =  "includes/languages/";   //language directory
$img    =  "themes/default/images/";  //fav icon

                     /// ******************* include files ********************** ///
include $lang."english.php";
include $func."function.php";
include $tpl."header.php";
if(!isset($noNavbar)){include $tpl."navbar.php";}


?>