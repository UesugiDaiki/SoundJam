<?php
session_start();
require 'server_connection.php';
require 'header.php';
?>

<div class="container">
    <form class="m-4" action="send_message.php" method="post">
        <div class="mb-3">
            <label for="address" class="form-label">宛先</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">件名</label>
            <input type="text" class="form-control" id="subject" name="subject">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">本文</label>
            <textarea class="form-control" id="body" rows="7" name="body"></textarea>
        </div>
        <input type="hidden" name="command" value="send-message">
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
</div>
    
<?php require 'footer.php'; ?>