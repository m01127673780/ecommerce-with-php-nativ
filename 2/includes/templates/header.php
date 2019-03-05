<!DOCTYPE html>
<html>
     <head>
	      <meta charset="utf-8" />
	      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	      <title><?php echo showTitle(); ?></title>
	      <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
          <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
          <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.exzoom.css" />
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	      <link rel="stylesheet" href="<?php echo $css; ?>style.css" />
	      <link rel="icon" href="<?php echo $img;?>img2.png" type="image/png" sizes="16x16">
     </head>
     <body>
         <div class="upperbar bg-white">
         <div class="container">
           <div class="upper">
<!-- Example single danger button -->

            <?php 
               if(isset($_SESSION['name'])){
            ?>
               <img src="<?php echo $img;?>img.png" class="rounded-circle img-thumbnail" />
            <div class="btn-group">
                  <span  class="dropdown-toggle name btn btn-light" data-toggle="dropdown" aria-expanded="true">
                    <?php echo $_SESSION['name']?>
                  </span>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="newad.php">New Ad</a>
                      <a class="dropdown-item" href="profile.php#ads">My Ads</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
            </div> <!-- end of btn-group-->          
               <?php
              }
               else
               {
            ?>
             <div style="overflow:hidden"><a href="login.php" class="float-right">Login/Signup</a></div>
           <?php
               }
           ?>
                  
               
          </div>
         </div>
         </div> <!-- end of upperbar -->
    