<?php ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="#"><h3>Поиск книг</h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<?php
require_once 'config/db.php';
$queryGenres = "SELECT * FROM genres";
$dataGenres = $conn->prepare($queryGenres);
$dataGenres->execute();
if ($dataGenres->rowCount() > 0) {
    $genres = $dataGenres->fetchAll(PDO::FETCH_ASSOC);
}
$queryAuthors = "SELECT * FROM authors";
$dataAuthors = $conn->prepare($queryAuthors);
$dataAuthors->execute();
if ($dataAuthors->rowCount() > 0) {
    $authors = $dataAuthors->fetchAll(PDO::FETCH_ASSOC);
}
$queryBooks = "select b.name, b.description, b.images, a.author, g.genre from books b
join books_and_authors baa on b.id = baa.booksId
join authors a on a.id = baa.authorsId
join books_and_genres bag on b.id = bag.booksId
join genres g on bag.genresId = g.id";
$dataBooks = $conn->prepare($queryBooks);
$dataBooks->execute();
if ($dataBooks->rowCount() > 0) {
    $books = $dataBooks->fetchAll(PDO::FETCH_ASSOC);
}
?>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <form class="form-horizontal" method="GET">
                <div class="form-group d-flex">
                    <label class="col-lg-2 control-label">Книга</label>
                    <div class="col-lg-8">
                        <input id="target" type="text" class="form-control" name="name" placeholder="Книга">
                    </div>
                </div>
                <div class="form-group d-flex mt-2">
                    <label class="col-lg-2 control-label">Жанры</label>
                    <div class="col-lg-8">
                        <p>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Список жанров
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <?php
                                foreach ($genres as $genre) {
                                    ?>
                                    <div><input class="me-3" type="checkbox" name="genres"
                                                value="<?= $genre["id"] ?>"><?= $genre["genre"] ?></div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group d-flex  mt-2">
                    <label class="col-lg-2 control-label">Авторы</label>
                    <div class="col-lg-8">
                        <p>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                Список авторов
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample2">
                            <div class="card card-body">
                                <?php
                                foreach ($authors as $author) { ?>
                                    <div><input class="me-3" type="checkbox" name="authors"
                                                value="<?= $author["id"] ?>"><?= $author["author"] ?></div><?php
                                } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="books">
        <?php
        foreach ($books as $book) {
            ?>
            <div  class="row p-5">
                <div class="col-lg-4">
                    <img src="<?= $book['images'] ?>">
                </div>
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Название книги</h4>
                        <div><?= $book['name'] ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Жанр</h4>
                        <div><?= $book['genre'] ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Автор</h4>
                        <div><?= $book['author'] ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="me-5">Описание</h4>
                        <div class="text-end"><?= $book['description'] ?></div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>