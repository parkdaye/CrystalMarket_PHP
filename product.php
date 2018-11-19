<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();
//제품번호를 받음
//판매자사진 (댓글정보)
if (isset($_POST['products_num'])) {

    $products_num = $_POST['products_num'];
   
    //$sql = "SELECT products_name, price, products_info, products_pic FROM products where product_num = '$products_num'";
	//$result = mysqli_query($con, $sql); 

	$product = $db->getProductByNum($products_num);
        if ($product) {
            // user stored successfully
        	$vendor = $product["vendor_id"];
			$result = mysqli_query($con, "SELECT nickname, student_pic FROM users where id = '$vendor'"); 
			$row = mysqli_fetch_array($result);

			$pic1 =base64_encode($product["products_pic"]);
			$pic2 =base64_encode($row["student_pic"]);

            $response["product"]["pic"] = $pic1;
            $response["product"]["name"] = $product["products_name"];
            $response["product"]["price"] = $product["price"];
            $response["product"]["category"] = $product["category"];
            $response["product"]["info"] = $product["products_info"];
            $response["product"]["created_at"] = $product["created_at"];

            $response["vendor"]["vid"] = $product["vendor_id"];
            $response["vendor"]["nickname"] = $row['nickname'];
            $response["vendor"]["vendor_pic"] = $pic2;
            
            $response["error"] = FALSE;
            echo json_encode($response);
              
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "제품번호가 안왔어요.";
    echo json_encode($response);
}



//제품번호와 아이디를 받음, 스크랩에 추가하고 업데이트된 스크랩 수를 넘기기
?>


<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (!$android){
?>

<html>
   <body>
   
      <form action="<?php $_PHP_SELF ?>" method="POST">
         ID: <input type = "products_num" name = "products_num" />
        <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}
?>