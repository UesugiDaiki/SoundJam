<?php
// ログインの操作が行われたか
if (isset($_REQUEST['command'])) {
  if ($_REQUEST['command'] == 'login') {
    $login = $_REQUEST['id'];
    $password = $_REQUEST['password'];
    
    unset($_SESSION['soundjam_admin']);
    
    $stmt = $pdo->prepare('SELECT * FROM admin_table WHERE ADMINS = ? and PASSWORDS = ?');
    $stmt->execute([$login, hash('sha256', $password)]);
    foreach ($stmt as $row) {
      $_SESSION['soundjam_admin'] = [
        'id'    => $row['id'],
        'login' => $row['ADMINS']
      ];
    }
  }
}

// ログインしていないか
if (is_null($_SESSION['soundjam_admin'])) {
  header('Location: login.php');
  exit;
}

// 操作が行われたか
if (isset($_REQUEST['command'])) {
  switch ($_REQUEST['command']) {
    // メッセージ送信
    case 'send-message':
      break;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  <title>SoundJam | admin</title>
</head>
<body>
  <nav class="navbar bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">管理者ホーム</a>
      <form class="d-flex" method="POST" action="login.php">
        <input type="hidden" name="command" value="logout">
        <button class="btn btn-outline-danger" type="submit">ログアウト</button>
      </form>
    </div>
  </nav>
