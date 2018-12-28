<?php

include_once './db_config.php';

function verificaLoginUser() {
    if (!isset($_COOKIE['user'])) {
        return false;
    } else {
        return true;
    }
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'verificaUltimoJogo') {
    verificaUltimoJogo($_POST['total_actual'], $conn);
}

function verificaUltimoJogo($total_actual, $conn) {
//    echo $total_actual;
    $query_jogos_existentes = "SELECT * FROM jogo";
    $executa_query = mysqli_query($conn, $query_jogos_existentes);
    $total_mais_recente = mysqli_num_rows($executa_query);
    if ($total_actual != $total_mais_recente) {
        $query_jogos_actualizados = "SELECT id, nome, descricao, jogadores_actuais, n_jogadores, data_comeco, criador FROM jogo ORDER BY id DESC LIMIT 1";
        $executa_query_actualizado = mysqli_query($conn, $query_jogos_actualizados);
        $linha = mysqli_fetch_assoc($executa_query_actualizado);
        $nome = $linha['nome'];
        $descricao = $linha['descricao'];
        $n_jogadores = $linha['n_jogadores'];
        $criador = $linha['criador'];
        $link = "'jogo.php?jogo=" . $linha['id'] . "'";
        echo "<tr><td>" . $nome . "</td><td>" . $descricao . "</td><td>" . $n_jogadores . "</td><td>" . $criador . "</td> <td><a href=" . $link . "><button id='juntar_jogo' class='btn btn-success'> Juntar a jogo</button></a></td>";
    } else{
        echo 'igual';
    }
}
