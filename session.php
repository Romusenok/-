<?php
session_start();

require_once 'config.php';

if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    echo "<script>console.log('ID текущего пользователя: " . $userId . "');</script>";
    
    $query = "SELECT username FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        
        $userPageUrl = "user_page.php?id=" . $userId;
        
        echo "<script>";
        echo "var loggedInUser = document.getElementById('loggedInUser');";
        echo "loggedInUser.innerHTML = \"<a href='" . $userPageUrl . "'>" . $username . "</a>\";";
        echo "loggedInUser.style.display = 'inline';";
        echo "var loginButton = document.getElementById('loginButton');";
        echo "var registerButton = document.getElementById('registerButton');";
        echo "loginButton.style.display = 'none';";
        echo "registerButton.style.display = 'none';";
        echo "</script>";
    } else {
        echo "<script>console.log('Имя пользователя не найдено');</script>";
    }
} else {
    echo "<script>console.log('Пользователь не авторизован');</script>";
}
?>