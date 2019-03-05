<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $title = "dashboard";
  include "init.php";
?>
<div class="container home-stats text-center">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="stat st-member">
                Total Members  
                    <span><a href="member.php"><?php echo countItem('userid','users');?></a></span>
            </div>
              <i class="fas fa-users dash"></i>
        </div> <!-- end of class col-md-3 -->
        <div class="col-md-3">
            <div class="stat st-pending">Pending Members
            <span><a href="member.php?activate=pending"><?php echo checkItem('regstatus','users','0');?></a></span>
            </div>
            <i class="fas fa-user-plus dash"></i>
        </div>  <!-- end of class col-md-3 -->
        <div class="col-md-3">
            <div class="stat st-item">Total Items
            <span><a href="item.php"><?php echo countItem('id','items');?></a></span>
            </div>
            <i class="fas fa-tag dash"></i>
        </div>  <!-- end of class col-md-3 -->
        <div class="col-md-3">
            <div class="stat st-comment">Total Comments
                <span><a href="comments.php"><?php echo countItem('id','comments');?></a></span>
            </div>
            <i class="fas fa-comments dash"></i>
        </div>



        <div class="col-md-4">
            <div class="stat st-member Add-st-member">
                Add Members  
                    <span><a href="member.php?action=add"><span><a href="member.php?action=add"> <i class="fas fa-plus"></i></a></span></a></span>
            </div>
              <i class="fas fa-user  dash"></i>
        </div> <!-- end of class col-md-4 -->
        <div class="col-md-4">
            <div class="stat st-item Add-st-item">
                Add Item  
                    <span><a href="item.php?action=add"><span><a href="item.php?action=add"> <i class="fas fa-plus"></i></a></span></a></span>
            </div>
              <i class="fas fa-tag   dash"></i>
        </div> <!-- end of class col-md-4 -->
        <div class="col-md-4">
            <div class="stat Add-st-categories">
                Add categories  
                    <span><a href="categories.php?action=add"><span><a href="categories.php?action=add"> <i class="fas fa-plus"></i></a></span></a></span>
            </div>
              <i class="fas fa-tags   dash"></i>
        </div> <!-- end of class col-md-4 -->




    </div>
</div> <!-- End of container -->


<div class="container-fluid latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                    <?php 
                     $num_latest = 7;
                     $latest_users = getLatest('*', 'users', 'userid', $num_latest);
                     $latest_items = getLatest('*', 'items', 'id', $num_latest);
                     $latest_comments = getLatest('*', 'comments', 'user_id', $num_latest);
                   ?>
                    <i class="fas fa-users"></i> Latest <?php echo $num_latest;?> Registered Users
                   <span class="float-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="card-body">
                  <ul class="list-unstyled latest-users">
                  <span class="card-text ">
                      <?php
                         foreach($latest_users as $row){
                             $userid = $row['userid'];
                             $regstatus = $row['regstatus'];
                             echo "<li>".$row['username']."<a href='member.php?action=edit&userid=$userid' class='btn btn-success float-right'>
                             <i class='fas fa-edit'></i>Edit</a>";
                             if ($regstatus == 0){
                               echo "<a href='member.php?action=activate&userid=" .$userid. "' class='btn btn-info activate float-right'>
                               <i class='fas fa-edit'></i>Activate</a>";
                          }
                          echo "</li>";
                             
                         }  
                      ?>  
                  </span>  
                  </ul>
              </div>  <!-- end of div card-body-->
            </div>
        </div>
        <!--
    <div class="col-sm-6">
        <div class="card">
              <div class="card-header">
                   <i class="fas fa-tag"></i> Latest <?php echo $num_latest;?> Items
                   <span class="float-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="card-body">
                <ul class="list-unstyled latest-users">
                  <span class="card-text ">
                      /*<?php
                         foreach($latest_comments as $row){
                             //$id = $row[' user_id'];
                             echo "<li>".$row['comment']."<a href='item.php?action=edit&id=$id' class='btn btn-success float-right'>
                                   <i class='fas fa-edit'></i>Edit</a>";
                             echo "</li>";    
                         }  
                      ?>  */
                  </span>  
                  </ul> 
              </div>
        </div>
    </div>
    </div>
</div> <!-- End of container -->
    <div class="col-sm-6">
        <div class="card">
              <div class="card-header">
                   <i class="fas fa-tag"></i> Latest <?php echo $num_latest;?> items
                   <span class="float-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="card-body">
                <ul class="list-unstyled latest-users">
                  <span class="card-text ">
                      <?php
                         foreach($latest_items as $row){
                             $id = $row['id'];
                             echo "<li>".$row['name']."<a href='item.php?action=edit&id=$id' class='btn btn-success float-right'>
                                   <i class='fas fa-edit'></i>Edit</a>";
                             echo "</li>";    
                         }  
                      ?>  
                  </span>  
                  </ul> 
              </div>
        </div>
    </div>
    </div>
</div> <!-- End of container -->

    
<?php    
    include $tpl."footer.php";
}

else{
  header('location: index.php');
  exit();
}
ob_end_flush();
?>