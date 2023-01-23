<?php


require 'connection.php';
$idVerse=1;
for ($i = 1; $i<=114; $i++){
    $url = "https://quran-api-id.vercel.app/surahs/$i";
    //call api
    $json = file_get_contents($url);
    $json = json_decode($json);

    $array = $json->ayahs;
    foreach ($array as $item) {
        $short = addslashes($item->tafsir->kemenag->short);
        $long = addslashes($item->tafsir->kemenag->long);
        $jalalayn = addslashes($item->tafsir->jalalayn);
        $quraish = addslashes($item->tafsir->quraish);

        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$short','$idVerse','2');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$long','$idVerse','1');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$jalalayn','$idVerse','4');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
        try {
            $sql =  "INSERT INTO `verse_tafsirs`(`text`, `id_verse`, `id_tafsirs`) VALUES ('$quraish','$idVerse','3');";
            $conn->exec($sql);
        } catch (PDOException $e){
            echo $e;
        }
        $idVerse++;
    }

}





