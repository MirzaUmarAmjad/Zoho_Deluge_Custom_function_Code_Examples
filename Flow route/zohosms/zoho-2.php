<?php
$currentDirectory = getcwd();
$uploadDirectory = "/uploads/";
$fileName = $_GET['filename'] ;

$uploadPath = $currentDirectory . $uploadDirectory . $fileName;

$url    = $_GET['url'] ;
$img    = $uploadPath ;
$file   = file($url);
$result = file_put_contents($img, $file) ;

echo $url ;



?>
