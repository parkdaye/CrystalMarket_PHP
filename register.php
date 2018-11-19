<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);


if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['nickname']) && isset($_POST['major']) && isset($_POST['student_num']) && 
    isset($_POST['phone_num']) && isset($_POST['email'])) {
 
    // receiving the post params
    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $nickname = $_POST['nickname'];
    $major = $_POST['major'];
    $student_num = $_POST['student_num'];
    $phone_num = $_POST['phone_num'];
    $email = $_POST['email'];
 
    // check if user is already existed with the same id
    if ($db->isUserExisted($id)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "이미 존재하는 아이디입니다!" . $id;
        echo json_encode($response);
    } 
    /* //닉네임중복검사
    elseif ($db->isUserExisted($nickname)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "nickname already existed with " . $nickname;
        echo json_encode($response);
    }
    */
    else {
        // create a new user
        $user = $db->storeUser($id, $name, $password, $nickname, $major, $student_num, $phone_num, $email);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
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
        Name: <input type = "text" name = "name" />
        ID: <input type = "text" name = "id" />
        psswd: <input type = "password" name = "password" />
        nick: <input type = "nickname" name = "nickname" />
        maj: <input type = "major" name = "major" />
        studnum : <input type = "student_num" name = "student_num" />       
        phnum: <input type = "phone_num" name = "phone_num" />
        email: <input type = "email" name = "email" />
        <input type = "submit" />
    </form>
   
   </body>
</html>
<?php
}
?>
