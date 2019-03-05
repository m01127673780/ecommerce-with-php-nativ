<?php
ob_start();
session_start();
if(isset($_SESSION['name'])){
$title = 'Profile';
include "init.php";
    
$action = isset($_GET['action']) ? $_GET['action'] : 'manage';
/************* start manage page *************/
 if($action == 'manage'){      
$info  = getItem('*', 'users','username',$_SESSION['name']);
//$items = getItem('*', 'items','member_id',$_SESSION['id']);
$items = getItem3('*', 'items','member_id','id',$_SESSION['id']);
//$comments = getItem('*', 'comments','user_id',$_SESSION['id']);
?>
<h1 class="text-center">My Profile</h1>
<div class="info">
    <div class="container">
        <div class="card ">
            <div class="card-header bg-primary text-white">My Inforamtion</div>
            <div class="card-body">
                <div class="card-text">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas fa-unlock"></i>
                            <span>Login Name </span>: <?php echo $info[0]['username'];?>
                        </li>
                        <li>
                            <i class="far fa-envelope"></i>
                            <span>Email </span>: <?php echo $info[0]['email'];?>
                        </li>
                        <li>
                            <i class="fas fa-user"></i>
                            <span>Full Name  </span>: <?php echo $info[0]['fullname'];?>
                        </li>
                        <li>
                            <i class="far fa-calendar-alt"></i>
                            <span>Register date </span>: <?php echo $info[0]['date'];?>
                        </li>
                    </ul>
                    <a href="profile.php?action=editinfo" class="btn btn-light bg-white">Edit Information</a>
                </div>
            </div>        
        </div> <!-- end card div -->     
    </div>
</div>

<div id="ads" class="ads">
    <div class="container items">
        <div class="card ">
            <div class="card-header bg-primary text-white">Latest Ads</div>
            <div class="card-body">
                <div class="card-text">
                    <?php
                         echo "<div class='row'>";
                         if(empty($items)){
                             echo 'There\'s No Ads To Show';
                         }
                          else{  
                             $path = 'uploads/product-img/';
                             foreach($items as $item){
                             echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
                                echo "<div class='card'>";
                                    echo "<span class='price-tag'>$". $item['price'] ."</span>";
                                    echo "<a href='items.php?id=".$item['id']."'>
                                    <img src='".$path.$item['image']."' class='card-img-top img-thumbnail img-responsive'></a>";
                                    echo "<div class='card-body'>";
                                        echo "<span class='details'>";
                                           echo "<h3 class='card-title'><a href='items.php?id=".$item['id']."'>" .$item['name']. "</a></h3>";
                                           echo "<div class='card-text'>";
                                               echo "<p>".$item['description']."</p>";
                                           echo "</div>";                
                                        echo "</span>";
                                        echo "<div class='card-text'>";
                                               echo "<div class='date text-right'>".$item['date']."</div>";
                                           echo "</div>"; /* end card-text */
                                    echo "</div>";
                                    echo "<div class='text-center cont-ads'><a href='profile.php?action=editads&id=".$item['id']."' 
                                                                    class='btn btn-primary'>Edit</a>
                                         <a href='?action=deleteads&id=".$item['id']."' class='btn btn-danger confirm'>Delete</a></div>"; 
                                echo "</div>";/* end card*/
                             echo "</div>"; /* end of col */
                         }
                          } // end else

                         echo "</div>";  /* end of row */
                    ?>
                </div>
            </div>        
        </div> <!-- end card div -->          
    </div>
</div>
<?php 
 } /************* end of manage page *************/
    
    
    /************* start edit page *************/
    elseif($action == 'editinfo'){ 
        $userid = $_SESSION['id'];   
        $stmt = $con->prepare("select * from users where userid = ? limit 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0){
        ?>
       <h1 class="text-center">Edit Member</h1>
       <div class="container">
        <form action="?action=updateinfo" method="post" class="asteriskbig">  
          <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label form" autocomplete="off">Username</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control" minlength="3" required />
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
    elseif($action == 'updateinfo'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userid     = $_SESSION['id'];
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2']; 
            $email      = $_POST['email'];
            $fullname   = $_POST['full'];
            
            if(empty($password) &&  empty($password2)){
                  if(empty($username) || empty($email)){
                        $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
                        redirectHome($msg, $url = 'profile.php');
                    }         
            }
            else{
                 if(empty($username) || empty($password) || empty($email) || empty($password2)){
                        $msg = "<div class='alert alert-danger' > You Should Enter All Required Data</div>";
                        redirectHome($msg, $url = 'profile.php');
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
                    $_SESSION['name'] = $filter_user;
                    $_SESSION['id']   = $userid;
                   if(empty($password) &&  empty($password2)){
                       $stmt = $con->prepare("update users set username = ?, email = ?,fullname = ? where userid = ?");
                       $stmt->execute(array($filter_user, $filter_email, $fullname, $userid));
                       $count = $stmt->rowCount();

                       $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                       $url = "profile.php";
                       redirectHome($msg,$url); 
                    }                    
                 else{
                        $stmt = $con->prepare("update users set username = ?, password = ?, email = ?,fullname = ? where userid = ?");
                        $stmt->execute(array($filter_user,$pass1,$filter_email,$fullname,$userid));
                        $count = $stmt->rowCount();

                        $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                        $url = "profile.php";
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
                $url = "profile.php";
                $msg = $form_errors;
                redirectHome($msg,$url);     
          }

            
    } /* end if($_SERVER['REQUEST_METHOD'] == 'POST') */
            
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
        
    }/************* end of update page *************/
    
    /************* start edit page *************/
    elseif($action == 'editads'){ 
      if(isset($_GET['id']) && is_numeric($_GET['id'])){
          $item_id = intval($_GET['id']);
      }
      else{
          $item_id = 0;
      }   
    $stmt = $con->prepare("select * from items where id = ? limit 1");
  	$stmt->execute(array($item_id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0){
        // check if this item belong to this user
        $item_member = getItem('member_id', 'items','id', $item_id);
        if($item_member[0]['member_id'] == $_SESSION['id']){
            
        
        
    ?>
       <h1 class="text-center">Edit Item</h1>
       <div class="container asteriskbig">
        <form action="?action=updateads" enctype="multipart/form-data" method="post">
            <input type="hidden" name="item_id" value="<?php echo $row['id'];?>" />
          <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" 
                         id="name" placeholder="Name Of The Item" value="<?php echo $row['name'];?>" minlength="3" required />
                </div>
          </div>     
                      <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" 
                          placeholder="Description Of The Item" value="<?php echo $row['description'];?>" minlength="12" required />
                </div>
                </div>
                               <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Price</label>
                <div class="col-sm-10 col-md-6">
                  <input type="number" name="price" class="form-control" 
                          placeholder="Price Of The Item" value="<?php echo $row['price'];?>" required />
                </div>
                </div>
                               <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Country</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="country" class="form-control" 
                          placeholder="Country Of The Item" value="<?php echo $row['country_made'];?>" minlength="3" required />
                </div>
                </div>
                                  <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Product Image</label>
                <div class="col-sm-10 col-md-6">
                  <input type="file" name="img" class="form-control" />
                </div>
                   <span class="warn-right">You Can Leave It Blank .. Your<br> Old Image Will Stay The Same</span>
                </div>
                        <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Status</label>
                <div class="col-sm-10 col-md-6">
                <select name="status">
                    <option value="1" <?php if($row['status']==1) echo "selected";?>>New</option>
                    <option value="2" <?php if($row['status']==2) echo "selected";?>>Like New</option>
                    <option value="3" <?php if($row['status']==3) echo "selected";?>>Used</option>
                    <option value="4" <?php if($row['status']==4) echo "selected";?>>Old</option>
                </select>
                </div>
                </div>            

            
                <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Categories</label>
                <div class="col-sm-10 col-md-6">
                <select name="categories">
                 <?php
                   $stmt = $con->prepare("select * from categories");
                   $stmt->execute();
                   $cats = $stmt->fetchAll();
                   foreach($cats as $cat){
                       echo "<option value='" .$cat['id']. "'";
                       if($row['cat_id']==$cat['id']) echo "selected";
                       echo ">" .$cat['name']. "</option>";
                   }
                    
                ?>
                </select>
                </div>
                </div>
         <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 ">
              <input type="submit" class="btn btn-primary btn-lg" value="save" />
                </div>

        </div>
        </form><br><br>
      <?php
        } /************* end if for checking if this item belong to this user *************/
        else{
              $msg = "<div class='alert alert-danger'>It Seems That This Item Doesn't Belong To You</div>";
              $url = "profile.php";
              redirectHome($msg,$url);
        }
    }/************* end if for checking if there is a valid itemid *************/
        else{
                $msg = "<div class='alert alert-danger'>there is no such id</div>";
                redirectHome($msg);
        }
        
      } /************* end of edit page *************/
    
    
    /************* start updateads page *************/
    elseif($action == 'updateads'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $item_id = filter_var($_POST['item_id'], FILTER_SANITIZE_NUMBER_INT);
            
            $stmt = $con->prepare("select * from items where id = ? limit 1");
            $stmt->execute(array($item_id));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0){
                $item_member = getItem('member_id', 'items','id', $item_id); // check if the ad belongs to this member
                if($item_member[0]['member_id'] == $_SESSION['id']){
                $member_id     = $_SESSION['id'];
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                if(strlen($name) < 3){
                    $err_form[] = 'Item Name Must Be At Least 3 Characters';
                }

                $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                if(strlen($description) < 12){
                    $err_form[] = 'Item description Must Be At Least 12 Characters';
                }

                $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
                if(strlen($country) < 3){
                    $err_form[] = 'Country Must Be At Least 3 Characters';
                }

                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
                if(empty($price)){
                    $err_form[] = 'Price Can\'t Be Not Empty';
                }

                $status  = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
                if(empty($status)){
                    $err_form[] = 'Status Can\'t Be Not Empty';
                }

                $cat_id   = filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
                if(empty($cat_id)){
                    $err_form[] = 'Categories Can\'t Be Not Empty';
                } 

                $err_form = array(); 
                if(!empty($_FILES['img']['name'])){
                    $img_name      = $_FILES['img']['name'];
                    $img_type      = $_FILES['img']['type'];
                    $img_size      = $_FILES['img']['size'];
                    $img_tmp       = $_FILES['img']['tmp_name'];
                    $img_allow_extension = array('jpg','jpeg','png','gif');
                    $img_extension = explode('.',$img_name);
                    $img_extension = end($img_extension);
                    if(!empty($img_name) && !in_array($img_extension,$img_allow_extension)){
                        $err_form[] = 'This Extension Isn\'t Allowed ';
                      }
                    if($img_size > 4194304){
                        $err_form[] = 'Image Size Can\'t be more than 4 M.B';     
                      }
                }    

               if(empty($err_form)){
                        if(!empty($_FILES['img']['name'])){
                            $img_name = rand(0,1000000)."_".$img_name;
                            $path = 'uploads/product-img/'.$img_name;
                            move_uploaded_file($img_tmp, $path);

                            $img_old  = getItem('image', 'items', 'id', $item_id);
                            $old_path ='uploads/product-img/';
                            unlink($old_path.$img_old[0]['image']);


                            $stmt = $con->prepare("update items set name = ?, description = ?, price = ?,
                            country_made = ?, status = ?, member_id = ?, cat_id = ?, image = ? where id = ?");
                            $stmt->execute(array($name,$description,$price,$country,$status,$member_id,$cat_id,
                                                 $img_name,$item_id));
                            $count = $stmt->rowCount();

                            $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                            $url = "profile.php#ads";
                            redirectHome($msg,$url);
                            }
                        else{
                            $stmt = $con->prepare("update items set name = ?, description = ?,  price = ?,
                            country_made = ?, status = ?, member_id = ?, cat_id = ? where id = ?");
                            $stmt->execute(array($name,$description,$price,$country,$status,$member_id,$cat_id,$item_id));
                            $count = $stmt->rowCount();

                            $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                            $url = "profile.php#ads";
                            redirectHome($msg,$url);                     
                            }
                    } /* end if(empty($err_form)) */
            
           else{
                   $url = "profile.php";
                   $msg = $err_form;
                   redirectHome($msg,$url);
                   }
                }/* if($item_member[0]['member_id'] == $_SESSION['id']) */
                else{
                      $msg = "<div class='alert alert-danger'>It Seems That This Item Doesn't Belong To You</div>";
                      $url = "profile.php";
                      redirectHome($msg,$url);                   
                }
            } /* if ($count > 0) */
            else{
                $errormsg = "<div class='alert alert-danger'>There Is No Such Id</div>";
                $url      = "profile.php";
                redirectHome($errormsg,$url);
            }

        }    /* end if($_SERVER['REQUEST_METHOD'] == 'POST') */ 
        
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
        
    }/************* end of updateads page *************/
    
    /**************** start  delete page ************/
    elseif($action == 'deleteads'){

          if(isset($_GET['id']) && is_numeric($_GET['id'])){
               $itemid = intval($_GET['id']);
          }
          else{
          $itemid = 0;
          }  
        
          $count = checkItem('id','items',$itemid);
          if ($count > 0){ 
                $item_member = getItem('member_id', 'items','id', $itemid); // check if the ad belongs to this member
                if($item_member[0]['member_id'] == $_SESSION['id']){
                      $img_old  = getItem('image', 'items', 'id', $itemid);
                      $old_path ='uploads/product-img/';
                      unlink($old_path.$img_old[0]['image']);

                      $stmt = $con->prepare("delete from items where id = ?");
                      $stmt->execute(array($itemid));

                      $msg = "<div class='alert alert-success' role='alert'> $count record Deleted </div>";
                      $url = "profile.php";
                      redirectHome($msg,$url);      
                  }
              else{
                      $msg = "<div class='alert alert-danger'>It Seems That This Item Doesn't Belong To You</div>";
                      $url = "profile.php";
                      redirectHome($msg,$url);               
              }
           } /* end  if ($count > 0) */
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid userid *************/
        
    }/************* end of delete page *************/
?>
<?php
include $tpl."footer.php";
} // end if for $_SESSION
else{
    header('Location: login.php');
    exit();
}

ob_end_flush();
?>















