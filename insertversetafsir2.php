<?php
require 'connection.php';

for ($i = 4139; $i<=6236; $i++) {
    $url = "https://quran.kemenag.go.id/api/v1/tafsirbyayat/$i";
    //call api
    $json = file_get_contents($url);
    $json = json_decode($json);

    $array = $json->tafsir;
    foreach ($array as $item) {
        $wajiz = addslashes($item -> tafsir_wajiz);
        $tahlili = addslashes($item -> tafsir_tahlili);

        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$tahlili','$i','1');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$wajiz','$i','2');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
    }
}