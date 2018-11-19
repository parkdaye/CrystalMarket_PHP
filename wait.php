<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$con = $db->conn;

$response = array();

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$sql = "SELECT certification FROM users where id = '$id'";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
 	//echo $row['certification'];

    if ($row['certification'] == 1) {
        $response["success"] = true;
		echo json_encode($response);

        $sql2 = "update users set students_pic = 'null' where id = '$id'";
        $result2 = mysqli_query($con, $sql2);
    } 
    else if($row['certification'] == 2) {
        $response["success"] = false;
		echo json_encode($response);
    }

}
?>


<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if (!$android){
?>

<html>
   <body>
   
    <form action="<?php $_PHP_SELF ?>" method="POST">
        ID: <input type = "text" name = "id" />
        <input type = "submit" />
    </form>
   
   </body>
</html>
<?php
}
?>