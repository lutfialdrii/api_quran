<?php
require 'connection.php';
require 'vendor/league/csv/autoload.php';
use League\Csv\Reader;

// We are going to insert some data into the users table
$sth = $conn->prepare(
    "INSERT INTO verse_tafsirs (text, id_verse, id_tafsirs) VALUES (:text, :id_verse, :id_tafsirs)"
);

// By setting the header offset we index all records
// with the header record and remove it from the iteration
$csv = Reader::createFromPath('data/data.csv')
    ->setHeaderOffset(0)
;

foreach ($csv as $record) {
    // Do not forget to validate your data before inserting it in your database
    $sth->bindValue(':text', $record['text'], PDO::PARAM_STR);
    $sth->bindValue(':id_verse', addslashes($record['id_verse']), PDO::PARAM_STR);
    $sth->bindValue(':id_tafsirs', $record['id_tafsir'], PDO::PARAM_STR);
    try {
        $sth->execute();
    } catch (PDOException $e){
        echo $e;
    }
}