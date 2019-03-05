<?php

/*
** Show Title function v1.0
** This Function Accept No Parameters 
** It Returns The Page Title In Case Of The Page Has The
** Variable $pageTitle Or Echo default If it Doesn't have
*/

function showTitle(){
 global $title;
 if(isset($title)){
	return $title;
  }
 else{
    return "default";
}
    
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** Redirect function v2.0
** This Function Accept Parameters
** $msg = A Message To Be Printed
** $sec = Seconds Before Redirecting
** It Echo $errorMsg Then Redirecting After $sec
*/

function redirectHome($msg, $url = 'index.php' , $sec = 5 ){
    echo "<br><br><div class='container'>";
        if(is_array($msg)){
            foreach($msg as $row){
                    echo "<div class= 'alert alert-danger'>$row</div>"; 
            }
        }

        else{
            echo $msg;
        }
           echo "<div class= 'alert alert-info'> you will be redirected after $sec seconds</div>"; 
    echo "</div>"; // end of container
    header("refresh:$sec;url=$url");
    exit();
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** checkItem Function v1.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $value =  The Value Of the Row Field
** It Returns The Count Of The Sql Query
*/

function checkItem($col, $tbl_name ,$value){
    global $con;
    $stmt = $con->prepare("select $col from $tbl_name where $col = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;    
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** countItem Function v1.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** It Returns The number of rows in the database
*/

function countItem($col, $tbl_name){
     global $con;
     $stmt = $con->prepare("select count($col) from $tbl_name");
     $stmt->execute();
     return $stmt->fetchColumn();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** getLatest function v1.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $order = Column Name To Order The Query On It
** $lim_num = number of records to get
*/

function getLatest($col, $tbl_name, $order, $lim_num=5){
   global $con;
    $stmt = $con->prepare("select $col from $tbl_name order by $order desc limit $lim_num ");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** getItem Function v1.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $col2 = The Second Column Which Use In The Condition
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getItem($col, $tbl_name,$col2, $value){
    global $con;
    $stmt = $con->prepare("select $col from $tbl_name where $col2 = ? order by $col2 desc");
    $stmt->execute(array($value));
    $rows = $stmt->fetchAll();
    return $rows;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** checkinfo Function v1.0
** This Function Accept Parameters
** $col1 = The First Column Name
** $tbl_name = The Table Name
** $col2 = The Second Column Name
** $val1 =  The Value Of the The First Column
** $val2 =  The Value Of the The Second Column
** It Returns The All Records Of The Sql Query
*/

function checkinfo($col1, $col2, $tbl_name, $val1,$val2){
    global $con;
    $stmt = $con->prepare("select $col1,$col2 from $tbl_name where ($col1 = ? or $col2 = ?) limit 1");
    $stmt->execute(array($val1,$val2));
    $rows = $stmt->fetch();
    return $rows;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*
** getRec Function v1.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getRec($col, $tbl_name, $value=''){
    global $con;
    if(empty($value))
       $stmt = $con->prepare("select $col from $tbl_name");
    else
        $stmt = $con->prepare("select $col from $tbl_name where $col = ?");   
    $stmt->execute(array($value));
    $rows = $stmt->fetchAll(); 
    return $rows;
}







//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
























?>













