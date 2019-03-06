<?php
ob_start();
session_start();
$title = "Categories";
if(isset($_SESSION['username'])){
    $title = "categories";
	include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    if($action == 'manage'){
        $sort = 'asc';
        $sortarr = array('asc','desc');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sortarr)){
            $sort = $_GET['sort'];
        }
        $stmt = $con->prepare("select * from categories order by ordering $sort");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
?>



















 <h1 class="text-center">Manage Categories</h1>
 




<!-- ================================================================ -->





<div class="container">
<div class="table-wrap cat-hiddin-table""><!--  style="display: none; -->
  <table class="table table-striped main-table table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">name</th>
      <th scope="col">description</th>
      <th scope="col">ordering</th>
      <th scope="col">control</th>
   
    </tr>
  </thead>
  <tbody>
      <?php
           foreach($categories as $row){              
           echo "<tr>";
               echo "<td>".$row['id']."</td>";
               echo "<td>".$row['name']."</td>";
               echo "<td>".$row['description']."</td>";
               echo "<td>".$row['ordering']."</td>";
               
               echo "<td class='control'>"; 
                echo "<a href='?action=edit&catid=" . $row['id'] . "' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i>   <span class= 'hiddin-in-768 '>Edit </span>  </a>";
                 echo "  "; 
                          echo "<a href='?action=delete&catid=" . $row['id'] . "' class='btn btn-sm btn-danger confirm'><i class='fas fa-times'></i><span class= 'hiddin-in-768 '> Delete </span> </a>  ";
                          echo "</div>";
                          echo' <a href="?action=add" class="btn btn-primary"><i class="fa fa-plus"></i>  </a>';

            echo"</tr>";   
               
      }
      ?>
</tbody>
</table>

</div>
     <a href="?action=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
</div><!-- end of container --><br><br>





<!-- ================================================================ -->










