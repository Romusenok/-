<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">×</span>

    <div id="loginForm" style="display: none;">
      <form id="loginForm">
        <h2>Вход</h2>
        <label for="username">Логин:</label>
        <input type="text" id="username" placeholder="Логин" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" placeholder="Пароль" required>
        <br>
        <button type="submit" id="loginSubmit">Войти</button>
      </form>
    </div>

    <div id="registerFormContainer">
        <form id="registerForm">
        <h2>Регистрация</h2>
        <label for="regUsername">Логин</label>
        <input type="text" id="regUsername" name="username" placeholder="Логин" required>

        <label for="regPassword">Пароль</label>
        <input type="password" id="regPassword" name="password" placeholder="Пароль" required>

        <label for="firstName">Имя</label>
        <input type="text" id="firstName" name="firstName" placeholder="Имя" required>

        <label for="lastName">Фамилия</label>
        <input type="text" id="lastName" name="lastName" placeholder="Фамилия" required>

        <label for="middleName">Отчество</label>
        <input type="text" id="middleName" name="middleName" placeholder="Отчество" required>

        <label for="phone">Телефон</label>
        <input type="text" id="phone" name="phone" placeholder="Телефон" required maxlength="11" oninput="this.value = this.value.replace(/\D/g, '')">

        <label for="passportSeries">Серия паспорта</label>
        <input type="text" id="passportSeries" name="passportSeries" placeholder="Серия паспорта" required maxlength="4" oninput="this.value = this.value.replace(/\D/g, '')">

        <label for="passportNumber">Номер паспорта</label>
        <input type="text" id="passportNumber" name="passportNumber" placeholder="Номер паспорта" required maxlength="6" oninput="this.value = this.value.replace(/\D/g, '')">

        <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
  </div>
</div>
<div class="top-container">
        <div class="left-container">
            <div class="ln_topbar_nav">
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="#!" class="in-topbar-genre-link" id="select_genre">Жанры</a></li>
                    <li><a href="">Конкурсы</a></li>
                    <li><a href="">Блоги</a></li>
                    <li><a href="">Моя библиотека</a></li>
                </ul>
            </div>
            <div id="genreContainer" style = "display: none; ">
                <ul class="genre-list">
                    <li><a href="books_by_search.php?genre=Постапокалиптика" class="in-topbar-genre-link" id="select_genre">Постапокалиптика</a></li>
                    <li><a href="books_by_search.php?genre=Детектив" class="in-topbar-genre-link" id="select_genre">Детектив</a></li>
                    <li><a href="books_by_search.php?genre=Научная фантастика" class="in-topbar-genre-link" id="select_genre">Научная фантастика</a></li>
                    <li><a href="books_by_search.php?genre=Антиутопия" class="in-topbar-genre-link" id="select_genre">Антиутопия</a></li>
                    <li><a href="books_by_search.php?genre=Психоделика" class="in-topbar-genre-link" id="select_genre">Психоделика</a></li>
                    <li><a href="books_by_search.php?genre=Эзотерика" class="in-topbar-genre-link" id="select_genre">Эзотерика</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 7" class="in-topbar-genre-link" id="select_genre">Жанр 7</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 8" class="in-topbar-genre-link" id="select_genre">Жанр 8</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 9" class="in-topbar-genre-link" id="select_genre">Жанр 9</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 10" class="in-topbar-genre-link" id="select_genre">Жанр 10</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 11" class="in-topbar-genre-link" id="select_genre">Жанр 11</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 12" class="in-topbar-genre-link" id="select_genre">Жанр 12</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 13" class="in-topbar-genre-link" id="select_genre">Жанр 13</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 14" class="in-topbar-genre-link" id="select_genre">Жанр 14</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 15" class="in-topbar-genre-link" id="select_genre">Жанр 15</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 16" class="in-topbar-genre-link" id="select_genre">Жанр 16</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 17" class="in-topbar-genre-link" id="select_genre">Жанр 17</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 18" class="in-topbar-genre-link" id="select_genre">Жанр 18</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 19" class="in-topbar-genre-link" id="select_genre">Жанр 19</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 20" class="in-topbar-genre-link" id="select_genre">Жанр 20</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 21" class="in-topbar-genre-link" id="select_genre">Жанр 21</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 22" class="in-topbar-genre-link" id="select_genre">Жанр 21</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 23" class="in-topbar-genre-link" id="select_genre">Жанр 22</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 24" class="in-topbar-genre-link" id="select_genre">Жанр 23</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 25" class="in-topbar-genre-link" id="select_genre">Жанр 24</a></li>
                    <li><a href="books_by_search.php?genre=Жанр 25" class="in-topbar-genre-link" id="select_genre">Жанр 25</a></li>
                </ul>
            </div>
        </div>

        <div class="middle-container">
            <form class="search-form" id="search-form" action="books_by_search.php" method="get">
                <input type="text" autocomplete="off" name="search" placeholder="Найти" data-not-found="Данные не найдены">
                <button type="submit">Поиск</button>
            </form>
        </div>

        <div class="right-container">
            <div class="ln_topbar_login" id="loginContainer">
                <span id="loggedInUser" style="display: none;"></span>

                <a href="#!" class="ln_topbar_nav-lnk" id="loginButton">Вход</a>
                <a href="#!" class="ln_btn ln_btn-brand ln_topbar-reg" id="registerButton">Регистрация</a>
            </div>
            <?php include 'session.php'; ?>
        </div>
    </div>