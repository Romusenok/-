<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'config.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bxslider/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container">
            <div class="sub-container sub-container1">
                <div class="new-books-container">
                    <span class="widget-heading">
                        <h1>Новые книги</h1>
                        <hr>
                    </span>
                    <div class="block-inner">
                        <ul class="books-widget bxslider" id="bxslider-new">
                        <?php
                            $adds = mysqli_query($conn, "SELECT * FROM `library` ORDER BY book_id DESC LIMIT 5");
                            while ($row = mysqli_fetch_assoc($adds)) { ?>
                                <?php include 'book_card_slider.php'; ?>
                        <?php  }
                        ?>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="top-books-container">
                    <span class="widget-heading">
                        <h1>ТОП в разных жанрах</h1>
                        <hr>
                    </span>
                    <div class="block-inner">
                        <ul class="books-widget bxslider" id="bxslider-top" style="width: 150%; position: relative; transition-duration: 0.5s;">
                        <?php
                            $adds = mysqli_query($conn, "SELECT * FROM (
                                SELECT * FROM `library` ORDER BY views DESC
                            ) AS sorted_library
                            GROUP BY genre1, book_id
                            ORDER BY views DESC
                            LIMIT 5;");
                            while ($row = mysqli_fetch_assoc($adds)) { ?>
                                <?php include 'book_card_slider.php'; ?>
                        <?php  }
                        ?>  
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sub-container sub-container2">
                <div class="most-popular-book">
                    <span class="widget-heading">
                        <h1>Самый популярный</h1>
                        <hr>
                    </span>
                    <div class="block-inner">
                        <?php
                            $adds = mysqli_query($conn, "SELECT * FROM `library` ORDER BY views DESC LIMIT 1");
                            while ($row = mysqli_fetch_assoc($adds)) {
                        ?>
                            <?php include 'book_card_single.php'; ?>
                        <?php
                            }
                        ?>
                    </div>
                </div>
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
    });
    </script>
    </body>
</html>
