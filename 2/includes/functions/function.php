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

function getItem($col, $tbl_name,$col2,$value){
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
** getALL Function v1.0
** This Function Accept Parameters
** $col1 = The Column Name
** $tbl_name = The Table Name
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getALL($col1, $tbl_name, $col2){
    global $con;
    $stmt = $con->prepare("select $col1 from $tbl_name order by $col2 desc");
    $stmt->execute(array($col2));
    $rows = $stmt->fetchAll(); 
    return $rows;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** getItem2 Function v2.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $col2 = The Second Column Which Use In The Condition
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getItem2($col, $tbl_name,$col2,$col3,$value){
    global $con;
    $stmt = $con->prepare("select $col from $tbl_name where $col2 = ? order by $col3 desc");
    $stmt->execute(array($value));
    $rows = $stmt->fetchAll();
    return $rows;
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*
** getRec2 Function v2.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getRec2($col, $tbl_name, $value=''){
    global $con;
    if(empty($value))
       $stmt = $con->prepare("select $col from $tbl_name");
    else
        $stmt = $con->prepare("select $col from $tbl_name where $col = ?");   
    $stmt->execute(array($value));
    $rows = $stmt->fetch(); 
    return $rows;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
** getItem3 Function v3.0
** This Function Accept Parameters
** $col = The Column Name
** $tbl_name = The Table Name
** $col2 = The Second Column Which Use In The Condition
** $value =  The Value Of the Row Field
** It Returns The All Records Of The Sql Query
*/

function getItem3($col, $tbl_name,$col2,$col3,$value){
    global $con;
    $stmt = $con->prepare("select $col from $tbl_name where $col2 = ? order by $col3 desc");
    $stmt->execute(array($value));
    $rows = $stmt->fetchAll();
    return $rows;
}







?>













