<?php
  session_start();
  if(isset($_SESSION['username'])){
     header('location: dashboard.php');
     exit();
  }
  $noNavbar ='';
  $title = 'login';
  include "init.php";

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  	$username = $_POST['username']; $password = $_POST['password'];
  	$hashedpass =($password);
  	$stmt = $con->prepare("select userid,username,password from users where username = ? and password = ? and permissionid=1 limit 1");
  	$stmt->execute(array($username,$hashedpass));
    $row = $stmt->fetch();  
  	$count = $stmt->rowCount();
  	if($count > 0){
  		$_SESSION['username'] = $username;
        $_SESSION['userid']   = $row['userid'];  
        header('Location: dashboard.php');
        exit();
  	}
      else{
          echo "<div class='container'>
               <div class='alert alert-danger loginmsg' >error in username or password</div>
               </div>";
      }

  } /** end if **/
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" autocomplete="off" >
	<h4 class="text-center">Admin Login</h4>
	<input class="form-control" type="text" name="username" placeholder="username" autocomplete="off" />
	<input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" />
	<input class="btn btn-primary btn-block" type="submit" value="login" />
</form>

<?php
  include $tpl."footer.php";
?>  