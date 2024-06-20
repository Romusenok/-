<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php require_once 'config.php'; ?>
    <title>Страница для чтения книги</title>
    <style>
        .main-sub-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <!-- Основная часть -->
    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container">
            <?php
            function convertPdfToImages($pdfPath, $outputDir) {
                // Check if the output directory already exists
                if (is_dir($outputDir) && count(glob("$outputDir/*.jpg")) > 0) {
                    // If images already exist, return them without converting the PDF again
                    return glob("$outputDir/*.jpg");
                }

                if (!is_dir($outputDir)) {
                    mkdir($outputDir, 0777, true);
                }

                // Convert PDF to images using ImageMagick
                $command = "convert -density 150 $pdfPath $outputDir/page-%d.jpg";
                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception("Failed to convert PDF to images.");
                }

                return glob("$outputDir/*.jpg");
            }

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $adds = mysqli_query($conn, "SELECT * FROM `library` WHERE book_id = '$id'");

                while ($row = mysqli_fetch_assoc($adds)) {
                    $pdfPath = $row['pdf_link'];
                    $outputDir = "images/books/$id";
                    try {
                        $images = convertPdfToImages($pdfPath, $outputDir);
                        echo "<div class='book-page-container'>";
                        foreach ($images as $image) {
                            echo "<img class='book-page' src='$image' alt='PDF Page'>";
                        }
                        echo "</div>";
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            }
            ?>
        </div>
    </div>

    <!-- Подвал сайта -->
    <?php include 'footter.php'; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Promise.all([
            fetch('select_gener.js').then(response => response.text()),
            fetch('login_reg.js').then(response => response.text())
        ]).then(([scriptText1, scriptText2]) => {
            eval(scriptText1); // Выполнение первого скрипта
            eval(scriptText2); // Выполнение второго скрипта
        });
    });
    </script>
</body>
</html>
