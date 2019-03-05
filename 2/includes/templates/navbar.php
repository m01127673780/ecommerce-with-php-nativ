
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <a class="navbar-brand" href="index.php"><?php echo lang('Home');?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">

        <?php
            $cats = getRec('id,name', 'categories');
            foreach($cats as $cat ){
               echo "<li class='nav-item'>";
               echo "<a class='nav-link' href='categories.php?id=".$cat['id']."&name=".$cat['name']."'>" .$cat['name']. "</a>";
               echo "</li>";    
            }
        ?>
     
    </ul>

  </div>
</div>  <!-- end of container -->
</nav>



