<?php

require "connection.php";

for ($i = 1; $i<=114; $i++){
    echo "<h1>INSERT CHAPTER KE - $i</h1>";
    $url = "https://api.qurancdn.com/api/qdc/verses/by_chapter/$i?words=true&per_page=all&fields=text_uthmani&word_translation_language=id&translations=33";
    $json = file_get_contents($url);
    $json = json_decode($json);

    $verses = $json->verses;

    foreach ($verses as $verse) {
        try {
            $text_uthmani = $verse->text_uthmani;
            $unicodewithBackslash = substr(json_encode($text_uthmani),1,-1);
            $unicodeTextUthmani = str_replace("\\", "\\\\", $unicodewithBackslash);
            $number = $verse->verse_number;
            $words = $verse->words;
            $idChapter = $i;
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
            $sql = "INSERT INTO `verses`(`text_uthmani`,`number`, `transliteration`, `unicode_uthmani`,`id_juz`, `id_chapter`) VALUES('$text_uthmani', '$number', '$transliteration', '$unicodeTextUthmani', '$idJuz', '$idChapter')";

            $conn->exec($sql);

        } catch (PDOException $exception) {
            echo $exception;
        }
    }

}