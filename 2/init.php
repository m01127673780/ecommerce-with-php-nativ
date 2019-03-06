<?php

                       /// ******************** connect the database ******************** /// 
include "admin/connect.php";

                       /// ********************** routes ********************** ///
$tpl    =  "includes/templates/";   //template directory
$css    =  "themes/default/css/";   //css directory
$js     =  "themes/default/js/" ;   //javascript directory
$func 	=  "includes/functions/";  //function directory
$lang   =  "admin/includes/languages/";   //language directory
$img    =  "themes/default/images/";  //fav icon

                     /// ******************* include files ********************** ///
include $lang."english.php";
include $func."function.php";
include $tpl."header.php";
include $tpl."navbar.php";

?>