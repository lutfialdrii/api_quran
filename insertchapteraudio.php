<?php
require 'connection.php';

for ($i = 1; $i<=12; $i++){
    for ($c = 1; $c <=114; $c++){
        $url = "https://api.quran.com/api/v4/chapter_recitations/$i/$c";
//        echo "<p>$url</p></br>" ;
        //call api
        $json = file_get_contents($url);
        $json = json_decode($json);

        $url = $json->audio_file->audio_url;
//        echo $url . "</br>";
        try {
            $sql = "INSERT INTO `chapter_audios`( `url`, `id_chapter`, `id_recitation`) VALUES ('$url','$c','$i')";
//            echo $sql."</br>";
            $conn->exec($sql);
        }catch (PDOException $e){
            echo $e;
        }
    }


}


