<?php
session_start();
if(isset($_SESSION['username'])){
    $title = "Members";
  include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    
    if($action == 'manage'){
      $query = '';
      if(isset($_GET['activate']) && $_GET['activate'] == 'pending' ){
         $query = " and regstatus = 0";
      }    
      $stmt = $con->prepare("select * from users where permissionid != 1 $query order by userid desc");
      $stmt->execute();
      $rows = $stmt->fetchAll();  
    ?>
   
  <h1 class="text-center">Manage Members</h1>
<div class="container">
<div class="table-responsive">
  <table class="main-table table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Full Name</th>
      <th scope="col">Registered Date</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
      <?php
           foreach($rows as $row){              
           echo "<tr>";
               echo "<td>".$row['userid']."</td>";
               echo "<td>".$row['username']."</td>";
               echo "<td>".$row['email']."</td>";
               echo "<td>".$row['fullname']."</td>";
               echo "<td>".$row['date']."</td>";
               echo "<td class='control'> 
                          <a href='?action=edit&userid=" .$row['userid']. "' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a>
                          <a href='?action=delete&userid=" .$row['userid']. "' class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>";
                    if ($row['regstatus'] == 0){
                        echo "<a href='?action=activate&userid=" .$row['userid']. "' class='btn btn-info activate'><i class='fas fa-edit'></i>Activate</a>";
                      }  
                echo "</td>";
            echo"</tr>";   
               
      }
      ?>
</tbody>
</table>
</div>
     <a href="?action=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
</div><!-- end of container --><br><br>
    <?php  
      }/************* end of manage page *************/

       /************* start edit page *************/
    elseif($action == 'edit'){ 
      if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
          $userid = intval($_GET['userid']);
      }
      else{
          $userid = 0;
      }   
    $stmt = $con->prepare("select * from users where userid = ? limit 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0){
    ?>
       <h1 class="text-center">Edit Member</h1>
       <div class="container">
        <form action="?action=update" method="post">
          <input type="hidden" name="userid" value="<?php echo $userid;?>" />    
          <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label form" autocomplete="off">Username</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control"
                     minlength="3" required />
            </div>
          </div>
            <div class="form-group row">
            <label for="Password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10 col-md-6">
              <input type="password" name="password" class="form-control " autocomplete="new-password"
                     minlength="8" placeholder='you can leave it blank'/>
            </div>
          </div>
                      <div class="form-group row">
            <label for="Password" class="col-sm-2 col-form-label">Password Again</label>
                <div class="col-sm-10 col-md-6">
            <input type="password" name="password2" autocomplete="new-password" 
                   class="form-control" minlength="8" placeholder='you can leave it blank'/> 
                </div>
            </div>
              <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10 col-md-6">
              <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control" required />
            </div>
          </div>
                  <div class="form-group row">
            <label for="fullname" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="full" value="<?php echo $row['fullname'];?>" class="form-control" 
                     minlength="12" required />
            </div>
          </div>
            <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 ">
              <input type="submit" class="btn btn-primary btn-lg" value="save" />
                </div>

            </div>
        </form>

      <?php
        }/************* end if for checking if there is a valid userid *************/
        else{
                $msg = "<div class='alert alert-danger'>there is no such id</div>";
                redirectHome($msg);
        }
        
      } /************* end of edit page *************/
    
    /************* start update page *************/
    elseif($action == 'update'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userid     = $_POST['userid'];
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2']; 
            $email      = $_POST['email'];
            $fullname   = $_POST['full'];
            
            if(empty($password) &&  empty($password2)){
                  if(empty($username) || empty($email)){
                        $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
                        redirectHome($msg, $url = 'member.php?action=edit&userid=$userid');
                    }         
            }
            else{
                 if(empty($username) || empty($password) || empty($email) || empty($password2)){
                        $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
                        redirectHome($msg, $url = 'member.php?action=edit&userid=$userid');
                    }    
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
            
            $filter_full = filter_var($fullname, FILTER_SANITIZE_STRING);
            if(strlen($filter_full)<12){
                $form_errors[] = ' Full Name Must Be Larger than 11 character'; 
            }
            
         if(empty($form_errors)){
                $stmt = $con->prepare("select username,email from users where (username = ? or email = ?) and userid != ? limit 1");
                $stmt->execute(array($username,$email,$userid));
                $users = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count==0){ 
                   if(empty($password) &&  empty($password2)){
                       $stmt = $con->prepare("update users set username = ?, email = ?,fullname = ? where userid = ?");
                       $stmt->execute(array($filter_user, $filter_email, $fullname, $userid));
                       $count = $stmt->rowCount();

                       $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                       $url = "member.php?action=edit&userid=$userid";
                       redirectHome($msg,$url); 
                    }                    
                 else{
                        $stmt = $con->prepare("update users set username = ?, password = ?, email = ?,fullname = ? where userid = ?");
                        $stmt->execute(array($filter_user,$pass1,$filter_email,$fullname,$userid));
                        $count = $stmt->rowCount();

                        $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                        $url = "member.php?action=edit&userid=$userid";
                        redirectHome($msg,$url);
                    }

                } /* end if($count==0) */
             
                else{ 
                    if($users['username'] == $username){
                        $form_errors[] = 'sorry this user is exist please try another username';
                    }
                    else{
                        $form_errors[] = 'sorry this email is exist please try another email';
                    }
                 
                 }
                 
            
        } /** end if empty($form_errors) **/
        if (!empty($form_errors)){
                $url = "member.php?action=edit&userid=$userid";
                $msg = $form_errors;
                redirectHome($msg,$url);     
          }

            
    } /* end if($_SERVER['REQUEST_METHOD'] == 'POST') */
            
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
        
    }/************* end of update page *************/
    
     /************* start add page *************/ 
     elseif($action == 'add'){
     ?>
      <h1 class="text-center">Add New Member</h1>
       <div class="container">
        <form action="?action=insert" method="post">
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label form" autocomplete="off">Username</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="username" class="form-control" minlength="3" required />
            </div>
          </div>
            <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10 col-md-6">
              <input type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required/>
            </div>
          </div>
            <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password Again</label>
            <div class="col-sm-10 col-md-6">
              <input type="password" name="password2" class="form-control" minlength="8" autocomplete="new-password" required/>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10 col-md-6">
              <input type="email" name="email" class="form-control" required/>
            </div>
          </div>
             <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="full" class="form-control" minlength="12"  required/>
            </div>
          </div>
            <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 ">
              <input type="submit" class="btn btn-primary btn-lg" value="save" />
                </div>

        </div>
        </form>
   <?php
        
    }/************* end of add page *************/
    
    /*************** start insert page *****************/
    elseif($action == 'insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){                        
                $username = $_POST['username'];     $password = $_POST['password'];
                $password2 = $_POST['password2'];   $email = $_POST['email'];
                $fullname  = $_POST['full'];
                if(empty($username) || empty($password) || empty($email) || empty($password2)){
                    $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
                    redirectHome($msg, $url = 'index.php');
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
                $filter_full = filter_var($fullname, FILTER_SANITIZE_STRING);
                if(strlen($filter_full)<12){
                    $form_errors[] = ' Full Name Must Be Larger than 11 character'; 
                }
           

         if(empty($form_errors)){
                $check = checkinfo('username', 'email', 'users', $username,$email);
                if(empty($check)){
                    
                   $stmt = $con->prepare("insert into users (username, password, email, fullname, regstatus, date) values(?,?,?,?, 1,now())");
                   $stmt->execute(array($filter_user, $pass1, $filter_email, $filter_full));
                   $count = $stmt->rowCount();
                   
                   $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                   $url = "member.php";
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
                
            if(!empty($form_errors)){
            $url = "member.php";
            $msg = $form_errors;
            redirectHome($msg,$url);
            }     
        }
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
    }   /********** end of insert page ***********/
    
    /**************** start  delete page ************/
    elseif($action == 'delete'){

          if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
               $userid = intval($_GET['userid']);
          }
          else{
          $userid = 0;
          }  
        
          $count = checkItem('userid','users',$userid);
          if ($count > 0){         
              $stmt = $con->prepare("delete from users where userid = ?");
              $stmt->execute(array($userid));

              $msg = "<div class='alert alert-success' role='alert'> $count record Deleted </div>";
              $url = "member.php";
              redirectHome($msg,$url);      
          } 
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid userid *************/
        
    }/************* end of delete page *************/
    
    
    /**************** start  activate page ************/
    elseif($action == 'activate'){
         if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
               $userid = intval($_GET['userid']);
          }
          else{
          $userid = 0;
          }  
        
          $count = checkItem('userid','users',$userid);
          if ($count > 0){         
          $stmt = $con->prepare("update users set regstatus = ? where userid = ?");
              $stmt->execute(array(1,$userid));

              $msg = "<div class='alert alert-success' role='alert'> $count record Activated </div>";
              $url = "member.php?activate=pending";
              redirectHome($msg,$url);      
          } 
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid userid *************/
        
    }/************* end of activate page *************/
    
    
      include $tpl."footer.php";
    }/************* end if for session *************/



else{
  header('location: index.php');
  exit();
}
?>


           
           
           
           
           
           
           
           
           
           
           