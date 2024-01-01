<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <div class="accordion m-4" id="inbox-area">
        <!-- item -->
        <!-- <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#message1" aria-expanded="false" aria-controls="message1">
                    ユーザーID : 件名
                </button>
            </h2>
            <div id="message1" class="accordion-collapse collapse" data-bs-parent="#inbox-area">
                <div class="accordion-body">
                    ユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージユーザーからのメッセージ
                </div>
            </div>
        </div> -->
        <!-- item end -->
        <?php
        $i = 0;
        $stmt = $pdo->prepare('SELECT REPLY_FROM, TITLE, OVERVIEW FROM inquiry_table WHERE REPLY_TO IS NULL AND IDENTIFICATION = 1');
        $stmt->execute();
        foreach ($stmt as $row) {
            $i++;
            echo '<div class="accordion-item">';
            echo '<h2 class="accordion-header">';
            echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#message' . $i . '" aria-expanded="false" aria-controls="message' . $i . '">';
            echo htmlspecialchars($row['REPLY_FROM']) . ' : ' . htmlspecialchars($row['TITLE']);
            echo '</button>';
            echo '</h2>';
            echo '<div id="message' . $i . '" class="accordion-collapse collapse" data-bs-parent="#inbox-area">';
            echo '<div class="accordion-body">';
            echo htmlspecialchars($row['OVERVIEW']);
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        if (!$stmt->rowCount()) {
            echo '<p class="text-center">まだメッセージはありません</p>';
        }
        ?>
    </div>
</div>
    
<?php require 'footer.php'; ?>