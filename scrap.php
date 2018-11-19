<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();

if (isset($_POST['products_num']) && isset($_POST['id'])) {

    $products_num = $_POST['products_num'];
    $id = $_POST['id'];

        $scrap = $db->addScrap($id, $products_num);
        if ($scrap) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "이미 찜한 상품입니다!";
            echo json_encode($response);
        }
    //}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "오류가 발생했어요";
    echo json_encode($response);

}

?>