<?php
//$url = "https://api.quran.com/api/v4/verses/by_page/1?language=id&words=true&translations=id&page=2&per_page=10";
require "connection.php";
for ($i = 1; $i <= 114; $i++) {
    $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&per_page=all&fields=text_uthmani&word_translation_language=id";

//call api
    $json = file_get_contents($url);
    $json = json_decode($json);

    $arraySurah = $json->verses;
    foreach ($arraySurah as $item) {

        try{
            $nomorAyat = $item->verse_number;
            $stmt = $conn -> prepare("SELECT id FROM ayat WHERE nomor = $nomorAyat AND id_surah = $i");
            $stmt->execute();
            $data = $stmt->fetchObject();
            $idAyat = $data->id;

            $arrayAyat = $item->words;
            foreach ($arrayAyat as $item) {
                if($item -> char_type_name == "end"){
                    break;
                }
                $text = $item->text;
                $translate_ayat = addslashes($item->translation->text);
                $audio_url = $item->audio_url;
                $latin = addslashes($item->transliteration->text);
                $nomorKata = $item->position;

                $sql = "INSERT INTO kata_ayat (text, nomor, latin, terjemahan, audio, id_ayat) VALUES ('$text', '$nomorKata','$latin', '$translate_ayat', 'https://verses.quran.com/$audio_url', '$idAyat')";
                $conn-> exec($sql);
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