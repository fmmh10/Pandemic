<?php

include('db_config.php');
//foreach ($_POST as $post => $valor) {
//    echo $post . '</br>';
//    echo $valor . '</br>';
//}




$autorizado = false;

if (isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password'])) {
   
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $password = crypt($password, "1234");

    $query_verificacao = "SELECT * FROM user WHERE `nickname`='$nickname' AND email='$email'";

    $verifica_nicks = mysqli_query($conn, $query_verificacao) or die();
    $contador_linhas = mysqli_num_rows($verifica_nicks);
    if ($contador_linhas > 0) {
        $novo_query = "UPDATE user SET password='$password' WHERE nickname='$nickname' AND email='$email'";
        $novo_result = mysqli_query($conn, $novo_query) or die();
        $autorizado = true;
    }
} if ($autorizado) {
    echo "alterado";
} else {
    echo "negado";
}
?>