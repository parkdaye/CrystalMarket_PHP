<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();

if (isset($_POST['products_num']) && isset($_POST['id']) && isset($_POST['cmt_context'])) {

    $products_num = $_POST['products_num'];
    $id = $_POST['id'];
    $cmt_context = $_POST['cmt_context'];

        $cmt = $db->addCmt($id, $products_num, $cmt_context);
        if ($cmt) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "댓글이 저장이 되지 않았어요.";
            echo json_encode($response);
        }
    //}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "오류가 발생했어요";
    echo json_encode($response);

}

?>