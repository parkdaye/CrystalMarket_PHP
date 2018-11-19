<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;


	$sql = "SELECT products_num, products_name, price, products_pic FROM products ORDER BY created_at DESC";
	
	//$sql = "SELECT student_pic FROM users";
	$result = mysqli_query($con, $sql);
	$productData = array();

	if($result) {
		
		while($row=mysqli_fetch_array($result)){
			$image =base64_encode($row[3]);

    	   //array_push($productData, array('num'=>$row[0], 'name' =>$row[1], 'price'=>$row[2]));
    	   array_push($productData, array('num'=>$row[0], 'name' =>$row[1], 'price'=>$row[2], 'image' => $image));
		}


    header('Content-Type: application/json; charset=utf8');
    $json = json_encode($productData, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;

    }  else{  
    echo "SQL문 처리중 에러 발생 : "; 
    echo mysqli_error($link);
} 

?>