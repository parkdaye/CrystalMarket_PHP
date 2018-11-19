<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

	$cmtlist = array();

if (isset($_POST['products_num'])) {

    $pnum = $_POST['products_num'];

	$sql = "SELECT u.nickname, c.cmt_sub, u.student_pic, c.cmt_id FROM comment c, users u where c.cmt_id = u.id and c.cmt_pnum = '$pnum' ORDER BY created_at ASC";
	
	//$sql = "SELECT student_pic FROM users";
	$result = mysqli_query($con, $sql);



	if($result) {
		
		while($row=mysqli_fetch_array($result)){
			$image =base64_encode($row[2]);

    	   array_push($cmtlist, array('profile'=>$image, 'nick' =>$row[0], 'contents'=>$row[1], 'id'=>$row[3]));
		}


    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("cmtlist"=>$cmtlist, "error"=>false), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;

    }  
    else{  
    $cmtlist["error"] = TRUE;
    $cmtlist["error_msg"] = "sql처리중 오류 발생.";
    echo json_encode($cmtlist);
	}
}
else {
	$cmtlist["error"] = TRUE;
    $cmtlist["error_msg"] = "제품번호가 안왔어요.";
    echo json_encode($cmtlist);
}

?>

<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (!$android){
?>

<html>
   <body>
   
      <form action="<?php $_PHP_SELF ?>" method="POST">
         Pnum: <input type = "products_num" name = "products_num" />
        <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}
?>