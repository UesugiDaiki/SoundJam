<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <!-- ユーザー管理 -->
        <div class="w-50 m-4 p-2 bg-body-secondary rounded">
            <h4 class="text-center mb-4">ユーザー管理</h4>
            <p><a href="send_message.php" class="link-dark link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">メッセージ送信</a></p>
            <p><a href="inbox.php" class="link-dark link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">受信箱</a></p>
        </div>
        <!-- 投稿管理 -->
        <div class="w-50 m-4 p-2 bg-body-secondary rounded">
            <h4 class="text-center mb-4">投稿管理</h4>
            <p><a href="post_promotion.php" class="link-dark link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">プロモーション投稿</a></p>
            <p><a href="delete_post.php" class="link-dark link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">投稿削除</a></p>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>