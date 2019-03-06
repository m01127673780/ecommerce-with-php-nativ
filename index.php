<?php
ob_start();
session_start();
$title = 'Home';
include "init.php";
?>
<div id="ads" class="ads">
  <div class="container items home">
    <div class="row">
      <?php
      $items = getALL('*', 'items', 'id');
      $path = 'uploads/product-img/';
      foreach($items as $item){
      echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
        echo "<div class='card'>";
          echo "<span class='price-tag'>$". $item['price'] ."</span>";
          echo "<a href='items.php?id=".$item['id']."'>
            <div class='back-img'>
              <img src='".$path.$item['image']."' class='  img-fluid img-responsive d-block                                                                            mx-auto'>
            </div>
          </a>";
          
          echo "<div class='card-body'>";
            echo "<span class='details'>";
              echo "<h3 class='card-title'><a href='items.php?id=".$item['id']."'>" .$item['name']. "</a></h3>";
              echo "<div class='card-text'>";
                echo "<p>".$item['description']."</p>";
              echo "</div>";
            echo "</span>";
            echo "<div class='card-text'>";
              echo "<div class='date text-right'>".$item['date']."</div>";
            echo "</div>";/* end card-text */
          echo "</div>";
        echo "</div>";/* end card*/
      echo "</div>"; /* end of col */
      }
      ?>
    </div>
  </div>
  </div> <!-- end of ads-->
  <?php
  include $tpl."footer.php";
  ob_end_flush();
  ?>