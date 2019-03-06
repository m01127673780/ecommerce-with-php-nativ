<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $title = "Items";
  include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if($action == 'manage'){    
              $stmt = $con->prepare("select items.*, categories.name as cat_name, users.username from items
                                    inner join categories on categories.id = items.cat_id
                                    inner join users on users.userid = items.member_id
                                    order by id desc");
              $stmt->execute();
              $items = $stmt->fetchAll();  
    ?>
   
      <h1 class="text-center">Manage Items</h1>
    <div class="container">
    <div class="table-responsive">
      <table class="main-table table table-bordered text-center">
      <thead>
        <tr>
          <th scope="col">#ID</th>
          <th scope="col">image</td>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">Adding Date</th>
          <th scope="col">Category</th>
          <th scope="col">Username</th>
          <th scope="col">Control</th>
        </tr>
      </thead>
      <tbody>
      <?php
           foreach($items as $row){              
           echo "<tr>";
               echo "<td>".$row['id']."</td>";
                /*-----------------------------------*/
           echo "<td class='td-image'>" ;
                  echo "<img src='../uploads/product-img/".$row['image']."' alt='img-mmber'/>";
          echo"</td>";
               /*-----------------------------------*/
/*

echo"<td>";
if(! empty( $avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){
                  $formErrors[]  ='This Extension Is Not Allow    </div>  '; }



          if(empty($row['avatar']) && empty($row['avatar']) ){
            echo "<img src='img/img-member-defult.png' alt='img-mmber'/>";
           }else{
                  echo "<img src='uploads/avatars/".$row['avatar']."' alt='img-mmber'/>";

           }
           
          echo"</td>";
*/

               /*-----------------------------------*/

               echo "<td>".$row['name']."</td>";
               echo "<td><span class='desc'>".$row['description']."</span></td>";
               echo "<td>".$row['price']."</td>";
               echo "<td>".$row['date']."</td>";
               echo "<td>".$row['cat_name']."</td>";
               echo "<td>".$row['username']."</td>";
               echo "<td class='control text-center'> 
                          <a href='?action=edit&id=" .$row['id']. "' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a>
                          <a href='?action=delete&id=" .$row['id']. "' class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>
                          <a href='comments.php?id=" .$row['id']. "' class='btn btn-primary'><i class='fas fa-comments dash'></i></i>Comments</a>";  
                echo "</td>";
            echo"</tr>";   
               
      }
      ?>
</tbody>
</table>
</div>
     <a href="?action=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a><br><br>
</div><!-- end of container -->
    <?php  
      }/************* end of manage page *************/
    
        
     /************* start add page *************/ 
     elseif($action == 'add'){
     ?>
      <h1 class="text-center">Add New Item</h1>
       <div class="container">
        <form action="?action=insert" method="post" enctype="multipart/form-data">
          <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" 
                         id="name" placeholder="Name Of The Item" minlength="3" required />
                </div>
          </div>     
                      <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" 
                         id="name" placeholder="Description Of The Item" minlength="12" required />
                </div>
                </div>
                               <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Price</label>
                <div class="col-sm-10 col-md-6">
                  <input type="number" name="price" class="form-control" 
                         id="name" placeholder="Price Of The Item" required />
                </div>
                </div>
                               <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Country</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="country" class="form-control" 
                          placeholder="Country Of The Item" minlength="3" required />
                </div>
                </div>
                
                <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Product Image All</label>
                <div class="col-sm-10 col-md-6">
                  <input type="file" name="img []"  class="form-control" multiple="multiple" required />
                </div>
                </div>
                        <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Status</label>
                <div class="col-sm-10 col-md-6">
                <select name="status" required>
                    <option value="">...</option> 
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Old</option>
                </select>
                </div>
                </div>
            
                            <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Member</label>
                <div class="col-sm-10 col-md-6">
                <select name="member" required>
                    <option value="">...</option> 
                 <?php
                   $stmt = $con->prepare("select * from users where permissionid != 1");
                   $stmt->execute();
                   $users = $stmt->fetchAll();
                   foreach($users as $row){
                       echo "<option value='" .$row['userid']. "'>" .$row['username']. "</option>";
                   }
                    
                ?>
                </select>
                </div>
                </div>
            
                                         <div class="form-group row">
                <label class="col-sm-2 col-form-label form" >Categories</label>
                <div class="col-sm-10 col-md-6">
                <select name="categories" required>
                    <option value="">...</option> 
                 <?php
                   $stmt = $con->prepare("select * from categories");
                   $stmt->execute();
                   $cats = $stmt->fetchAll();
                   foreach($cats as $row){
                       echo "<option value='" .$row['id']. "'>" .$row['name']. "</option>";
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
        
    }/************* end of add page *************/
    
        /*************** start insert page *****************/
    elseif($action == 'insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name          = $_POST['name'];
            $description   = $_POST['description'];
            $price         = $_POST['price'];
            $country       = $_POST['country'];
            $status        = $_POST['status'];
            $member_id     = $_POST['member'];
            $cat_id        = $_POST['categories'];
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
             
               
            if(strlen($name) < 3){
                $err_form[] = 'Item Name Must Be At Least 3 Characters';
            }
            if(strlen($description) < 1){
                $err_form[] = 'Item description Must Be At Least 12 Characters';
            }
            if(strlen($country) < 3){
                $err_form[] = 'Country Must Be At Least 3 Characters';
            }   
            if(empty($price)){
                $err_form[] = 'Price Can\'t Be Not Empty';
            }
            if(empty($status)){
                $err_form[] = 'Status Can\'t Be Not Empty';
            }
            if(empty($member_id)){
                $err_form[] = 'Member Can\'t Be Not Empty';
            }
            if(empty($cat_id)){
                $err_form[] = 'Categories Can\'t Be Not Empty';
            } 



            if(empty($_FILES['img']['name'])){
                $err_form[] = 'You Should Upload Image';
            }
                
         if(!empty($err_form)){

                   $url = "item.php?action=add";
                   $msg = $err_form;
                   redirectHome($msg,$url);
         }

        else{      
                  $img_name = rand(0,1000000)."_".$img_name;
                  $path = '../uploads/product-img/'.$img_name;
                  move_uploaded_file($img_tmp, $path);
            
                  $stmt = $con->prepare("insert into items(name, description, price, country_made, status,
                  member_id, cat_id, image, date) values(?,?,?,?,?,?,?,?,now())");
                  $stmt->execute(array($name, $description, $price, $country, $status,$member_id,$cat_id,$img_name));
                  $count = $stmt->rowCount();
                   
                  $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                  $url = "item.php";
                  redirectHome($msg,$url); 
                
        }   // end else for if !empty($err_form)

          
        }
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
    }   /********** end of insert page ***********/
    
           /************* start edit page *************/
    elseif($action == 'edit'){ 
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
    ?>
       <h1 class="text-center">Edit Item</h1>
       <div class="container">
        <form action="?action=update" enctype="multipart/form-data" method="post">
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
                <label class="col-sm-2 col-form-label form" >Member</label>
                <div class="col-sm-10 col-md-6">
                <select name="member">
                 <?php
                   $stmt = $con->prepare("select * from users");
                   $stmt->execute();
                   $users = $stmt->fetchAll();
                   foreach($users as $user){
                       echo "<option value='" .$user['userid']. "'";
                       if($row['member_id']==$user['userid']) echo "selected";
                       echo ">" .$user['username']. "</option>";
                   }
                    
                ?>
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
        }/************* end if for checking if there is a valid itemid *************/
        else{
                $msg = "<div class='alert alert-danger'>there is no such id</div>";
                redirectHome($msg);
        }
        
      } /************* end of edit page *************/
    
            /************* start update page *************/
    elseif($action == 'update'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $item_id       = $_POST['item_id'];
            $name          = $_POST['name'];
            $description   = $_POST['description'];
            $price         = $_POST['price'];
            $country       = $_POST['country'];
            $status        = $_POST['status'];
            $member_id     = $_POST['member'];
            $cat_id        = $_POST['categories'];
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
 
            if(strlen($name) < 3){
                $err_form[] = 'Item Name Must Be At Least 3 Characters';
            }
            if(strlen($description) < 1){
                $err_form[] = 'Item description Must Be At Least 12 Characters';
            }
            if(strlen($country) < 3){
                $err_form[] = 'Country Must Be At Least 3 Characters';
            }   
            if(empty($price)){
                $err_form[] = 'Price Can\'t Be Not Empty';
            }
            if(empty($status)){
                $err_form[] = 'Status Can\'t Be Not Empty';
            }
            if(empty($member_id)){
                $err_form[] = 'Member Can\'t Be Not Empty';
            }
            if(empty($cat_id)){
                $err_form[] = 'Categories Can\'t Be Not Empty';
            } 
            
           if(empty($err_form)){
                    if(!empty($_FILES['img']['name'])){
                        $img_name = rand(0,1000000)."_".$img_name;
                        $path = '../uploads/product-img/'.$img_name;
                        move_uploaded_file($img_tmp, $path);
                        
                        $img_old  = getItem('image', 'items', 'id', $item_id);
                        $old_path ='../uploads/product-img/';
                        unlink($old_path.$img_old[0]['image']);


                        $stmt = $con->prepare("update items set name = ?, description = ?, price = ?,
                        country_made = ?, status = ?, member_id = ?, cat_id = ?, image = ? where id = ?");
                        $stmt->execute(array($name,$description,$price,$country,$status,$member_id,$cat_id,
                                             $img_name,$item_id));
                        $count = $stmt->rowCount();

                        $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                        $url = "item.php";
                        redirectHome($msg,$url);
                        }
                    else{
                        $stmt = $con->prepare("update items set name = ?, description = ?,  price = ?,
                        country_made = ?, status = ?, member_id = ?, cat_id = ? where id = ?");
                        $stmt->execute(array($name,$description,$price,$country,$status,$member_id,$cat_id,$item_id));
                        $count = $stmt->rowCount();

                        $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                        $url = "item.php";
                        redirectHome($msg,$url);                     
                        }
                } /* end if(empty($err_form)) */
            
           else{
                   $url = "item.php";
                   $msg = $err_form;
                   redirectHome($msg,$url);
                   }

        }     
        
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
        
    }/************* end of update page *************/
    
        /**************** start  delete page ************/
    elseif($action == 'delete'){

          if(isset($_GET['id']) && is_numeric($_GET['id'])){
               $itemid = intval($_GET['id']);
          }
          else{
          $itemid = 0;
          }  
        
          $count = checkItem('id','items',$itemid);
          if ($count > 0){  
              $img_old  = getItem('image', 'items', 'id', $itemid);
              $old_path ='../uploads/product-img/';
              unlink($old_path.$img_old[0]['image']);
              
              $stmt = $con->prepare("delete from items where id = ?");
              $stmt->execute(array($itemid));

              $msg = "<div class='alert alert-success' role='alert'> $count record Deleted </div>";
              $url = "item.php";
              redirectHome($msg,$url);      
          } 
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid userid *************/
        
    }/************* end of delete page *************/
    
    include $tpl . 'footer.php';
  }
    else {
    header('Location: login.php');
    exit();
  }
  ob_end_flush();
?>