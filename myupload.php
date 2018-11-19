<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

	
	
	$r = array();

	if (isset($_POST['id'])) {
	$id = $_POST['id'];
		
	$sql = "SELECT products_num, products_name, price, products_pic FROM products where vendor_id='$id' ORDER BY created_at DESC";
	
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
    $r["error"] = "SQL문 처리중 에러 발생 : ";
	//echo json_encode($r);
    //echo mysqli_error($link);
	} 

}else
	 $r["error"] = "id를 못받음";
	//echo json_encode($r);

?>



