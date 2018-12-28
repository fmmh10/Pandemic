<?php

function pesquisaEstadoJogo($conn, $estado = '') {
    if ($estado == '') {
        $query_lista = "SELECT id_jogo, estado, data_inicio, n_turnos, n_jogadores, jogador2, jogador3, jogador4 FROM estado_jogo";
    } else {
        $query_lista = "SELECT id_jogo, estado, data_inicio, n_turnos, n_jogadores, jogador2, jogador3, jogador4 FROM estado_jogo WHERE estado ='$estado'";
    }
    $result_lista = mysqli_query($conn, $query_lista) or die();
    return $result_lista;
}

function pesquisaJogoEspecifico($conn, $campo, $valor_a_procurar) {
    $query_jogo_geral = "SELECT * FROM jogo WHERE $campo LIKE '%$valor_a_procurar%'";
    $resultado_jogo_geral = mysqli_query($conn, $query_jogo_geral);
    $string_jogo_especifico = "WHERE ";

    while ($row = mysqli_fetch_assoc($resultado_jogo_geral)) {
        $string_jogo_especifico .= "id_jogo='" . $row['id'] . "' OR ";
    }
    $query_jogos_especificos = 'SELECT id_jogo, estado, data_inicio, n_turnos, n_jogadores, jogador2, jogador3, jogador4 FROM estado_jogo ' . $string_jogo_especifico;
    $query_jogos_especificos = substr($query_jogos_especificos, 0, -3);
    $resultado_jogo_especifico = mysqli_query($conn, $query_jogos_especificos);

    return $resultado_jogo_especifico;
}

function vistaGeralJogo($id_jogo, $conn) {
    $query_jogo = "SELECT * FROM jogo where id='$id_jogo'";
    $resultados_jogo = mysqli_query($conn, $query_jogo);
    return $resultados_jogo;
}

?>