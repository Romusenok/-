<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'config.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница пользователя</title>
    <!-- Подключение стилей BxSlider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bxslider/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" href="styles.css">
    <!-- Подключение jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Подключение скрипта BxSlider -->
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script>
      $(document).ready(function(){
        $(".bxslider").bxSlider({
            minSlides: 2,
            maxSlides: 3,
            slideWidth: 300,
            slideMargin: 30,
            touchEnabled: false,
        });
      });
    </script>

    <script>
    $(document).ready(function() {
        $('#profile_image_form').submit(function(event) {
            event.preventDefault(); // Предотвращаем стандартное поведение формы

            // Создаем объект FormData для отправки данных формы
            var formData = new FormData($(this)[0]);

            // Отправляем AJAX-запрос на сервер
            $.ajax({
                url: 'upload.php', // Путь к вашему PHP-скрипту
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Выводим сообщение об успешной загрузке изображения профиля
                    alert(response);
                },
                error: function(xhr, status, error) {
                    // Выводим сообщение об ошибке
                    alert('Произошла ошибка при загрузке изображения профиля: ' + xhr.responseText);
                }
            });
        });
    });
    </script>
    
    <script>
        function logoutUser() {
            // Выполняем AJAX запрос к logout.php
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "logout.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    window.location.href = "index.php";
                }
            };
            xhr.send();
        }

        function closeProfileImageModal() {
                profileImageModal.style.display = "none";
            }
    </script>    
</head>
<body>
    <?php include 'navigation.php'; ?>

    <!-- Модальное окно -->
    <div id="profileImageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeProfileImageModal()">&times;</span>
            <h2>Загрузить новое изображение</h2>
            <form id="profile_image_form" enctype="multipart/form-data">
                <input type="file" name="profile_image" id="profile_image">
                <input type="submit" value="Загрузить изображение профиля">
            </form>
    </div>
    </div>

    <!-- Основная часть -->
    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container">
            <div class="sub-container sub-container2">
                <?php
                    if(isset($_SESSION['user_id'])){
                        $id = $_SESSION['user_id'];
                        echo "<script>console.log('ID пользователя передается правильно: " . $id . "');</script>";
                        $adds = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$id'");
                    }
                    echo "<script>console.log('ID пользователя передается правильно: " . $id . "');</script>";
                    while ($row = mysqli_fetch_assoc($adds)) { ?>
                        <div class="image-container">
                            <img id="profileImage" src="<?php echo $row['avatar']; ?>" alt="Profile Image" width="250" height="250">
                        </div>
                        <div class="user-info">
                            <p>Имя пользователя: <?php echo $row['username']; ?></p>
                            <p>Дата регистрации: <?php echo $row['registration_date']; ?></p>
\
                            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                <button onclick="window.location.href = 'adminpage.php';">Администрирование</button>
                            <?php endif; ?>
                            <?php if(isset($_SESSION['is_librarian']) && $_SESSION['is_librarian']): ?>
                                <button onclick="window.location.href = 'librarian_page.php';">Проверка заказов</button>
                            <?php endif; ?>
                            <button onclick='logoutUser()'>Выход</button>
                        </div>
                    <?php }
                    ?>
            </div>
            <div class="sub-container sub-container1">
            <div class="history-read-container">
                    <span class="widget-heading">
                        <p>Прочитанные книги</p>
                        <hr>
                    </span>
                    <div class="block-inner">
                        <ul class="books-widget bxslider" id="bxslider-new">
                        <?php
                            $adds = mysqli_query($conn, "SELECT library.*, user_books.status, user_books.date_added
                            FROM user_books
                            JOIN library ON user_books.book_id = library.book_id
                            WHERE user_books.user_id = $id
                            AND user_books.status = 'read'");
                            while ($row = mysqli_fetch_assoc($adds)) { ?>
                                <?php include 'book_card_slider.php'; ?>
                        <?php  }
                        ?>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="history-order-container">
                    <span class="widget-heading">
                        <p>История заказов</p>
                        <hr>
                    </span>
                    <div class="block-inner">
                        <ul class="books-widget bxslider" id="bxslider-top" style="width: 150%; position: relative; transition-duration: 0.5s;">
                        <?php
                            $adds = mysqli_query($conn, "SELECT library.*, user_books.status, user_books.date_added
                            FROM user_books
                            JOIN library ON user_books.book_id = library.book_id
                            WHERE user_books.user_id = $id
                            AND user_books.status = 'order' OR user_books.status = 'completed'");
                            while ($row = mysqli_fetch_assoc($adds)) { ?>
                                <?php include 'book_card_slider.php'; ?>
                        <?php  }
                        ?>  
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Подвал сайта -->
    <?php include 'footter.php'; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Promise.all([
            fetch('select_gener.js').then(response => response.text()),
            fetch('login_reg.js').then(response => response.text())
        ]).then(([scriptText1, scriptText2, scriptText3]) => {
            eval(scriptText1); // Выполнение первого скрипта
            eval(scriptText2); // Выполнение второго скрипта
            
        });
        // Получаем ссылки на модальные окна и изображение профиля
        var profileImageModal = document.getElementById("profileImageModal");
        var profileImage = document.getElementById("profileImage");

        // Добавляем обработчики событий на изображение профиля для открытия соответствующих модальных окон
        profileImage.addEventListener("click", function() {
                profileImageModal.style.display = "block";
            });

    });
    </script>
</body>