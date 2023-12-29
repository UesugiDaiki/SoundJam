<?php
session_start();
if (isset($_REQUEST['command'])) {
    if ($_REQUEST['command'] == 'logout') {
        unset($_SESSION['admin_table']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>管理者ログイン</title>
</head>
<body>
    <h1>管理者ログイン</h1>

    <form method="POST" action="menu_mana.php">
        <label>ユーザー名: <input type="text" name="ADMINS"></label><br>
        <label>パスワード: <input type="password" name="PASSWORDS"></label><br>
        <input type="hidden" name="command" value="login">
        <input type="submit" value="ログイン">
    </form>
</body>
</html>
