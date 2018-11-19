<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$r = array();

if(isset($_POST['searchword'])){
	$searchword = $_POST['searchword'];
	
	$result = mysqli_query($con, "SELECT products_num, products_name, price, products_pic
									 FROM products WHERE products_name LIKE '%$searchword%'");
	$productData = array();

	if($result) {
		
		while($row=mysqli_fetch_array($result)){
			$image =base64_encode($row[3]);

    	   //array_push($productData, array('imgUrl'=>$row[0], 'productName' =>$row[1], 'price'=>$row[2]));
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

<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (!$android){
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
	</head>
	<body>
		<form method="POST" action="<?php $_PHP_SELF ?>" >
			sw: <input type="searchword" name="searchword">
			<input type="submit" />
		</form>

	</body>
</html>
<?php
}
?>
