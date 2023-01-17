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
        $sql = "SELECT id FROM languages WHERE iso_code = '$id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $idlang = $stmt->fetchObject()->id;
        $idChapter = $index->id;
        $text = addslashes($index->translated_name->name);

        echo "<h1>INSERT TRANSLATE AYAT untuk bahasa $id</h1></br>";

        try {
            $sql = "INSERT INTO `chapter_translations`(`text`, `id_chapter`, `id_language`) VALUES ('$text','$idChapter','$idlang');";
            echo $sql. "<br/>";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
    }
}