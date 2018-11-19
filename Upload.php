<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$con = $db->conn;
// json response array
$response = array("error" => FALSE);


if (isset($_POST['vendor_id']) && isset($_POST['products_name']) && isset($_POST['products_price']) && isset($_POST['products_info']) 
    && isset($_POST['category']) && isset($_POST['products_pic'])) {
 
    // receiving the post params
    $vendor_id = $_POST['vendor_id'];
    $products_name = $_POST['products_name'];
    $products_price = $_POST['products_price'];
    $products_info = $_POST['products_info'];
    $category = $_POST['category'];
    $pic = $_POST['products_pic'];

    $data = base64_decode($pic);
    $products_pic = mysqli_escape_string($con, $data);


    $r3=mysqli_query($con, "INSERT INTO products(products_pic, products_name, price, category, products_info, created_at, vendor_id) 
        VALUES('$products_pic', '$products_name', '$products_price', '$category', '$products_info', NOW(), '$vendor_id')"); 


    
        $response["error"] = FALSE;
        echo json_encode($response);

    // create a new user
    /*
    $product = $db->storeProduct($vendor_id, $products_name, $products_price, $products_info, $category, $products_pic);
        if ($product) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
            /*
            $response["user"]["id"] = $user["id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["created_at"] = $user["created_at"];
            

        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "저장이 안됐어요ㅠ ㅠ";
            echo json_encode($response);
        }
    */
} 
else {
    $response["error"] = TRUE;
    $response["error_msg"] = "상품정보를 모두 입력해주세요!";
    echo json_encode($response);

}

?>


<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if (!$android){
?>

<html>
   <body>
   
    <form action="<?php $_PHP_SELF ?>" method="POST">
        vendor_id: <input type = "text" name = "vendor_id" />
        products_name: <input type = "text" name = "products_name" />
        products_pric: <input type = "password" name = "products_price" />
        products_info: <input type = "nickname" name = "products_info" />
        category : <input type = "student_num" name = "category" />       
        products_pic : <input type = "pic" name = "products_pic" />

        <input type = "submit" />
    </form>
   
   </body>
</html>


<?php
}
?>