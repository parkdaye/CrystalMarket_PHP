<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['id']) && isset($_POST['password'])) {
 
    // receiving the post params
    $id = $_POST['id'];
    $password = $_POST['password'];
 
    // get the user by email and password
    $user = $db->getUserByIdAndPassword($id, $password);
 
    if ($user != false) {
        // user is found
        $response["error"] = FALSE;
        
        $response["user"]["certification"] = $user["certification"];
        //$response["user"]["id"] = $user["id"];
        
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "로그인 정보가 일치하지 않습니다. 다시 시도해주세요!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "모두 입력해주세요!";
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
         ID: <input type = "text" name = "id" />
        psswd: <input type = "password" name = "password" />
        <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}
?>