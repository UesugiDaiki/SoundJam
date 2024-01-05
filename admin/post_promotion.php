<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <!-- search -->
    <form action="post_promotion.php" method="post">
        <div class="input-group mb-3 mt-4">
            <input type="text" class="form-control" name="words">
            <input type="hidden" name="command" value="promotion-search">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">検索</button>
        </div>
    </form>

    <!-- posts -->
    <div class="list-group">
        <?php
        // 検索されたか
        if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'promotion-search') {
            foreach($stmt as $row) {
                echo '<form action="post_promotion.php" method="post">';
                echo '<a class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['TITLE']) . '</p>';
                echo '<input type="hidden" name="command" value="post-promotion">';
                echo '<input type="hidden" name="post-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-success">許可</button>';
                echo '</a>';
                echo '</form>';
            }
            
            if (!$stmt->rowCount()) {
                echo '<p class="text-center">一致する申請はありません</p>';
            }
        } else {
            $stmt = $pdo->prepare('SELECT * FROM post_table WHERE IS_PROMOTION = 1 ORDER BY DATES DESC');
            $stmt->execute();

            foreach($stmt as $row) {
                echo '<form action="post_promotion.php" method="post">';
                echo '<a class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['TITLE']) . '</p>';
                echo '<input type="hidden" name="command" value="post-promotion">';
                echo '<input type="hidden" name="post-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-success">許可</button>';
                echo '</a>';
                echo '</form>';
            }

            if (!$stmt->rowCount()) {
                echo '<p class="text-center">申請はありません</p>';
            }
        }
        ?>
    </div>
</div>

<?php require 'footer.php'; ?>