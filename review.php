<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();

if (isset($_POST['id']) && isset($_POST['vendorid'])  && isset($_POST['contents']) && isset($_POST['rating'])) {

    $reviewing_id = $_POST['id'];
    $reviewed_id = $_POST['vendorid'];
    $contents = $_POST['contents'];
    $rating = $_POST['rating'];

        $rv = $db->addReview($reviewing_id, $reviewed_id, $contents, $rating);
        if ($rv) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "리뷰가 저장이 되지 않았어요.";
            echo json_encode($response);
        }
    //}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "오류가 발생했어요";
    echo json_encode($response);

}

?>