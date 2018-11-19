<?php
	require_once 'include/DB_Functions.php';
	$db = new DB_Functions();
	$con = $db->conn;

	if (isset($_POST['id']) && isset($_POST['image'])) {
 
		$id =$_POST['id'];
		$image=$_POST['image'];

		//DB에 저장하기
		$data=base64_decode($image);
		$escaped_values=mysqli_escape_string($con, $data);
		$r1=mysqli_query($con, "update users set certification = 0 where id='$id'"); 
		$r2=mysqli_query($con, "update users set student_pic = '$escaped_values' where id='$id'"); 
		
     }

     $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

     if (!$android){
?>


<HTML>
<HEAD>
<TITLE>List BLOB Images</TITLE>
</HEAD>
<BODY>

<h1>학생증 사진 인증하기</h1>
<h6>인증 또는 거부를 눌러주세요</h6>

<?php
	}
    //출력하기
    $sql = "SELECT id, student_pic FROM users where certification = 0";
	$result = mysqli_query($con, $sql);

	$response = array();

	while($row = mysqli_fetch_array($result)) {

		$array_id = $row['id'];
		$ctf = "ctf".$array_id;
		$nctf = "nctf".$array_id;

	if (!$android){

		echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['student_pic'] ).'" height = "150" width = "150"/>';
		echo "id : ";  
		echo $array_id;
?>

<form method="post">
	<input type = "submit" name = "<?=$ctf?>" id = "<?=$ctf?>" value ="인증" />
	<input type = "submit" name = "<?=$nctf?>" id = "<?=$nctf?>" value ="거부"/>
</form>
<br/>

<?php
	
	}

	if(array_key_exists($ctf, $_POST)) {
        $db->ctf_click($array_id);
	}
	else if(array_key_exists($nctf, $_POST)) {
		$db->nctf_click($array_id);
	}
}
	

	if (!$android){
?>

</BODY>
</HTML>

<?php 
}
?>