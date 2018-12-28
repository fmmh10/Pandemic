<?php

include("db_config.php");

$campos_bd = "`jogadores_actuais`,";
$valores_bd = "'1',";

$jogo_ja_existe = false;

foreach ($_POST as $dados => $dado) {

    $campos_bd .= "`" . $dados . "`,";
    if ($dados == 'nome') {
        $query_verificacao = "SELECT * FROM jogo WHERE `nome`='$dado'";
        $verifica_nome = mysqli_query($conn, $query_verificacao) or die();
        $contador_linhas = mysqli_num_rows($verifica_nome);
        if ($contador_linhas > 0) {
            $jogo_ja_existe = true;
        }
    }
    $valores_bd .= "'" . $dado . "',";
}
if (!$jogo_ja_existe) {
    $campos_bd = rtrim($campos_bd, ",");
    $valores_bd = rtrim($valores_bd, ",");

    $novo_query = "INSERT INTO jogo ($campos_bd) VALUES($valores_bd)";

    $novo_result = mysqli_query($conn, $novo_query) or die();
    echo "success";
} else {
    echo "duplicado";
}
?>
