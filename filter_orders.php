<?php
require_once 'config.php';

$statusFilter = $_GET['status'] ?? 'all';

$statusCondition = "WHERE ub.status != 'read'";
if ($statusFilter !== 'all') {
    $statusCondition = "WHERE ub.status = '$statusFilter'";
}

$queryOrderedBooks = "
    SELECT ub.id, u.username, u.firstName, u.lastName, u.middleName, l.title, ub.date_added, ub.rent_date, ub.status
    FROM user_books ub
    JOIN users u ON ub.user_id = u.id
    JOIN library l ON ub.book_id = l.book_id
    $statusCondition
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
                        console.error('Ошибка при выполнении AJAX-запроса:', error);
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
            $('.first-name, .last-name, .middle-name').each(function() {
                const encryptedData = $(this).data('encrypted');
                const cell = $(this);

                console.log('Encrypted data to send:', encryptedData);

                $.ajax({
                    type: 'POST',
                    url: 'decrypt.php',
                    data: JSON.stringify({ value: encryptedData }),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Response from decrypt.php:', response);
                        const result = JSON.parse(response);
                        cell.text(result.value);
                    }
                });
            });
        });
    </script>