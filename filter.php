<?php
require_once 'config/db.php';
$name = $_GET['name'];
$genres = $_GET['genres'];
$authors = $_GET['authors'];

$querySearch = "select b.name, b.description, b.images, a.author, g.genre 
                from books b
                join books_and_authors baa on b.id = baa.booksId
                join authors a on a.id = baa.authorsId
                join books_and_genres bag on b.id = bag.booksId
                join genres g on bag.genresId = g.id ";

$queryArr = [];
$bindParam = [];
if (!empty($name)) {
    $queryArr[] = " b.name like ? ";
    $bindParam[] = '%' . $name . '%';
}

if (!empty($genres)) {
    $in  = str_repeat('?,', count($genres) - 1) . '?';
    $queryArr[] = " bag.genresId in ($in) ";
    foreach ($genres as $item){
        $bindParam[] = $item;
    }
}

if (!empty($authors)) {
    $in  = str_repeat('?,', count($authors) - 1) . '?';
    $queryArr[] = " baa.authorsId in ($in) ";
    foreach ($authors as $item){
        $bindParam[] = $item;
    }
}

if (!empty($queryArr)) {
    $str = implode('and', $queryArr);
    $querySearch .= "where " . $str;
}

$dataSearch = $conn->prepare($querySearch);
$dataSearch->execute($bindParam);

if ($dataSearch->rowCount() > 0) {
    $arrSearchName = $dataSearch->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($arrSearchName);
}else {
    echo json_encode(['Нет результатов удовлетворяющих условиям']);
}