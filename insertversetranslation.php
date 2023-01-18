<?php
require "connection.php";

// sel translation
$idTranslate = [17,19,20,22,23,25,26,27,28,29,30,31,32,33,35,36,37,38,39,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,74,75,76,77,78,79,80,81,83,84,85,86,87,88,89,95,97,101,103,106,108,109,111,112,113,115,118,120,122,124,125,126,127,128,131,133,134,135,136,139,140,141,143,144,149,151,153,156,158,161,162,163,167,171,172,173,174,175,176,177,178,179,180,181,182,183,199,203,206,207,208,209,210,211,213,214,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,771,774,776,779,782,785,790,791,792,795,796,798,819,823];


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
