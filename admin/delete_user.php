<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <!-- search -->
    <form action="delete_user.php" method="post" onSubmit="return check()">
        <div class="input-group mb-3 mt-4">
            <input type="text" class="form-control" name="words">
            <input type="hidden" name="command" value="delete-user-search">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                検索
            </button>
        </div>
    </form>

    <!-- posts -->
    <div class="list-group">
        <?php
        // 検索されたか
        if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete-user-search') {
            foreach ($stmt as $row) {
                echo '<form action="delete_user.php" method="post">';
                echo '<a href="http://localhost:8000/user/' . htmlspecialchars($row['id']) . '/" class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['USER_NAME']) . '</p>';
                echo '<input type="hidden" name="command" value="delete-user">';
                echo '<input type="hidden" name="user-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-danger">削除</button>';
                echo '</a>';
                echo '</form>';
            }

            if (!$stmt->rowCount()) {
                echo '<p class="text-center">一致する投稿はありません</p>';
            }
        } else {
            // 降順(最新)に取得
            $stmt = $pdo->prepare('SELECT * FROM user_table ORDER BY id DESC');
            $stmt->execute();

            foreach ($stmt as $row) {
                echo '<form action="delete_user.php" method="post">';
                echo '<a href="http://localhost:8000/user/' . htmlspecialchars($row['id']) . '/" class="list-group-item list-group-item-action d-flex justify-content-between">';
                echo '<p class="my-auto">' . htmlspecialchars($row['USER_NAME']) . '</p>';
                echo '<input type="hidden" name="command" value="delete-user">';
                echo '<input type="hidden" name="user-id" value="' . htmlspecialchars($row['id']) . '">';
                echo '<button type="submit" class="btn btn-outline-danger">削除</button>';
                echo '</a>';
                echo '</form>';
            }
        }
        ?>
    </div>
</div>

<script>
    function check() {
        if (window.confirm('送信してよろしいですか？')) {
            return true;
        } else {
            window.alert('キャンセルされました');
            return false;
        }
    }
</script>

<?php require 'footer.php'; ?>