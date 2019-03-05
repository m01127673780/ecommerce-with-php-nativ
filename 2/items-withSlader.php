 

<?php
ob_start();
session_start();
$title = 'show items';
include "init.php";
?>
<?php
      if(isset($_GET['id']) && is_numeric($_GET['id'])){
          $item_id = intval($_GET['id']);
      }
      else{
          $item_id = 0;
      }   
              $stmt = $con->prepare("select items.*, categories.name as cat_name, users.username from items
                                    inner join categories on categories.id = items.cat_id
                                    inner join users on users.userid = items.member_id
                                    where items.id=?");
  	 $stmt->execute(array($item_id));
     $count = $stmt->rowCount();
     if ($count > 0){
          $item = $stmt->fetch();
    ?>
    <div class="container item-info">
    <h1 class="text-center"><?php echo $item['name'];?></h1>
                <?php
                          if($_SERVER['REQUEST_METHOD'] == "POST"){
                          $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                          $userid  = $_SESSION['id'];
                          if(!empty($comment)){
                              $stmt = $con->prepare("insert into comments(comment,date,item_id,user_id) values (?,now(),?,?)");
                              $stmt->execute(array($comment, $item_id, $userid));
                              $count = $stmt->rowCount();
                              if($count>0){
                                  $msg = "<div class='alert alert-success'>The Comment Is Added</div>";
                                  $url = "items.php?id=".$item_id;
                                  redirectHome($msg, $url);
                              } 
                          }
                          else{
                                  $msg = "<div class='alert alert-danger'>No Comment Added</div>";
                                  $url = "items.php?id=".$item_id;
                                  redirectHome($msg, $url); 
                                    }
                      }
                ?>
                <style type="text/css">
                  
                .image-slider  {
                  display: inline-block;
    height: 50px;
    width: 55px;
    margin-top: 20px;
     margin: 0 2px;
    border: 1px solid #404055;
                  }
                </style>
        <div class="row item">
            <div class="col-md-3">
                <?php
                 $path = 'uploads/product-img/';
                 
                ?>
                <img src="<?php echo $path.$item['image'];?>" class="img-responsive img-thumbnail mx-auto d-block"/>
                         <!-- <h2><?php echo  $arr;?></h2> -->
                        <?php
                 $str = $item['images'];   
                 $arr = explode(',', $str , -1);
 
                 // print_r($arr);
                 for ($i = 0; $i <count($arr); $i++){
// echo '<pre>';
// print_r($arr);  

// echo '</pre>';
                  // echo '<link rel="stylesheet"  href="css/"'.$arr [$i].'"/>';
                  echo '<img   class="image-slider"  src="uploads/product-img/'.$arr [$i].'" /> ';
                  // echo '<img class ="img-responsive img-thumbnail mx-auto d-block"  src="uploads/product-img/ '.$arr [$i].'"/>';
                  }
                  // @include 'demo/index.html';
 
                        ?> 



 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Carousel Example</h2>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="https://mobirise.com/bootstrap-carousel/assets/images/multiple-items-600x600.jpg" alt="Los Angeles" style="width:100%;">
      </div>

 
    
      <div class="item">
        <img src="https://mobirise.com/bootstrap-carousel/assets/images/multiple-items-600x600.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>

      

            </div>
            <div class="col-md-9">
                <h2><?php echo $item['name'];?></h2>
                <p><?php echo $item['description'];?></p>
                <ul class="list-unstyled ">
                    <li>
                        <i class="far fa-calendar-alt"></i>
                        <span>Added Date </span>: <?php echo $item['date'];?>
                    </li>
                    <li>
                        <div>
                            <i class="fas fa-money-check-alt money"></i>
                            <span>Price</span>: $<?php echo $item['price'];?>
                        </div>
                    </li>     
                     <li>
                        <div>
                            <i class="fas fa-money-check-alt money"></i>
<!--                             <span>Price</span>:  <?php echo $arr;?>
 -->                        </div>
                    </li>
                    <li>
                        <div>
                            <i class="fas fa-globe"></i><span>Made In</span>: <?php echo $item['country_made'];?>
                        </div>
                    </li>
                    <li>
                        <div>
                            <i class="far fa-hand-point-right"></i><span>Status</span>: 
                            <?php 
                                if($item['status'] == 1)        echo "New";
                                elseif($item['status'] == 2)    echo "Like New";
                                elseif($item['status'] == 3)    echo "Used";
                                elseif($item['status'] == 4)    echo "Old";
                            
                            ?>
                        </div>
                    </li>                    
                    <li>
                        <div>
                            <i class="fas fa-tags"></i><span> Category</span>:
                            <a href="categories.php?id=<?php echo $item['cat_id'];?>&name=<?php echo $item['cat_name'];?>">
                                <?php echo $item['cat_name'];?>
                            </a> 
                        </div>
                    </li>
                    <li>
                        <div>
                            <i class="far fa-user"></i><span>Added By</span>:
                            <a href="#"><?php echo $item['username'];?></a> 
                        </div>
                    </li>
                </ul>
            </div>
        </div> <!-- end of row -->
        <hr>
        <?php if(isset($_SESSION['name'])){ ?>
        <div class="row">  
            <div class="offset-md-3">
                <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form action="items.php?id=<?php echo $item_id;?>" method="post">
                        <textarea name="comment" required></textarea>
                        <input type="submit" class="btn btn-primary" value="submit" />
                    </form>
                </div>  <!-- end add-comment class -->
            </div>  
        </div>
        <?php }
           else{
               echo "Please <a href='login.php'>Login</a> To Add Comment";
           }
        ?>
        <hr>
                <?php
                   $stmt = $con->prepare("select comments.*, users.username from comments
                                          inner join users on users.userid = comments.user_id
                                          where item_id = ? order by id desc");
                   $stmt->execute(array($item_id));
                   $comments  = $stmt->fetchAll(); 
                   $count = $stmt->rowCount();
                   if($count>0){
                   foreach($comments as $comment){
                    ?>
                    <div class="comment-box">
                           <div class="row">
                               <div class="col-sm-2 text-center">
                                   <img src="<?php echo $img;?>img.png" class="img-thumbnail rounded-circle d-block mx-auto"/>
                                   <?php echo $comment['username']?>
                               </div>
                               <div class="col-sm-10">
                                   <p><?php echo $comment['comment']?></p>
                               </div>
                           </div>
                           <hr/>
                    </div> <!-- end of comment-box -->

                         <?php
                           }
                        } /* end if($count>0) */
                   else{
                        echo "<div class='empty'> There Is No Comment To Show </div>";
                     }
                        ?>
    </div><!-- end of container -->
        <?php

         }  /* end if $count > 0 */
         else{
                    $msg = "<div class='alert alert-danger'>there is no such id</div>";
                    redirectHome($msg);
            }
        ?>
<?php
include $tpl."footer.php";
ob_end_flush();
?>