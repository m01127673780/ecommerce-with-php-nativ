<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $title = "comments";
	include "init.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    
    
    /************* start manage page *************/
    if($action == 'manage'){
      $item_id = isset($_GET['id']) ? $_GET['id'] : null;
      $query =  $item_id != null ? "where item_id = $item_id" : null;
      $stmt = $con->prepare("select comments.*, items.name, users.username from comments
                             inner join items on items.id = comments.item_id
                             inner join users on users.userid = comments.user_id
                             $query order by id desc");
      $stmt->execute();
      $rows = $stmt->fetchAll();  
    ?>
   
  <h1 class="text-center">Manage Comments</h1>
<div class="container">
<div class="table-responsive">
  <table class="main-table table table-bordered text-center">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Comment</th>
      <th scope="col">Item Name</th>
      <th scope="col">Username</th>
      <th scope="col">Date</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  <tbody>
      <?php
           foreach($rows as $row){              
           echo "<tr>";
               echo "<td>".$row['id']."</td>";
               echo "<td>".$row['comment']."</td>";
               echo "<td>".$row['name']."</td>";
               echo "<td>".$row['username']."</td>";
               echo "<td>".$row['date']."</td>";
               echo "<td class='control text-center'> 
                          <a href='?action=edit&id=" .$row['id']. "' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a>
                          <a href='?action=delete&id=" .$row['id']. "' class='btn btn-danger confirm'><i class='fas fa-times'></i>Delete</a>"; 
                echo "</td>";
            echo"</tr>";   
               
      }
      ?>
</tbody>
</table>
</div>
</div><!-- end of container --><br><br> 
    <?php  
      }/************* end of manage page *************/
    
           /************* start edit page *************/
    elseif($action == 'edit'){ 
      if(isset($_GET['id']) && is_numeric($_GET['id'])){
          $id = intval($_GET['id']);
      }
      else{
          $id = 0;
      }   
    $stmt = $con->prepare("select * from comments where id = ? limit 1");
  	$stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0){
    ?>
       <h1 class="text-center">Edit Comment</h1>
       <div class="container edit-comment">
        <form action="?action=update" method="post">
          <input type="hidden" name="id" value="<?php echo $id;?>" />    

                      <div class="form-group row">
            <label class="col-sm-2 col-form-label form" >Comment</label>
            <div class="col-sm-10 col-md-6">
                <textarea class="form-control" name="comment" required><?php echo $row['comment'];?></textarea>
            </div>
          </div>
            <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 ">
              <input type="submit" class="btn btn-primary btn-lg" value="save" />
                </div>

        </div>
        </form>

      <?php
        }/************* end if for checking if there is a valid id *************/
        else{
                $msg = "<div class='alert alert-danger'>there is no such id</div>";
                redirectHome($msg);
        }
        
      } /************* end of edit page *************/
    
        /************* start update page *************/
    elseif($action == 'update'){         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id     = $_POST['id'];
            $comment   = $_POST['comment'];
                        
            if(empty($comment)){
               $error = '';
               echo "you shouldn't leave comment empty";
            }

         if(!isset($error)){
                $stmt = $con->prepare("update comments set comment = ? where id = ?");
                $stmt->execute(array($comment,$id));
                $count = $stmt->rowCount();
                
                $msg = "<div class='alert alert-success' role='alert'> $count record updated</div>";
                $url = "comments.php";
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
               $id = intval($_GET['id']);
          }
          else{
          $id = 0;
          }  
        
          $count = checkItem('id','comments',$id);
          if ($count > 0){         
              $stmt = $con->prepare("delete from comments where id = ?");
              $stmt->execute(array($id));

              $msg = "<div class='alert alert-success' role='alert'> $count record Deleted </div>";
              $url = "comments.php";
              redirectHome($msg,$url);      
          } 
        else{
            $msg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($msg);
        }/************* end if for checking if there is a valid id *************/
        
   }/************* end of delete page *************/
    
    include $tpl . 'footer.php';
  }
    else {
		header('Location: login.php');
		exit();
	}
	ob_end_flush();
?>