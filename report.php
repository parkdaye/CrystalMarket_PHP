<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

$response = array();

if (isset($_POST['reportingid']) && isset($_POST['reportedid'])  && isset($_POST['reason'])) {

    $reporting_id = $_POST['reportingid'];
    $reported_id = $_POST['reportedid'];
    $reason = $_POST['reason'];

    $sql = "SELECT report_sum FROM report where reported_id = '$reported_id'";

    $result = mysqli_query($con, $sql);
    $row=mysqli_fetch_array($result);

    if($row == null) {
        $rp = $db->addReport($reporting_id, $reported_id, $reason);
    }
    else {
        $sum = (int)$row['report_sum'] + 1;
        $rp = $db->addReport2($reporting_id, $reported_id, $reason, $sum);
    } 


    if ($rp) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
    } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "신고가 저장이 되지 않았어요.";
            echo json_encode($response);
       }

    
} 
else {
    $response["error"] = TRUE;
    $response["error_msg"] = "인자가 안왔어요";
    echo json_encode($response);

}

?>