<?php
    } /************* end of manage page *************/
    
    
     /************* start add page *************/ 
     elseif($action == 'add'){
     ?>
      <h1 class="text-center">Add New Category</h1>
       <div class="container">
        <form action="?action=insert" method="post">
          <div class="form-group row">
                <label class="col-sm-2 col-form-label form" autocomplete="off">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" 
                         id="name" placeholder="Name Of The Category"required />
                </div>
          </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" placeholder="Description Of The Category" 
                         id="description"/>
                </div>
            </div>
          <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                  <input type="number" name="ordering" class="form-control" placeholder="number to arrange the category"
                         id="ordering"/>
                </div>
          </div>
             <div class="form-group row">
            <label class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10 col-md-6">
                  <input type='radio' id="yes" name="visibility" value="0" checked/>
                    <label for="yes">Yes</label><br>
                  <input type='radio' id='no' name="visibility" value="1" />
                    <label for="no">No</label>
            </div>
          </div>

             <div class="form-group row">
                <label  class="col-sm-2 col-form-label">Allow Comment</label>
                <div class="col-sm-10 col-md-6">
                      <input type='radio' id="com-yes" name="comment" value="0" checked/>
                        <label for="com-yes">Yes</label><br>
                      <input type='radio' id='com-no' name="comment" value="1" />
                        <label for="com-no">No</label>
                </div>
             </div> 
             <div class="form-group row">
                <label class="col-sm-2 col-form-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                      <input type='radio' id="ads-yes" name="ads" value="0" checked/>
                        <label for="ads-yes">Yes</label><br>
                      <input type='radio' id='ads-no' name="ads" value="1" />
                        <label for="ads-no">No</label>
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
            $name   = $_POST['name'];
            $description   = $_POST['description'];
            $order      = $_POST['ordering'];
            $visible   = $_POST['visibility'];
            $comment   = $_POST['comment'];
            $ads   = $_POST['ads'];
                

            if(empty($name)){
                $error = '';
           ?>
           <div class="container"><br><br>
           <div class="alert alert-danger" >username can't be less than 3 characters or more than 20 characters</div>
           </div>
           <?php
            }

         if(!isset($error)){
             
                $check = checkItem('name','categories',$name);
                if ($check > 0){
                    $msg = "<div class='alert alert-danger'>Sorry This Category is Exist Please Try Another Name</div>";
                    $url = "http://localhost/ecommerce/admin/categories.php";
                    redirectHome($msg,$url);
                }
                else{  
                    
                    $stmt = $con->prepare("insert into categories (name, description, ordering, visibility, allow_comment, allow_ads) 
                    values(?,?,?,?,?,?)");
                    $stmt->execute(array($name, $description, $order, $visible, $comment, $ads));
                    $count = $stmt->rowCount();
           
                   
                   $msg = "<div class='alert alert-success' role='alert'> $count record inserted </div>";
                   $url = "http://localhost/ecommerce/admin/categories.php?action=add";
                   redirectHome($msg,$url);
                   
          
                }
            
        }
            
        }
        else{
            $errormsg = "<div class='alert alert-danger'>you can't browse this page directly</div>";
            redirectHome($errormsg);
        }
    }   /********** end of insert page ***********/
    
           /************* start edit page *************/
    elseif($action == 'edit'){ 
      if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
          $catid = intval($_GET['catid']);
      }
      else{
          $catid = 0;
      }   
    $stmt = $con->prepare("select * from categories where id = ? ");
  	$stmt->execute(array($catid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0){
    ?>
             <h1 class="text-center">Edit Category</h1>
       <div class="container">
        <form action="?action=update" method="post">
            <input type="hidden" name="catid" value="<?php echo $row['id'];?>" /> 
          <div class="form-group row">
                <label class="col-sm-2 col-form-label form">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" 
                         id="name" placeholder="Name Of The Category" value ="<?php echo $row['name']; ?>" required />
                </div>
          </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" placeholder="Description Of The Category" 
                         id="description" value ="<?php echo $row['description']; ?>"/>
                </div>
            </div>
          <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                  <input type="number" name="ordering" class="form-control" placeholder="number to arrange the category"
                         id="ordering" value ="<?php echo $row['ordering']; ?>"/>
                </div>
          </div>
             <div class="form-group row">
            <label class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10 col-md-6">
                  <input type='radio' id="yes" name="visibility" value="0" <?php if($row['visibility']==0) echo 'checked'; ?>/>
                    <label for="yes">Yes</label><br>
                  <input type='radio' id='no' name="visibility" value="1" <?php if($row['visibility']==1) echo 'checked'; ?>/>
                    <label for="no">No</label>
            </div>
          </div>

             <div class="form-group row">
                <label  class="col-sm-2 col-form-label">Allow Comment</label>
                <div class="col-sm-10 col-md-6">
                      <input type='radio' id="com-yes" name="comment" value="0" <?php if($row['allow_comment']==0) echo 'checked';?>/>
                        <label for="com-yes">Yes</label><br>
                      <input type='radio' id='com-no' name="comment" value="1" <?php if($row['allow_comment']==1) echo 'checked';?>/>
                        <label for="com-no">No</label>
                </div>
             </div> 
             <div class="form-group row">
                <label class="col-sm-2 col-form-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                      <input type='radio' id="ads-yes" name="ads" value="0" <?php if($row['allow_ads']==0) echo 'checked'; ?>/>
                        <label for="ads-yes">Yes</label><br>
                      <input type='radio' id='ads-no' name="ads" value="1" <?php if($row['allow_ads']==1) echo 'checked'; ?> />
                        <label for="ads-no">No</label>
                </div>
             </div>       
            <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 ">
              <input type="submit" class="btn btn-primary btn-lg" value="save" />
                </div>

        </div>
        </form><br><br>


      <?php
        }/************* end if for checking if there is a valid userid *************/
        else{
                $msg = "<div class='alert alert-danger'>there is no such id</div>";
                $url = "categories.php";
                redirectHome($msg,$url);
        }
        
      } /************* end of edit page *************/
    
            /************* start update page *************/
    elseif($action == 'update'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id     = $_POST['catid'];
            $name   = $_POST['name'];
            $description   = $_POST['description'];
            $order      = $_POST['ordering'];
            $visibility   = $_POST['visibility'];
            $comment = $_POST['comment'];
            $ads = $_POST['ads'];
                        
            if(empty($name)){
               $error = '';
               echo "you shouldn't leave name empty";
            }

         if(!isset($error)){
                $stmt = $con->prepare("update categories set name = ?, description = ?, ordering = ?, visibility = ?, allow_comment = ?, allow_ads = ? where id = ?");
                $stmt->execute(array($name,$description,$order,$visibility,$comment,$ads,$id));
                $count = $stmt->rowCount();
                
                $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                $url = "categories.php";
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

          if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
               $id = intval($_GET['catid']);
          }
          else{
          $id = 0;
          }  
        
          $count = checkItem('id','categories',$id);
          if ($count > 0){         
              $stmt = $con->prepare("delete from categories where id = ?");
              $stmt->execute(array($id));

              $msg = "<div class='alert alert-success' role='alert'> $count record Deleted </div>";
              $url = "http://localhost/ecommerce/admin/categories.php";
              redirectHome($msg,$url);      
          } 
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid userid *************/
        
    }/************* end of delete page *************/
          
    include $tpl."footer.php";
}

else{
	header('location: index.php');
	exit();
}
ob_end_flush();
?>