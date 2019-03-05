<?php
ob_start();
session_start();
if(isset($_SESSION['name'])){
$title = 'New Ad';
include "init.php";
    
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name          = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price         = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country       = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $status        = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $cat_id        = filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
        $member_id     = $_SESSION['id'];
        $form_errors = array();
        if(!empty($_FILES['img']['name'])){
            $img_name      = $_FILES['img']['name'];
            $img_type      = $_FILES['img']['type'];
            $img_size      = $_FILES['img']['size'];
            $img_tmp       = $_FILES['img']['tmp_name'];
            $img_allow_extension = array('jpg','jpeg','png','gif');
            $img_extension = explode('.',$img_name);
            $img_extension = end($img_extension);
            if(!empty($img_name) && !in_array($img_extension,$img_allow_extension)){
                $form_errors[] = 'This Extension Isn\'t Allowed ';
            }
            if($img_size > 4194304){
                $form_errors[] = 'Image Size Can\'t be more than 4 M.B';     
            }
        }
    
    
        if(strlen($name) < 3){
            $form_errors[] = 'Item Name Must Be At Least 3 Characters';
        }
        if(strlen($description) < 12){
            $form_errors[] = 'Item description Must Be At Least 12 Characters';
        }
        if(strlen($country) < 3){
            $form_errors[] = 'Country Must Be At Least 3 Characters';
        }
        if(empty($price)){
            $form_errors[] = 'Price Can\'t Be Empty';
        }
        if(empty($status)){
            $form_errors[] = 'Status Can\'t Be Empty';
        }
        if(empty($cat_id)){
            $form_errors[] = 'Categories Can\'t Be Empty';
        } 
        if(empty($_FILES['img']['name'])){
            $form_errors[] = 'You Should Upload Image';
        }
        if(empty($form_errors)){
            
                $img_name = rand(0,1000000)."_".$img_name;
                $path = 'uploads/product-img/'.$img_name;
                move_uploaded_file($img_tmp, $path);
            
                $stmt = $con->prepare("insert into items(name, description, price, country_made, status,
                member_id, cat_id, image, date) values(?,?,?,?,?,?,?,?,now())");
                $stmt->execute(array($name, $description, $price, $country, $status,$member_id,$cat_id,$img_name));
                $count = $stmt->rowCount();

                $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                $url = "profile.php#ads";
                redirectHome($msg,$url);
        }
}
?>
<h1 class="text-center">Create New Ad</h1>

<div class="newads ">
    <div class="container">
        <?php
             if(!empty($form_errors)){
                    $url = "newad.php";
                    $msg = $form_errors;
                    redirectHome($msg,$url);
                }
        ?>
        <div class="card">
            <div class="card-header bg-primary text-white">Create New Ad</div>
            <div class="card-body">
                <div class="card-text">
                       <div class="row">
                           <div class="col-md-8">
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post" class="main-form">
                                      <div class="form-group row">
                                            <label class="col-sm-3 col-form-label form" >Name</label>
                                            <div class="col-sm-9">
                                              <input type="text" name="name" class="form-control live-name" 
                                                     id="name" placeholder="Name Of The Item" minlength="3" required />
                                            </div>
                                      </div>     
                                                  <div class="form-group row">
                                            <label class="col-sm-3 col-form-label form my-auto" >Description</label>
                                            <div class="col-sm-9">
                                              <textarea name="description" class="form-control live-desc" 
                                                        id="name"  minlength="12" placeholder="descripe your item" required ></textarea>
                                            </div>
                                            </div>
                                                           <div class="form-group row">
                                            <label class="col-sm-3 col-form-label form" >Price</label>
                                            <div class="col-sm-9">
                                              <input type="number" name="price" class="form-control live-price" 
                                                     id="name" placeholder="Price Of The Item"  required/>
                                            </div>
                                            </div>
                                                           <div class="form-group row">
                                            <label class="col-sm-3 col-form-label form" >Country</label>
                                            <div class="col-sm-9">
                                              <input type="text" name="country" class="form-control" 
                                                      placeholder="Country Of The Item" minlength="3" required />
                                            </div>
                                            </div>
                                           <div class="form-group row">
                                            <label class="col-sm-3 col-form-label form" >Product Image</label>
                                            <div class="col-sm-9">
                                              <input type="file" name="img" class="form-control" required/>
                                            </div>
                                            </div>
                        <div class="form-group row">
                <label class="col-sm-3 col-form-label form" >Status</label>
                <div class="col-sm-9">
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
                                            <label class="col-sm-3 col-form-label form" >Categories</label>
                                            <div class="col-sm-9">
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
                                        <div class="offset-sm-3 col-sm-9">
                                          <input type="submit" class="btn btn-primary btn-lg" value="save" />
                                            </div>

                                    </div>
                                </form>
                           </div>  <!-- end div col-md-8 -->
                           
                           
                           <div class="col-md-4">
                               <div class='card items card-show'>
                                    <span class="price-tag">$<span class='price'>0</span></span>
                                    <!--<img src='img6.png' class='card-img-top img-thumbnail img-responsive
                                                               d-block mx-auto def-img'> -->
                                   <i class="fas fa-dollar-sign def"></i>
                                   
                                    <div class='card-body'>
                                          <h3 class='card-title'>name</h3>
                                          <p class='card-text'>description</p>
                                    </div>

                               </div>
                           </div> <!-- end div col-md-4 -->

                       </div><br>  <!-- end row div-->
                                               

                </div>
            </div> <!-- end card-body div-->
        </div> <!-- end card div--><br> 
    </div> <!-- end container div-->
</div> <!-- end newads div--><br><br>


   




<?php
include $tpl."footer.php";
}
else{
    header('Location: login.php');
    exit();
}
ob_end_flush();
?>