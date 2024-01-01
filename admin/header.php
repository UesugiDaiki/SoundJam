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
    /**
     * メッセージ送信
     */
    case 'send-message':
      $stmt = $pdo->prepare('INSERT INTO inquiry_table (id, REPLY_FROM, REPLY_TO, TITLE, OVERVIEW, IDENTIFICATION) VALUES(null, null, ?, ?, ?, 1)');
      $stmt->execute([$_REQUEST['address'], $_REQUEST['subject'], $_REQUEST['body']]);
      break;

    /**
     * 削除する投稿の検索
     */
    case 'delete-post-search':
      $words = explode(' ', $_REQUEST['words']);
      for ($i = 0; $i < 3; $i++) {
        foreach ($words as $word) {
          $param[] = '%' . $word . '%';
        }
      }
      $sql = 'SELECT id, TITLE FROM post_table WHERE ';
      // TITLE列から部分一致
      for ($i = 0; $i < count($words); $i++) {
        if ($i == 0) {
          $sql .= "( TITLE LIKE ?";
        } else {
          $sql .= " AND TITLE LIKE ?";
        }
      }
      $sql .= " ) OR ";
      // OVERVIEW列から部分一致
      for ($i = 0; $i < count($words); $i++) {
        if ($i == 0) {
          $sql .= "( OVERVIEW LIKE ?";
        } else {
          $sql .= " AND OVERVIEW LIKE ?";
        }
      }
      $sql .= " ) OR ";
      // RECORDING_METHOD列から部分一致
      for ($i = 0; $i < count($words); $i++) {
        if ($i == 0) {
          $sql .= "( RECORDING_METHOD LIKE ?";
        } else {
          $sql .= " AND RECORDING_METHOD LIKE ?";
        }
      }
      $sql .= " ) ORDER BY DATES ASC";

      $stmt = $pdo->prepare($sql);
      $stmt->execute($param);
      break;

    /**
     * 投稿削除
     */
    case 'delete-post':
      $stmt = $pdo->prepare('DELETE FROM post_table WHERE id = ?');
      $stmt->execute([$_REQUEST['post-id']]);
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
  <!-- header -->
  <nav class="navbar bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">管理者ホーム</a>
      <form class="d-flex" method="POST" action="login.php">
        <input type="hidden" name="command" value="logout">
        <button class="btn btn-outline-danger" type="submit">ログアウト</button>
      </form>
    </div>
  </nav>
