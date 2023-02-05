<?php
//$url = "https://api.quran.com/api/v4/verses/by_page/1?language=id&words=true&translations=id&page=2&per_page=10";
require "connection.php";
for ($i = 1; $i <= 114; $i++) {
//    echo "<h1> insert chapter ke $i</h1>";
    $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&per_page=all&fields=text_uthmani&word_translation_language=id";

//call api
    $json = file_get_contents($url);
    $json = json_decode($json);

    $arraySurah = $json->verses;
    foreach ($arraySurah as $item) {
        try{
            $nomorAyat = $item->verse_number;
            $stmt = $conn -> prepare("SELECT id FROM verses WHERE number = '$nomorAyat' AND id_chapter = '$i'");
            $stmt->execute();
            $data = $stmt->fetchObject();
            $idAyat = $data->id;

            $arrayWord = $item->words;
            foreach ($arrayWord as $itemWord) {
                if($itemWord -> char_type_name == "end"){
                    break;
                }
                $text = $itemWord->text;
                $audio_url = $itemWord->audio_url;
                $latin = addslashes($itemWord->transliteration->text);
                $nomorKata = $itemWord->position;
                $unicodewithBackslash = substr(json_encode($itemWord->text),1,-1);
                $unicode = str_replace("\\", "\\\\", $unicodewithBackslash);

//                $sql = "INSERT INTO kata_ayat (text, nomor, latin, terjemahan, audio, id_ayat) VALUES ('$text', '$nomorKata','$latin', '$translate_ayat', 'https://verses.quran.com/$audio_url', '$idAyat')";
//                $conn-> exec($sql);
                $sql = "INSERT INTO `word_verses`(`text`, `number`, `audio`, `transliteration`, `unicode`, `id_verse`) VALUES ('$text','$nomorKata','https://verses.quran.com/$audio_url','$latin','$unicode','$idAyat')";
                $conn->exec($sql);
            }
        } catch (PDOException $e){
            echo "$sql ERRRRRRROORRRRR $e";
        }
//        echo "\n===$nomorAyat===";




    }
}
//$id_surah = 1;
//
//
//$arrayAyat = $json->verses[1]->words;
//$arrayKataAyat = [];
//foreach ($arrayAyat as $i) {
//    var_dump($i->translation->text);
//}
//var_dump($json->verses[0]->words);
?>