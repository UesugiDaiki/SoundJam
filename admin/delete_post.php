<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <!-- search -->
    <form action="delete_post.php" method="post">
        <div class="input-group mb-3 mt-4">
            <input type="text" class="form-control" name="words">
            <input type="hidden" name="command" value="delete-post-search">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">検索</button>
        </div>
    </form>

    <!-- posts -->
    <div class="list-group">
        <?php
        // 検索されたか
        if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete-post-search') {
            foreach ($stmt as $row) {
                echo '<form action="delete_post.php" method="post">';
                echo '<a target="_blank" href="http://localhost:8000/post/' . htmlspecialchars($row['id']) . '/" class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['TITLE']) . '</p>';
                echo '<input type="hidden" name="command" value="delete-post">';
                echo '<input type="hidden" name="post-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-danger">削除</button>';
                echo '</a>';
                echo '</form>';
            }

            if (!$stmt->rowCount()) {
                echo '<p class="text-center">一致する投稿はありません</p>';
            }
        } else {
            $stmt = $pdo->prepare('SELECT * FROM post_table ORDER BY DATES DESC');
            $stmt->execute();

            foreach ($stmt as $row) {
                echo '<form action="delete_post.php" method="post">';
                echo '<a target="_blank" href="http://localhost:8000/post/' . htmlspecialchars($row['id']) . '/" class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['TITLE']) . '</p>';
                echo '<input type="hidden" name="command" value="delete-post">';
                echo '<input type="hidden" name="post-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-danger">削除</button>';
                echo '</a>';
                echo '</form>';
            }
        }
        ?>
    </div>
</div>

<?php require 'footer.php'; ?>