<?php
session_start();
if (isset($_REQUEST['command'])) {
    if ($_REQUEST['command'] == 'logout') {
        unset($_SESSION['soundjam_admin']);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>SoundJam | admin login</title>
</head>
<body>
    <h1>SoundJam 管理者ログイン</h1>

    <form method="POST" action="index.php">
        <label>ユーザー名: <input type="text" name="id"></label><br>
        <label>パスワード: <input type="password" name="password"></label><br>
        <input type="hidden" name="command" value="login">
        <input type="submit" value="ログイン">
    </form>
</body>
</html>
