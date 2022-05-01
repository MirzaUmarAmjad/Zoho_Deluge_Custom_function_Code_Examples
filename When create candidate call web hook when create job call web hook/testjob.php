<?php

include 'userclass.php';

$skill = trim($_POST['skill']) ;
$id = $_POST['id'] ;
$userDB = new user() ;
$userDB->dbconect();
$ap = $userDB->getData() ;
$i = 0 ;
while ($row = $ap->fetchObject()) 
{
  $tags = explode(',', $row->skillSte);

  foreach ($tags as $key) 
  {
      echo $key ."</br>";
      $key = trim($key);
    if ($key == $skill)
    {
       $i++ ;
        
    }
       
  }

  if ($i > 0 ) {

    $token='c70dd3ed0f6cc1c13924f89d222d07f9';
    $url = 'https://recruit.zoho.com/recruit/private/xml/CustomModule1/addRecords';
    $param= 'authtoken='.$token.'&scope=recruitapi&version=2&xmlData=<CustomModule1>
        <row no="1">
            <FL val="appleName"><![CDATA[test]]></FL>
            <FL val="Email"><![CDATA['.$row->email.']]></FL>
            <FL val="JobLookup_ID"><![CDATA['.$id.']]></FL>
        </row>
    </CustomModule1>';


$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $response = curl_exec($ch);
    curl_close($ch);
    var_dump($response) ;
    $i = 0 ;
  }
}

?>