<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();

if (isset($_POST['pnum'])) {

    $pnum = $_POST['pnum'];

    $sql = "delete from products where products_num = '$pnum'";
    $result = mysqli_query($con, $sql);
        if ($result) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "삭제가 안되었어요.";
            echo json_encode($response);
        }
    //}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "오류가 발생했어요";
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
         pnum: <input type = "products_num" name = "products_num" />
        <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}
?>