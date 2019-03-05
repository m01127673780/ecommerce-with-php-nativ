<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $title = "Members";
	include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    
    
    include $tpl . 'footer.php';
  }
    else {
		header('Location: login.php');
		exit();
	}
	ob_end_flush();
?>