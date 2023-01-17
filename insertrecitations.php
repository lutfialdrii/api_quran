<?php
require 'connection.php';

$url = "https://api.quran.com/api/v4/resources/recitations";

//call api
$json = file_get_contents($url);
$json = json_decode($json);

$arrayRecitations = $json->recitations;
foreach ($arrayRecitations as $item) {
    $name = $item->reciter_name;
    $style = $item->style;
    try {
        $sql = "INSERT INTO `recitations`( `reciter_name`, `style`) VALUES ('$name','$style')";
        $conn->exec($sql);
    }catch (PDOException $e){
        echo $e;
    }


}