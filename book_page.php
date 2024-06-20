<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php require_once 'config.php'; ?>
    <title>Страница книги</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container">
            <div class="sub-container sub-container2">
                <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    echo "<script>console.log('ID книги передается правильно: " . $id . "');</script>";
                    $adds = mysqli_query($conn, "SELECT * FROM `library` WHERE book_id = '$id'");
                }
                while ($row = mysqli_fetch_assoc($adds)) { ?>
                    <div class="image-container">
                        <img src="<?php echo $row['cover']; ?>" alt="Book Cover" class="book-cover" width="250" height="250">
                    </div>
                    <div class="book-info">
                        <p>Тип: <?php echo $row['type']; ?></p>
                        <p>Год выпуска: <?php echo $row['year']; ?></p>
                        <p>Автор: <?php echo $row['author']; ?></p>
                        <p>Количество страниц: <?php echo $row['size']; ?></p>
                    </div>
                <?php }
                ?>
            </div>
            <div class="sub-container sub-container1">
                <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $adds = mysqli_query($conn, "SELECT * FROM `library` WHERE book_id = '$id'");
                }
                while ($row = mysqli_fetch_assoc($adds)) { ?>
                    <div class="book-title">
                        <h2><?php echo $row['title']; ?></h2>
                        <hr>
                    </div>
                    <div class="book-synopsis">
                        <p><?php echo $row['description']; ?></p>
                        <hr>
                    </div>
                    <div class="book-tags">
                        <p>Жанры: <?php echo $row['genre1']; ?>, <?php echo $row['genre2']; ?>, <?php echo $row['genre3']; ?></p>
                    </div>
                    <div class="read-button">
                        <button id="readButton">Начать чтение</button>
                        <button id="orderButton">Заказать книгу</button>
                    </div>
                <?php }
                ?>
            </div>
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
            
        });

        function checkAuthorizationAndRead() {
            if(<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
                var userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
                
                var xhr = new XMLHttpRequest();
                var url = "check_user_book_status_read.php";
                var params = "userId=" + userId + "&bookId=<?php echo $_GET['id']; ?>";
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log("Условие на отсутствие книги работает не правильно");
                            window.location.href = "book_read.php?id=<?php echo $_GET['id']; ?>";
                        } else {
                            console.log("Условие на отсутствие книги работает правильно");
                            addUserBook(userId, <?php echo $_GET['id']; ?>);
                        }
                    }
                };
                xhr.send(params);
            } else {
                window.location.href = "book_read.php?id=<?php echo $_GET['id']; ?>";
            }
        }

        function addUserBook(userId, bookId) {
            var xhr = new XMLHttpRequest();
            var url = "add_user_book.php";
            var params = "userId=" + userId + "&bookId=" + bookId;
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    console.log("Книга успешно добавлена пользователю");
                    window.location.href = "book_read.php?id=" + bookId;
                }
            };
            xhr.send(params);
        }

        document.getElementById("readButton").addEventListener("click", checkAuthorizationAndRead);

        function checkAuthorizationAndOrder() {
            if(<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
                var userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
                
                var xhr = new XMLHttpRequest();
                var url = "check_user_book_status_order.php";
                var params = "userId=" + userId + "&bookId=<?php echo $_GET['id']; ?>";
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log("Условие на отсутствие книги работает не правильно");
                        } else {
                            console.log("Условие на отсутствие книги работает правильно");
                            addUserBookOrder(userId, <?php echo $_GET['id']; ?>);
                        }
                    }
                };
                xhr.send(params);
            }
        }

        function addUserBookOrder(userId, bookId) {
            var xhr = new XMLHttpRequest();
            var url = "add_user_book_order.php";
            var params = "userId=" + userId + "&bookId=" + bookId;
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    console.log("Книга успешно добавлена пользователю");
                }
            };
            xhr.send(params);
        }

        document.getElementById("orderButton").addEventListener("click", checkAuthorizationAndOrder);
            });
    </script>
</body>
</html>