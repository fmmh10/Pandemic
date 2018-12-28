<?php

include('db_config.php');

$negado = false;
if (isset($_POST['nickname']) && isset($_POST['password'])) {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $negado = false;
    $query_user = "SELECT * FROM user WHERE nickname='$nickname'";
    $result_user = mysqli_query($conn, $query_user) or die();
    while ($row = mysqli_fetch_assoc($result_user)) {
        if (crypt($password, $row['password']) == $row['password']) {
            $negado = false;
        } else {
            $negado = true;
        }
    }

    if (!$negado) {
//        setcookie("user", $nickname, time() + 24 * 60, "/");
        setcookie("user", $nickname, time() + 8000 * 60, "/");
        echo('autorizado');
    } else {
        echo ('negado');
    }
} else {
    echo ('negado');
}
?>
