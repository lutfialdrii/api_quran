<?php
require "connection.php";

$idLanguage = ["en", "ur", "id", "bn", "tr", "fa", "ru", "hi", "de", "ta"];

foreach ($idLanguage as $language) {
    $sql = "SELECT id FROM languages WHERE iso_code = '$language';";
    $stmt = $conn -> prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchObject();
    $idLanguage = $data->id;
    for ($i = 1; $i <= 114; $i++) {
//    echo "<h1> insert chapter ke $i</h1>";
        $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&translation_fields=resource_name%2Clanguage_id&per_page=all&fields=text_uthmani%2Cchapter_id%2Chizb_number%2Ctext_imlaei_simple&reciter=7&word_translation_language=$language&page=1&word_fields=verse_key%2Cverse_id%2Cpage_number%2Clocation%2Ctext_uthmani%2Ccode_v1%2Cqpc_uthmani_hafs&mushaf=2";

//call api
        $json = file_get_contents($url);
        $json = json_decode($json);

        $arraySurah = $json->verses;
        foreach ($arraySurah as $item) {
            try{
                $idVerse = $item->id;

                $arrayWord = $item->words;
                foreach ($arrayWord as $itemWord) {
                    if($itemWord -> char_type_name == "end"){
                        break;
                    }
                    $position = $itemWord->position;
                    $sql = "SELECT id FROM word_verses WHERE number = '$position' AND id_verse = '$idVerse';";
                    $stmt = $conn -> prepare($sql);
                    $stmt->execute();
                    $data = $stmt->fetchObject();
                    $idAyat = $data->id;
                    $text = addslashes($itemWord->translation->text);

                    $sql = "INSERT INTO `word_translations`(`text`, `id_word_verse`, `id_language`) VALUES ('$text','$idVerse', '$idLanguage');";
//                    echo $sql . "</br>";
                    $conn->exec($sql);
                }
            } catch (PDOException $e){
                echo "$sql ERRRRRRROORRRRR $e";
            }
        }
    }
}
?>