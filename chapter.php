<?php
require 'connection.php';

//url isocode
$sql = "SELECT * FROM languages;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
$arrayIDLang = [];
foreach ($data as $datum){
    array_push($arrayIDLang, $datum[2]);
}
var_dump($arrayIDLang);
foreach ($arrayIDLang as $id){
    $url = "https://api.quran.com/api/v4/chapters?language=$id";

// call api
    $json = file_get_contents($url);
    $json = json_decode($json);

    $arraySurah = $json->chapters;
    foreach ($arraySurah as $index){
        $name = addslashes($index->name_simple);
        $id = $index->id;
        $arabic_name = $index->name_arabic;
        $revelation_order = $index->revelation_order;
        $revelation_place = $index->revelation_place;
        $verses_count = $index->verses_count;

        $sql ="INSERT INTO `chapters`( `name`, `number_chapter`, `arabic_name`, `revelation_order`, `revelation_place`, `verse_count`) VALUES 
                                                                                                                            ('$name','$id','$arabic_name','$revelation_order','$revelation_place','$verses_count')";
        try {
            $conn->exec($sql);
            echo $sql . "   BERHASILLLLLL </br>";
        } catch (PDOException $e){
            echo $e;
        }

    }
}
