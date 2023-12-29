<?php session_start(); ?>
<?php require 'server_connection.php'; ?>



<?php



if (isset($_REQUEST['command'])) {
    switch ($_REQUEST['command']) {
        // ログイン
        case 'login':
            unset($_SESSION['admin_table']);

            // ユーザー名とパスワードの検証
            $sql = $pdo->prepare("select * from admin_table where ADMINS=? and PASSWORDS=?");
            $sql->execute([$_REQUEST['ADMINS'], hash('sha256', $_REQUEST['PASSWORDS'])]);
            foreach($sql as $row){
                $_SESSION['admin_table']=[
                    'id'          => $row['id'],
                    'ADMINS'      => $row['ADMINS'],
                    'PASSWORDS'    => $row['PASSWORDS']
                ];
            }
            if (!isset($_SESSION['admin_table'])) {
                $alert = "<script type='text/javascript'>alert('ログイン名もしくはパスワードが間違っています');</script>";
                echo $alert;
            }
            break;

        // ログアウト
        case 'logout':
            unset($_SESSION['admin_table']);
            break;
    }
}

if (isset($_SESSION['admin_table'])) {
    require 'header_mana.php';
    echo '<div class="m-5">';
    echo '<table class="table">';
    echo '<h1>Hello World</h1>';
    echo '<h1>Let\'s take a look at the amazing work we\'ve created!!!!!</h1>';
    echo '<a href=http://127.0.0.1:8000/home>http://127.0.0.1:8000/home</a>';
} else {
    echo '<a href="login_mana.php">ログインに戻る</a>';
}
?>

</div>

</body>
</html>
