

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<section class="container">
   <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home');?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="categories.php"><?php echo lang('Categories');?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="item.php"><?php echo lang('Items');?></a>
      </li>
      <li class="nav-item">  
        <a class="nav-link" href="member.php"><?php echo lang('Members');?></a>
      </li>  
      <li class="nav-item">  
        <a class="nav-link" href="comments.php"><?php echo lang('Comments');?></a>
      </li>
     
    </ul>
    <ul class="navbar-nav ml-auto">  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo lang('Admin');?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php" target="_blank"><?php echo lang('Visit shop');?></a>
          <a class="dropdown-item" href="member.php?action=edit&userid=<?php echo $_SESSION['userid'];?>"><?php echo lang('Edit profile');?></a>
          <a class="dropdown-item" href="#"><?php echo lang('Settings');?></a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('Logout');?></a>
        </div>
      </li>
    </ul>
  </div>
</nav>


