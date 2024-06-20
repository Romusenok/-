<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php require_once 'config.php'; ?>
    <title>Книги по жанру</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <!-- Основная часть -->
    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container">
            <ul class="book-list">
            <?php
            if(isset($_GET['genre'])) {
                $genre = $_GET['genre'];
                $sql = "SELECT * FROM `library` WHERE genre1 = '$genre' OR genre2 = '$genre' OR genre3 = '$genre' ORDER BY book_id DESC";
            } elseif (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM `library` WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR genre1 LIKE '%$search%' OR genre2 LIKE '%$search%' OR genre3 LIKE '%$search%' ORDER BY book_id DESC";
            } elseif (isset($_GET['author'])) {
                $author = $_GET['author'];
                $sql = "SELECT * FROM `library` WHERE author LIKE '%$author%' ORDER BY book_id DESC";
            }


            $adds = mysqli_query($conn, $sql);

            if ($adds) {
                while ($row = mysqli_fetch_assoc($adds)) {
                    include 'process_genre.php';
                }
            } else {
                echo "Ошибка выполнения запроса: " . mysqli_error($conn);
            }
            ?>
            </ul>
        </div>
    </div>

    <?php include 'footter.php'; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Promise.all([
            fetch('select_gener.js').then(response => response.text()),
            fetch('login_reg.js').then(response => response.text())
        ]).then(([scriptText1, scriptText2, scriptText3]) => {
            eval(scriptText1);
            eval(scriptText2);
            var urlParams = new URLSearchParams(window.location.search);
            var searchQuery = urlParams.get('search');
        
            console.log('Поисковый запрос:', searchQuery);
            });
    });
    </script>
</body>
</html>
