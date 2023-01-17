<?php

require "connection.php";

for ($i = 1; $i<=114; $i++){
    echo "<h1>INSERT CHAPTER KE - $i</h1>";
    $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&per_page=all&fields=text_indopak&word_translation_language=id&translations=33";
    echo "ini percobaan";
    $json = file_get_contents($url);
    $json = json_decode($json);

    $verses = $json->verses;

    foreach ($verses as $verse) {
        try {
            $text_indopak = $verse->text_indopak;
            $unicodewithBackslash = substr(json_encode($text_indopak),1,-1);
            $unicodeTextIndopak = str_replace("\\", "\\\\", $unicodewithBackslash);
            $number = $verse->verse_number;
            $words = $verse->words;
            $idVerses = $verse->id;
            $idJuz = $verse->juz_number;
            $latin = [];
            foreach ($words as $word) {
                if($word->char_type_name == "end"){
                    break;
                }
                array_push($latin, $word->transliteration->text);
                //echo join($sep, $transliteration);
            }
            $sep = " ";
            $transliteration = addslashes(join($sep, $latin));

            //var_dump($transliteration);
//        echo $transliteration.'<br/>';

//        $sql = "INSERT INTO `verses`(`text_uthmani`, `text_uthmani_simple`, `text_imlaei`, `text_imlaei_simple`, `text_indopak`, `number`, `transliteration`, `unicode_uthmani`, `unicode_uthmani_simple`, `unicode_imlaei`, `unicode_imlaei_simple`, `unicode_indopak`, `id_juz`, `id_chapter`) VALUES";
            $sql = "UPDATE `verses` SET `text_indopak`='$text_indopak', `unicode_indopak`='$unicodeTextIndopak' WHERE `id`='$idVerses';";
            echo $idVerses . "</br>";
            $conn->exec($sql);

        } catch (PDOException $exception) {
            echo $exception;
        }
    }

}