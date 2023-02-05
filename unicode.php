<?php

require 'connection.php';

for ($i = 1; $i <= 6236; $i++){
    try {
        $sql = "SELECT text FROM ayat WHERE id = $i";
        $stmt = $conn -> prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchObject();
        $unicodewithBackslash = substr(json_encode($data->text),1,-1);
        $backslash= "'\'";
        $unicode = str_replace("\\", "\\\\", $unicodewithBackslash);

        try {
            $sql = "UPDATE ayat SET unicode = '$unicode' WHERE id = $i;";
            echo $sql;
            $stmt = $conn -> prepare($sql);
            $stmt->execute();
        }catch (PDOException $e){
            echo $e;
        }
    } catch (PDOException $e){
        echo $e;
    }

}

//echo json_encode($data->text);
//$unicodeChar2 = 'بِسْمِ';
//echo json_encode($unicodeChar2);