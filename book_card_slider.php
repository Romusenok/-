<li>
    <div class="bw-book-card" data-book-id="<?php echo htmlspecialchars($row['book_id']); ?>" data-views="<?php echo $row['views']; ?>">
        <div class="book-img">
            <a href="book_page.php?id=<?php echo htmlspecialchars($row['book_id']); ?>" title="<?php echo htmlspecialchars($row['title']); ?>" class="bw-img">
                <img src="<?php echo $row['cover']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="150" height="150">
            </a>
        </div>
        <div class="bw-title-wr">
            <a href="book_page.php?id=<?php echo htmlspecialchars($row['book_id']); ?>" class="bw-title" title="<?php echo htmlspecialchars($row['title']); ?>">
                <?php echo $row['title']; ?>
            </a>
            <br>
            <span class="bw-author"> 
                <a href="books_by_search.php?author=<?php echo urlencode($row['author']); ?>" class="author-link">
                    <?php echo $row['author']; ?>
                </a>
            </span>
        </div>
        <a href="books_by_search.php?genre=<?php echo urlencode($row['genre1']); ?>" class="bl-genre"><?php echo $row['genre1']; ?></a>
        <a href="books_by_search.php?genre=<?php echo urlencode($row['genre2']); ?>" class="bl-genre"><?php echo $row['genre2']; ?></a>
        <a href="books_by_search.php?genre=<?php echo urlencode($row['genre3']); ?>" class="bl-genre"><?php echo $row['genre3']; ?></a>
        <div class="select-book" style="display: none;"><?php echo $row['book_id']; ?></div>
        <span class="count-views" style="display: none;"><?php echo $row['views']; ?></span>
    </div>
</li>
