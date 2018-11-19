<?php
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    $con = $db->conn;

    $reviewlist = array();

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    $sql = "SELECT u.nickname, r.rev_sub, u.student_pic, r.rating, u.id FROM review r, users u where r.reviewing_id = u.id and r.reviewed_id = '$id'";
    
    //$sql = "SELECT student_pic FROM users";
    $result = mysqli_query($con, $sql);



    if($result) {
        
        while($row=mysqli_fetch_array($result)){
            $image =base64_encode($row[2]);

           array_push($reviewlist, array('profile'=>$image, 'nick' =>$row[0], 'contents'=>$row[1], 'rating'=>$row[3], 'reviewing_id' => $row[4]));
        }


    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("reviewlist"=>$reviewlist, "error"=>false), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;

    }  
    else{  
    $reviewlist["error"] = TRUE;
    $reviewlist["error_msg"] = "sql처리중 오류 발생.";
    echo json_encode($reviewlist);
    }
}
else {
    $reviewlist["error"] = TRUE;
    $reviewlist["error_msg"] = "제품번호가 안왔어요";
    echo json_encode($reviewlist);
}

?>

<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (!$android){
?>

<html>
   <body>
   
      <form action="<?php $_PHP_SELF ?>" method="POST">
         id: <input type = "id" name = "id" />
        <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}
?>