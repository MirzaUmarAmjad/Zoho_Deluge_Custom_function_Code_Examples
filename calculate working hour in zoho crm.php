<?php
$request_url = 'https://people.zoho.com/people/api/attendance/getUserReport'; 
$authToken = "8f854f9af43c1c37765d618e9cf67012";
$dateFormat = "dd/MM/yyyy HH:mm:ss";
$sdate = $_POST["date1"] ;
$edate = $_POST["date2"] ;
$mapId = $_POST["mapId"] ;
$ch = curl_init(); curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$request_param = "authtoken=" . $authToken . "&sdate=" . $sdate . "&edate=" . $edate . "&dateFormat=" . $dateFormat ."&mapId=".$mapId; 
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_param); 
curl_setopt($ch, CURLOPT_URL, $request_url); 
curl_setopt($ch, CURLOPT_POST, TRUE); curl_setopt($ch, CURLOPT_HEADER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
$response = curl_exec($ch); 
$response_info = curl_getinfo($ch); 
curl_close($ch); 
$response_body = substr($response, $response_info['header_size']); 


$sum = 0 ;
$hours = 0;
$response_body = json_decode($response_body) ;
foreach ($response_body as $key) {
     $sum =  substr($key->WorkingHours,0,2);
     $sum = (int)$sum ;
     $hours = $sum+$hours ;
}

$updateRequest = "https://people.zoho.com/people/api/forms/xml/Salary/updateRecord" ;
$xml = "<Request><Record><field name='workhour'>".$hours."</field></Record></Request>";
$updateRequest_param = "authtoken=" . $authToken . "&inputData=".$xml."&recordId=".$_POST["id"] ;

$ch = curl_init(); curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $updateRequest_param); 
curl_setopt($ch, CURLOPT_URL, $updateRequest); 
curl_setopt($ch, CURLOPT_POST, TRUE); curl_setopt($ch, CURLOPT_HEADER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
$response = curl_exec($ch); 
$response_info = curl_getinfo($ch); 
curl_close($ch); 
$response_body = substr($response, $response_info['header_size']); 

var_dump($response_body) ;


?>