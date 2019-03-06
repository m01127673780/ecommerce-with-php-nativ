<?php
ob_start();
session_start();
if(isset($_SESSION['name'])){
    $title = 'Home';
    include "init.php";

    print_r($_SESSION);

    echo 'welcome';
    include $tpl."footer.php";
}
else{
		header('Location: index.php');
		exit();
	}

ob_end_flush();
?>