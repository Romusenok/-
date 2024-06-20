<ul class="bl-list">
    <li class="bl-item">
        <div class="book-img-square">
            <a href="book_page.php?id=<?php echo $row['book_id']; ?>">
                <img src="<?php echo $row['cover']; ?>" width="120" height="120">
            </a>
        </div>
        <div class="bl-info">
            <a href="book_page.php?id=<?php echo $row['book_id']; ?>" class="bl-title"><?php echo $row['title']; ?></a>
            <br>
            <span class="bl-author">
                <a href="books_by_search.php?author=<?php echo urlencode($row['author']); ?>">
                    <?php echo $row['author']; ?>
                </a>
            </span>
            <span class="bl-genres">
                <a href="books_by_search.php?genre=<?php echo urlencode($row['genre1']); ?>">
                    <?php echo $row['genre1']; ?>
                </a>
                <a href="books_by_search.php?genre=<?php echo urlencode($row['genre2']); ?>">
                    <?php echo $row['genre2']; ?>
                </a>
                <a href="books_by_search.php?genre=<?php echo urlencode($row['genre3']); ?>">
                    <?php echo $row['genre3']; ?>
                </a>
            </span>
        </div>
    </li>
</ul>
