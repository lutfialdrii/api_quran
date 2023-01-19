<?php

require 'connection.php';

$idTranslate = [81, 106, 153, 220];

foreach ($idTranslate as $item) {
    echo "<h1>$item</h1>";
    for ($i = 1; $i <=6236; $i++) {
        $sql = "SELECT COUNT(id_verse) as c FROM `verse_translations` WHERE id_verse = $i AND id_translation ='$item';";
        $stmt=$conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchObject();

        if ($result->c < 1){
            echo "Verse ke - $i" . "</br>" ;
//        echo $result->c . "</br>";
        }
    }
    $sql = "SELECT COUNT(id_verse) as c FROM `verse_translations` WHERE id_translation ='$item';";
    $stmt=$conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchObject();
    if ($result->c < 6236){
        echo "Data Miss : ". (6236-($result->c)) . "</br>";
    }
}

//
//echo "<h1>================</h1>";
//
//foreach ($idTranslate as $item) {
//    $sql = "SELECT COUNT(id_translation) as c FROM `verse_translations` WHERE id_translation = '$item';";
//    $stmt=$conn->prepare($sql);
//    $stmt->execute();
//    $result = $stmt->fetchObject();
//
//    if ($result->c < 6236){
//        echo "<h1>Translation ke - $item</h1>" . "</br>" ;
//        echo $result->c . "</br>";
//    }
//}