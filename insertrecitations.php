<?php
require 'connection.php';

$url = "https://api.quran.com/api/v4/resources/recitations";

//call api
$json = file_get_contents($url);
$json = json_decode($json);

$arrayRecitations = $json->recitations;
foreach ($arrayRecitations as $item) {
    $id = $item->id;
    $name = $item->reciter_name;
    $style = $item->style;
    try {
        $sql = "INSERT INTO `recitations`(`id`, `reciter_name`, `style`) VALUES ('$id','$name','$style')";
        $conn->exec($sql);
    }catch (PDOException $e){
        echo $e;
    }


}