<?php session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php require_once 'config.php'; ?>
    <title>Страница администратора</title>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <!-- Основная часть -->
    <div class="main-container">
        <div class="banner-container">
            <img src="banner.jpg" width="100%">
        </div>
        <div class="main-sub-container-2">
            <div class="user-table-container">
                <?php
                    $queryTotalUsers = "SELECT COUNT(*) AS totalUsers FROM users";
                    $resultTotalUsers = mysqli_query($conn, $queryTotalUsers);
                    $totalUsers = mysqli_fetch_assoc($resultTotalUsers)['totalUsers'];

                    $queryRegularUsers = "SELECT COUNT(*) AS regularUsers FROM users WHERE admin = 0";
                    $resultRegularUsers = mysqli_query($conn, $queryRegularUsers);
                    $regularUsers = mysqli_fetch_assoc($resultRegularUsers)['regularUsers'];

                    $queryAdminUsers = "SELECT COUNT(*) AS adminUsers FROM users WHERE admin = 1";
                    $resultAdminUsers = mysqli_query($conn, $queryAdminUsers);
                    $adminUsers = mysqli_fetch_assoc($resultAdminUsers)['adminUsers'];

                    $querylibrarianUsers = "SELECT COUNT(*) AS librarianUsers FROM users WHERE admin = 2";
                    $resultlibrarianUsers = mysqli_query($conn, $querylibrarianUsers);
                    $librarianUsers = mysqli_fetch_assoc($resultlibrarianUsers)['librarianUsers'];
                ?>

                <p>Всего пользователей: <?php echo $totalUsers; ?></p>
                <p>Обычные пользователи: <?php echo $regularUsers; ?></p>
                <p>Администраторы: <?php echo $adminUsers; ?></p>
                <p>Библиотекари: <?php echo $librarianUsers; ?></p>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="startId">Начальный ID:</label>
                    <input type="text" id="startId" name="startId">
                    <label for="endId">Конечный ID:</label>
                    <input type="text" id="endId" name="endId">
                    <input type="submit" value="Показать">
                </form>
                <br>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $startId = $_POST['startId'] ?? 0;
                        $endId = $_POST['endId'] ?? PHP_INT_MAX;

                            $query = "SELECT * FROM users WHERE id BETWEEN $startId AND $endId";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo "<table border='1'>";
                                    echo "<tr><th>ID</th><th>Username</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Номер телефона</th><th>Паспорт серия</th><th>Паспорт номер</th><th>Роль</th><th>Действия</th></tr>";
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td class='first-name' data-encrypted='" . htmlspecialchars($row['firstName']) . "'></td>";
                                        echo "<td class='last-name' data-encrypted='" . htmlspecialchars($row['lastName']) . "'></td>";
                                        echo "<td class='middle-name' data-encrypted='" . htmlspecialchars($row['middleName']) . "'></td>";
                                        echo "<td class='phone' data-encrypted='" . htmlspecialchars($row['phone']) . "'></td>";
                                        echo "<td class='passportSeries' data-encrypted='" . htmlspecialchars($row['passportSeries']) . "'></td>";
                                        echo "<td class='passportNumber' data-encrypted='" . htmlspecialchars($row['passportNumber']) . "'></td>";
                                        echo '<td>' . 
                                            ($row['admin'] == 0 ? "Пользователь" : 
                                            ($row['admin'] == 1 ? "Администратор" : 
                                            ($row['admin'] == 2 ? "Библиотекарь" : "Неизвестный"))) . 
                                            '</td>';
                                        echo "<td>";
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='userId' value='" . $row['id'] . "'>";
                                        echo "<input type='text' name='username' value='" . $row['username'] . "'>";
                                        echo "<select name='admin'>";
                                        echo "<option value='0'" . ($row['admin'] == 0 ? " selected" : "") . ">Пользователь</option>";
                                        echo "<option value='1'" . ($row['admin'] == 1 ? " selected" : "") . ">Администратор</option>";
                                        echo "<option value='2'" . ($row['admin'] == 2 ? " selected" : "") . ">Библиотекарь</option>";
                                        echo "</select>";
                                        echo "<input type='submit' name='editUser' value='Сохранить'>";
                                        echo "<input type='submit' name='deleteUser' value='Удалить'>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "Пользователей в указанном диапазоне нет.";
                                }
                            } else {
                                echo "Ошибка в SQL запросе: " . mysqli_error($conn);
                            }
                    }
                ?>
                <?php 
                    if (isset($_POST['editUser'])) {
                        $userId = $_POST['userId'];
                        $username = $_POST['username'];
                        $admin = $_POST['admin'];

                        mysqli_query($conn, "UPDATE `users`
                            SET `username`='$username', `admin`='$admin'
                            WHERE `id`='$userId'");
                        header("Location: ".$_SERVER['PHP_SELF']);
                        exit();
                    }

                    if (isset($_POST['deleteUser'])) {
                        $userId = $_POST['userId'];
                    
                        
                        mysqli_query($conn, "DELETE FROM `user_books` WHERE `user_id`='$userId'");
                    
                        
                        mysqli_query($conn, "DELETE FROM `users` WHERE `id`='$userId'");
                    
                        header("Location: ".$_SERVER['PHP_SELF']);
                        exit();
                    }
                ?>
            </div>
            <br>
            <div class="books-table-container">
                <?php 
                $queryTotalBooks = "SELECT COUNT(*) AS totalBooks FROM library";
                $resultTotalBooks = mysqli_query($conn, $queryTotalBooks);
                $totalBooks = mysqli_fetch_assoc($resultTotalBooks)['totalBooks'];

                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="genreFilter">Выберите жанр:</label>
                    <select name="genreFilter" id="genreFilter">
                        <option value="">Все жанры</option>
                        <option value="Постапокалиптика">Постапокалиптика</option>
                        <option value="Психоделика">Психоделика</option>
                        <option value="Детектив">Детектив</option>
                        <option value="Эзотерика">Эзотерика</option>
                        <option value="Научная фантастика">Научная фантастика</option>
                        <option value="Антиутопия">Антиутопия</option>
                        
                    </select>
                    <input type="submit" value="Фильтровать">
                </form>

                <p>Всего книг: <?php echo $totalBooks; ?></p>

                <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['genreFilter'])) {
                    $selectedGenre = $_POST['genreFilter'];

                    $genreCondition = "";
                    if (!empty($selectedGenre)) {
                        $genreCondition = "WHERE genre1='$selectedGenre' OR genre2='$selectedGenre' OR genre3='$selectedGenre'";
                    }

                    $queryBooks = "SELECT * FROM library $genreCondition";
                    $resultBooks = mysqli_query($conn, $queryBooks);

                    if ($resultBooks) {
                        if (mysqli_num_rows($resultBooks) > 0) {
                            echo "<table border='1'>";
                            echo "<tr><th>Book ID</th><th>Title</th><th>Cover</th><th>Author</th><th>Description</th><th>Year</th><th>Genre 1</th><th>Genre 2</th><th>Genre 3</th><th>PDF Link</th><th>Type</th><th>Size</th><th>Actions</th></tr>";
                            while ($row = mysqli_fetch_assoc($resultBooks)) {
                                echo "<tr>";
                                echo "<td>" . $row['book_id'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['cover'] . "</td>";
                                echo "<td>" . $row['author'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['year'] . "</td>";
                                echo "<td>" . $row['genre1'] . "</td>";
                                echo "<td>" . $row['genre2'] . "</td>";
                                echo "<td>" . $row['genre3'] . "</td>";
                                echo "<td>" . $row['pdf_link'] . "</td>";
                                echo "<td>" . $row['type'] . "</td>";
                                echo "<td>" . $row['size'] . "</td>";
                                echo "<td>";
                                echo "<form method='POST'>";
                                echo "<input type='hidden' name='bookId' value='" . $row['book_id'] . "'>";
                                echo "<input type='text' name='title' value='" . $row['title'] . "' placeholder='Название'>";
                                echo "<input type='text' name='cover' value='" . $row['cover'] . "' placeholder='Ссылка на обложку'>";
                                echo "<input type='text' name='author' value='" . $row['author'] . "' placeholder='Автор'>";
                                echo "<input type='text' name='description' value='" . $row['description'] . "' placeholder='Описание'>";
                                echo "<input type='text' name='year' value='" . $row['year'] . "' placeholder='Год'>";
                                echo "<input type='text' name='genre1' value='" . $row['genre1'] . "' placeholder='Жанр 1'>";
                                echo "<input type='text' name='genre2' value='" . $row['genre2'] . "' placeholder='Жанр2'>";
                                echo "<input type='text' name='genre3' value='" . $row['genre3'] . "' placeholder='Жанр3'>";
                                echo "<input type='text' name='pdf_link' value='" . $row['pdf_link'] . "' placeholder='Ссылка на PDF'>";
                                echo "<input type='text' name='type' value='" . $row['type'] . "' placeholder='Тип'>";
                                echo "<input type='text' name='size' value='" . $row['size'] . "' placeholder='Размер'>";
                                echo "<input type='submit' name='editBook' value='Edit'>";
                                echo "<input type='submit' name='deleteBook' value='Delete'>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Книги по выбранному жанру не найдены.";
                        }
                    } else {
                        echo "Ошибка в SQL запросе: " . mysqli_error($conn);
                    }
                }
                ?>
                <?php
                    if (isset($_POST['editBook'])) {
                        $bookId = $_POST['bookId'];
                        $title = $_POST['title'];
                        $cover = $_POST['cover'];
                        $author = $_POST['author'];
                        $description = $_POST['description'];
                        $year = !empty($_POST['year']) ? $_POST['year'] : 0;
                        $genre1 = $_POST['genre1'];
                        $genre2 = $_POST['genre2'];
                        $genre3 = $_POST['genre3'];
                        $pdfLink = $_POST['pdf_link'];
                        $type = $_POST['type'];
                        $size = $_POST['size'];
                    
                        $updateQuery = "UPDATE library SET title='$title', author='$author', cover='$cover', description='$description', year='$year', genre1='$genre1', genre2='$genre2', genre3='$genre3', pdf_link='$pdfLink', type='$type', size='$size' WHERE book_id='$bookId'";
                        $updateResult = mysqli_query($conn, $updateQuery);
                    
                        if ($updateResult) {
                            echo "Информация о книге успешно обновлена.";
                        } else {
                            echo "Ошибка при обновлении информации о книге: " . mysqli_error($conn);
                        }
                    }                    

                    if (isset($_POST['deleteBook'])) {
                        $bookId = $_POST['bookId'];
                    
                        // Удаление связанных записей из таблицы user_books
                        $deleteUserBooksQuery = "DELETE FROM user_books WHERE book_id='$bookId'";
                        $deleteUserBooksResult = mysqli_query($conn, $deleteUserBooksQuery);
                    
                        // Проверка, успешно ли удалены связанные записи
                        if ($deleteUserBooksResult) {
                            // Удаление записи из таблицы library
                            $deleteLibraryQuery = "DELETE FROM library WHERE book_id='$bookId'";
                            $deleteLibraryResult = mysqli_query($conn, $deleteLibraryQuery);
                    
                            if ($deleteLibraryResult) {
                                echo "Книга успешно удалена.";
                            } else {
                                echo "Ошибка при удалении книги: " . mysqli_error($conn);
                            }
                        } else {
                            echo "Ошибка при удалении связанных записей: " . mysqli_error($conn);
                        }
                    }
                ?>
                <br>
                <h3>Добавить новую книгу</h3>
                <form class="add-book-form" action="add_book.php" method="post">
                    <label for="title">Название:</label>
                    <input type="text" id="title" name="title" required>
                    <br>
                    <label for="cover">Ссылка на обложку:</label>
                    <input type="text" id="cover" name="cover" required>
                    <br>
                    <label for="author">Автор:</label>
                    <input type="text" id="author" name="author" required>
                    <br>
                    <label for="description">Описание:</label>
                    <textarea id="description" name="description" required></textarea>
                    <br>
                    <label for="year">Год:</label>
                    <input type="number" id="year" name="year" required>
                    <br>
                    <label for="genre1">Жанр 1:</label>
                    <input type="text" id="genre1" name="genre1" required>
                    <br>
                    <label for="genre2">Жанр 2 (необязательно):</label>
                    <input type="text" id="genre2" name="genre2">
                    <br>
                    <label for="genre3">Жанр 3 (необязательно):</label>
                    <input type="text" id="genre3" name="genre3">
                    <br>
                    <label for="pdf_link">Ссылка на PDF:</label>
                    <input type="text" id="pdf_link" name="pdf_link" required>
                    <br>
                    <label for="type">Тип:</label>
                    <input type="text" id="type" name="type" required>
                    <br>
                    <label for="size">Размер:</label>
                    <input type="text" id="size" name="size" required>
                    <br>
                    <input type="submit" value="Добавить книгу">
                </form>
                <br>

                <form id="status-filter-form">
                    <label for="status">Фильтр по статусу заказа:</label>
                    <select id="status" name="status">
                        <option value="all">Все</option>
                        <option value="order">Не обработаны</option>
                        <option value="approved">Одобрены</option>
                        <option value="rejected">Отклонены</option>
                        <option value="completed">Завершены</option>
                        <option value="overdue">Просроченные</option>
                    </select>
                    <button type="button" id="filter-btn">Применить фильтр</button>
                </form>

                <div class="ordered-books-table" id="ordered-books-table">
                    <?php                 
                        $queryOrderedBooks = "
                            SELECT ub.id, u.username, u.firstName, u.lastName, u.middleName, l.title, ub.date_added, ub.rent_date, ub.status
                            FROM user_books ub
                            JOIN users u ON ub.user_id = u.id
                            JOIN library l ON ub.book_id = l.book_id
                            WHERE ub.status != 'read'
                            ORDER BY ub.id ASC
                        ";
                        $resultOrderedBooks = mysqli_query($conn, $queryOrderedBooks);

                        if ($resultOrderedBooks) {
                            if (mysqli_num_rows($resultOrderedBooks) > 0) {
                                echo '<table>';
                                echo '<tr><th>ID заказа</th><th>Логин</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Книга</th><th>Дата заказа</th><th>Дата аренды</th><th>Статус</th><th>Действия</th></tr>';

                                while ($row = mysqli_fetch_assoc($resultOrderedBooks)) {
                                    $isOverdue = false;
                                    if ($row['rent_date'] && $row['status'] === 'approved') {
                                        $currentDate = new DateTime();
                                        $rentDate = new DateTime($row['rent_date']);
                                        if ($currentDate > $rentDate) {
                                            $isOverdue = true;
                                            $row['status'] = 'overdue';

                                            $orderId = $row['id'];
                                            $updateQuery = "UPDATE user_books SET status = 'overdue' WHERE id = $orderId";
                                            mysqli_query($conn, $updateQuery);
                                        }
                                    }

                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['username'] . '</td>';
                                    echo '<td class="first-name" data-encrypted="' . htmlspecialchars($row['firstName']) . '"></td>';
                                    echo '<td class="last-name" data-encrypted="' . htmlspecialchars($row['lastName']) . '"></td>';
                                    echo '<td class="middle-name" data-encrypted="' . htmlspecialchars($row['middleName']) . '"></td>';
                                    echo '<td>' . $row['title'] . '</td>';
                                    echo '<td>' . $row['date_added'] . '</td>';
                                    echo '<td>' . ($row['rent_date'] ? $row['rent_date'] : 'Книга не арендована') . '</td>';
                                    echo '<td>' . $row['status'] . '</td>';
                                    echo '<td>';

                                    $userId = $row['user_id'];
                                    $queryUserOverdue = "SELECT COUNT(*) as overdue_count FROM user_books WHERE user_id = '$userId' AND status = 'overdue'";
                                    $resultUserOverdue = mysqli_query($conn, $queryUserOverdue);
                                    $hasOverdue = false;

                                    if ($resultUserOverdue) {
                                        $rowUserOverdue = mysqli_fetch_assoc($resultUserOverdue);
                                        if ($rowUserOverdue['overdue_count'] > 0) {
                                            $hasOverdue = true;
                                        }
                                    } else {
                                        echo 'Ошибка при выполнении запроса на просроченные заказы: ' . mysqli_error($conn);
                                    }

                                    if ($row['status'] === 'order') {
                                        if ($hasOverdue) {
                                            echo '<button disabled>Принять</button>';
                                        } else {
                                            echo '<button class="approve-btn" data-id="' . $row['id'] . '">Принять</button>';
                                        }
                                        echo '<button class="reject-btn" data-id="' . $row['id'] . '">Отказать</button>';
                                    } elseif ($row['status'] === 'approved' || $row['status'] === 'overdue') {
                                        echo '<button class="complete-btn" data-id="' . $row['id'] . '">Завершить</button>';
                                    }

                                    echo '</td>';
                                    echo '</tr>';
                                }

                                echo '</table>';
                            } else {
                                echo '<p>Нет заказанных книг для выбранного статуса.</p>';
                            }
                        } else {
                            echo '<p>Ошибка выполнения запроса: ' . mysqli_error($conn) . '</p>';
                        }
                    ?>
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

    <script>
        $(document).ready(function() {
            $('#filter-btn').click(function() {
                var status = $('#status').val();
                $.ajax({
                    url: 'filter_orders.php',
                    type: 'GET',
                    data: { status: status },
                    success: function(response) {
                        $('#ordered-books-table').html(response);
                    },
                    error: function(xhr, status, error) {
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.first-name, .last-name, .middle-name').each(function() {
                const encryptedData = $(this).data('encrypted');
                const cell = $(this);

                $.post('decrypt.php', { data: JSON.stringify({ value: encryptedData }) }, function(response) {
                    const result = JSON.parse(response);
                    cell.text(result.value);
                });
            });

            $('.approve-btn').on('click', function() {
                const id = $(this).data('id');
                const days = prompt("Введите количество дней аренды:");

                if (days) {
                    $.post('update_order.php', { action: 'approve', id: id, days: days }, function(response) {
                        alert(response.message);
                        location.reload();
                    }, 'json');
                }
            });

            $('.reject-btn').on('click', function() {
                const id = $(this).data('id');

                $.post('update_order.php', { action: 'reject', id: id }, function(response) {
                    alert(response.message);
                    location.reload();
                }, 'json');
            });

            $('.complete-btn').on('click', function() {
                const id = $(this).data('id');

                $.post('update_order.php', { action: 'complete', id: id }, function(response) {
                    alert(response.message);
                    location.reload();
                }, 'json');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.first-name, .last-name, .middle-name, .phone, .passportSeries, .passportNumber').each(function() {
                const encryptedData = $(this).data('encrypted');
                const cell = $(this);

                $.ajax({
                    type: 'POST',
                    url: 'decrypt.php',
                    data: JSON.stringify({ value: encryptedData }),
                    contentType: 'application/json',
                    success: function(response) {
                        const result = JSON.parse(response);
                        cell.text(result.value);
                    }
                });
            });
        });
    </script>
</body>