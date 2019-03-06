<?php
session_start();
if(isset($_SESSION['name'])){
     header('location: index.php');
     exit();
  }
$title = 'login';
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
  	$username = $_POST['username']; $password = $_POST['password'];
  	$hashedpass = sha1($password);
  	$stmt = $con->prepare("select userid,username,password from users where username = ? and password = ? limit 1");
  	$stmt->execute(array($username,$hashedpass));
    $row = $stmt->fetch();  
  	$count = $stmt->rowCount();
  	if($count > 0){
  		$_SESSION['name'] = $username;
        $_SESSION['id']   = $row['userid'];  
        header('Location: index.php');
        exit();
  	}
      else{
          $form_errors = array('error in username or password');
      
      }
    }  /** end if isset($_POST['login']) **/
    
    else{
        $username = $_POST['username'];     $password = $_POST['password'];
        $password2 = $_POST['password2'];   $email = $_POST['email'];
        $fullname  = $_POST['fname'];
        if(empty($username) || empty($password) || empty($email)){
            $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
            redirectHome($msg, $url = 'login.php');
        }
        $form_errors = array();
        $filter_user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        if(strlen($filter_user)<3){
            $form_errors[] = ' Username Must Be Larger than 2 character'; 
        }
        $pass1 = sha1($_POST['password']);
        $pass2 = sha1($_POST['password2']);
        if($pass1 != $pass2){
           $form_errors[] = 'there are differences between two passwords'; 
        }
        if(strlen($pass1)<8){
            $form_errors[] = ' Pasword Must Be Larger than 7 character'; 
        }
        
        $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(filter_var($filter_email, FILTER_VALIDATE_EMAIL) != TRUE){
            $form_errors[] = 'This Email Isn\'t Valid';
        }
         if(strlen($fullname)<12){
            $form_errors[] = ' Full Name Must Be Larger than 11 character'; 
        }
        
    }
    

         if(empty($form_errors)){
                $check = checkinfo('username', 'email', 'users', $username,$email);
                if(empty($check)){
                    
                   $stmt = $con->prepare("insert into users (username, password, email, fullname, regstatus, date) values(?,?,?,?, 0,now())");
                   $stmt->execute(array($username, $pass1, $email, $fullname));
                   $count = $stmt->rowCount();
                   
                   $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                   $url = "index.php";
                   redirectHome($msg,$url); 
                    echo "it's ok";
                    
                }
                else{
                    if($check['username'] == $username){
                        $form_errors[] = 'sorry this user is exist please try another username';
                    }
                    else{
                        $form_errors[] = 'sorry this email is exist please try another email';
                    }
                 
                 }
            
        } /** end if empty($form_errors) **/
                

  } /** end if $_SERVER['REQUEST_METHOD'] **/
?>
<div class="container log">
    <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span></h1>
    
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">     
        <div class="form-group row">
        <input type="text" id="username" name="username" placeholder="Type your name" class="form-control" required />
        </div>
        <div class="form-group row">
        <input type="password" id="password" name="password" placeholder="Type your password" autocomplete="new-password" 
               class="form-control" required />
        </div>
        <div class="form-group row">
       <input type="submit" class="btn btn-primary btn-block" name="login" value="Login" />
        </div>
    </form>
    
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form-group row">
        <input type="text" name="username" placeholder="Type your name" class="form-control" autocomplete="off" 
               minlength="3" maxlength="20" required/>
        </div>
        <div class="form-group row">
        <input type="password" name="password" placeholder="Type your password" autocomplete="new-password" 
               class="form-control" minlength="8" maxlength="20" required/>
        </div>
        <div class="form-group row">
        <input type="password" name="password2" placeholder="Type your password again" autocomplete="new-password" 
               class="form-control" minlength="8" maxlength="20" required/> 
        </div>
        <div class="form-group row">
        <input type="email" name="email" placeholder="Type your email" class="form-control"  required/>
        </div>
        <div class="form-group row">
        <input type="text" name="fname" placeholder="Type your Full Name" class="form-control" minlength="12" maxlength="40" required/>
        </div>        
        <div class="form-group row">
       <input type="submit" class="btn btn-success btn-block" value="Signup" />
        </div>
    </form> 
    <?php
     if(!empty($form_errors)){
         foreach($form_errors as $error){
             
                echo "<div class='errmsg bg-white'>
               <div class=' ' >$error</div>
               </div>";
                   
         }
     }
    ?>

</div>
<?php
include $tpl.'footer.php';
?>