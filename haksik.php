<!DOCTYPE html>
<html>
<meta charset="UTF-8" />

<?php
  $token = "WTbl3YEHOKbGRoaR3KlzmZENuDt3DKLY0SoxfdPuputiANs66V";
  $date = date("Y-m-d");
  //$header = "Bearer ".$token; // Bearer 다음에 공백 추가
  //$url = "https://bablabs.com/openapi/v1/campuses/zMsKrQXhsp/stores?date=$date";
  $url = "https://bablabs.com/openapi/v1/campuses/Cuu9iemYsU/stores?date=$date"; //운정캠 
  
  $is_post = false;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, $is_post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //$headers = array();
  $headers = [
    "Accesstoken: $token",
    //"date: $date"
    //"type: $type"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = curl_exec ($ch);
  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  curl_close ($ch);

  function unicode2html($str){
    $i=65535;
    while($i>0){
        $hex=dechex($i);
        $str=str_replace("\u$hex","&#$i;",$str);
        $i--;
     }
     return $str;
}

$response = unicode2html($response);


  if($status_code == 200) {
    //echo $s;
    //echo iconv("utf-8", "JSON_UNESCAPED_UNICODE", $response);
    echo ($response); 
    //cho json_encode($response, JSON_UNESCAPED_UNICODE);
    //print (to_han($response));
  } else {
    echo "Error 내용:".$response;
  }
?>

</html>
