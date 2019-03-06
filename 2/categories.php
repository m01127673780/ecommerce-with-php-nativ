<?php
session_start();
if(isset($_GET['name'])){
$cat_name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
$title = $cat_name;
include "init.php";
$possible_names = getRec('name', 'categories');
$name = array();
foreach($possible_names as $possible_name){
$name[] = $possible_name['name'];
}
?>
<div class="container items ads">
	<?php
	if(in_array($cat_name,$name)){
	$cat_id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
	$count = checkItem('cat_id', 'items', $cat_id);
	if ($count > 0){?>
	<h1 class="text-center"><?php echo $cat_name;?></h1>
	<?php
	$rows = getItem2('*','items','cat_id','id',$cat_id);
	$path = 'uploads/product-img/';
	echo "<div class='row'>";
		foreach($rows as $item){
		echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
			echo "<div class='card'>";
				echo "<span class='price-tag'>$". $item['price'] ."</span>";
				echo "<a href='items.php?id=".$item['id']."'>
					<div class='back-img'>
						<img src='".$path.$item['image']."' class='img-thumbnail img-responsive d-block
						mx-auto'>
					</div>
				</a>";
				echo "<div class='card-body'>";
					echo "<span class='details'>";
						echo "<h3 class='card-title'><a href='items.php?id=".$item['id']."'>" .$item['name']. "</a></h3>";
						echo "<p class='card-text'>".$item['description']."</p>";
					echo "</span>";
					echo "<div class='date text-right'>".$item['date']."</div>";
				echo "</div>";
			echo "</div>";/* end card*/
		echo "</div>"; /* end of col */
		}
	echo "</div>";  /* end of row */
	}
	else{
	echo "<div class='empty'> There Is No Items In This Category </div>";
	}
	} /* end if(in_array($cat_name,$name)) */
	else{
	echo "<div class='empty'> There Is No Category With This Name </div>";
	}
	?>
	</div> <!-- end of container--><br><br>
	<?php
	include $tpl."footer.php";
	
	
	} /* end if(isset($_GET['name'])) */
	?>