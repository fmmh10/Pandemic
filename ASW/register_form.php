<?php

include("db_config.php");

$campos_bd = "";
$valores_bd = "";

$user_ja_existe = false;

foreach ($_POST as $dados => $dado) {
    $campos_bd .= "`" . $dados . "`,";
    if ($dados == 'nickname') {
        $query_verificacao = "SELECT * FROM user WHERE `nickname`='$dado'";
        $verifica_nicks = mysqli_query($conn, $query_verificacao) or die();
        $contador_linhas = mysqli_num_rows($verifica_nicks);
        if ($contador_linhas > 0) {
            $user_ja_existe = true;
        }
    }
    if ($dados == 'password') {
        $dado = crypt($dado, "1234");
        $valores_bd .= "'" . $dado . "',";
    } else {
        $valores_bd .= "'" . $dado . "',";
    }
}

if (!$user_ja_existe) {
    $campos_bd = rtrim($campos_bd, ",");
    $valores_bd = rtrim($valores_bd, ",");

    $novo_query = "INSERT INTO user ($campos_bd) VALUES($valores_bd)";
    $novo_result = mysqli_query($conn, $novo_query) or die();
    echo "success";
} else {
    echo "duplicado";
}
?>
