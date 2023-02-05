<?php
require "connection.php";

// sel translation
//$idTranslate = [81,106,144,149,151,153,156,158,161,162,163,167,171,172,173,174,175,176,177,178,179,180,181,182,183,199,203,206,207,208,209,210,211,213,214,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,771,774,776,779,782,785,790,791,792,795,796,798,819,823];
$idTranslate =[103];

    foreach ($idTranslate as $idTrans) {

        for ($i=1; $i <=114 ; $i++) {
            $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&per_page=all&fields=text_uthmani&word_translation_language=id&translations=$idTrans";
//            echo $url."<br/>";
            $json = file_get_contents($url);
            $json = json_decode($json);

            $translate = $json->verses;

            foreach ($translate as $trans) {
                $idVerse = $trans->id;
                $textAll = addslashes($trans->translations[0]->text);
                $sql = "INSERT INTO verse_translations (text, id_translation, id_verse) VALUES ('$textAll', '$idTrans', '$idVerse');";
                try {
                    $conn->exec($sql);
                }catch (PDOException $e){
                    echo $e;
                }
            }
        }
    }
