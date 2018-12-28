<?php

include_once 'db_config.php';


if (isset($_POST['funcao']) && $_POST['funcao'] == 'insert') {
    echo addJogador($_POST['id_jogo'], $_POST['nickname'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'start') {

    comecarJogo($_POST['id_jogo'], $_POST['jogador1'], $_POST['jogador2'], $_POST['jogador3'], $_POST['jogador4'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'conexoes') {

    verificaConexoes($_POST['cidade_actual'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'mover') {

    moverParaCidade($_POST['id_jogo'], $_POST['nickname'], $_POST['destino'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'desistir') {

    desistirJogo($_POST['id_jogo'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'turno') {

    mudaTurno($_POST['id_jogo'], $_POST['n_turno'], $_POST['turno_jogador'], $conn, $_POST['nickname']);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'criar_cp') {
    criarCentroPesquisa($_POST['id_jogo'], $_POST['id_cidade'], $_POST['carta'], $_POST['jogador'], $conn);
}
if (isset($_POST['funcao']) && $_POST['funcao'] == 'curar_uma_doenca') {
    removeUmaDoencaEmCidade($_POST['id_jogo'], $_POST['id_cidade'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'getJogadaActual') {
    getJogadaActual($_POST['id_jogo'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'erradicar_doenca') {
    curaDoenca($_POST['id_jogo'], $_POST['cor'], $_POST['jogador'], $_POST['cartas'], $conn);
}

if (isset($_POST['funcao']) && $_POST['funcao'] == 'verifica_estado_jogo') {
    confirmaJogoADecorrer($_POST['id_jogo'], $conn);
}

// Adiciona um jogador novo ao jogo actual
function addJogador($id_jogo, $nome_jogador, $conexao) {
    $conn = $conexao;
    $query_pesquisa_jogador = "SELECT jogadores_actuais, n_jogadores, jogador2, jogador3, jogador4 FROM jogo WHERE id='$id_jogo'";
    $result = mysqli_query($conn, $query_pesquisa_jogador);
    while ($row = mysqli_fetch_assoc($result)) {
        if (!$row['jogador2']) {
            $jogador_a_acrescentar = "jogador2='" . $_COOKIE['user'] . "'";
        } else if (!$row['jogador3']) {
            $jogador_a_acrescentar = "jogador3='" . $_COOKIE['user'] . "'";
        } else if (!$row['jogador4']) {
            $jogador_a_acrescentar = "jogador4='" . $_COOKIE['user'] . "'";
        }
        if ($row['jogadores_actuais'] < $row['n_jogadores']) {
            $query_update = "UPDATE jogo SET jogadores_actuais='" . intval($row['jogadores_actuais'] + 1) . "', $jogador_a_acrescentar WHERE id='$id_jogo'";
            mysqli_query($conn, $query_update) or die();
            return "success";
        }
    }
    return "erro";
}

// Verifica se jogador já se encontra na BD
/*
 * Verifica se o jogador está inscrito no jogo
 * 
 * @param int id_jogo
 * @param string nick_jogador
 * @param string conn
 * 
 * @return boolean
 */
function checkPlayer($id_jogo, $nick_jogador, $conn) {
    $query_pesquisa_jogador = "SELECT criador, jogador2, jogador3, jogador4 FROM jogo WHERE id='$id_jogo'";
    $result = mysqli_query($conn, $query_pesquisa_jogador);
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($row as $campo => $valor) {
            if ($valor == $nick_jogador) {
                return true;
            }
        }
    }
    return false;
}

/*
 * Processa todos os dados necessários para inciar um novo jogo
 * 
 * @param int id_jogo
 * @param string jogador1, jogador2, jogador3, jogador4
 * @param string
 */

function comecarJogo($id_jogo, $jogador1, $jogador2, $jogador3 = "", $jogador4 = "", $conn) {
    $numero_jogadores = 2;

    if ($jogador3 != "") {
        $numero_jogadores++;
        if ($jogador4 != "") {
            $numero_jogadores++;
        }
    }

    switch ($numero_jogadores) {
        case 4:
            $maximo_cartas = 2;
            $cartas_biscadas = 8;
            break;
        case 3:
            $maximo_cartas = 3;
            $cartas_biscadas = 9;
            break;
        default:
            $maximo_cartas = 4;
            $cartas_biscadas = 8;
            break;
    }

    for ($contador = 0; $contador < $maximo_cartas; $contador++) {
        rand_carta($jogador1, $id_jogo, $conn);
        rand_carta($jogador2, $id_jogo, $conn);
        if ($jogador3 != "") {
            rand_carta($jogador3, $id_jogo, $conn);
        }
        if ($jogador4 != "") {
            rand_carta($jogador4, $id_jogo, $conn);
        }
    }
    infectaCidadesIniciais($id_jogo, $conn);


    $query_insercao = "INSERT INTO estado_jogo "
            . "(id_jogo, "
            . "estado, "
            . "n_jogadores, "
            . "jogador1, "
            . "jogador2, "
            . "jogador3, "
            . "jogador4, "
            . "n_turnos, "
            . "turno_jogador, "
            . "data_inicio, "
            . "cidade_jogador1, "
            . "cidade_jogador2, "
            . "cidade_jogador3, "
            . "cidade_jogador4, "
            . "velocidade_infecao, "
            . "cartas_biscadas, "
            . "jogadas)"
            . "VALUES('$id_jogo', "
            . "'Iniciado', "
            . "'$numero_jogadores',"
            . "'$jogador1', "
            . "'$jogador2', "
            . "'$jogador3', "
            . "'$jogador4', "
            . "'1', "
            . "'1', "
            . "'" . date('Y-m-d') . "', "
            . "'6', "
            . "'6', "
            . "'6', "
            . "'6', "
            . "'2', "
            . "'$cartas_biscadas', "
            . "'0')";

    mysqli_query($conn, $query_insercao);

    $query_inicia_tabela_doencas_erradicas = "INSERT INTO doencas_erradicas (id_jogo, `Amarelo`, `Azul`, `Preto`, `Vermelho`) VALUES($id_jogo, '0', '0', '0', '0')";
    mysqli_query($conn, $query_inicia_tabela_doencas_erradicas);
}

/*
 * Proecessa a colocação de uma carta na posse de um jogador
 * 
 * @param string carta
 * @param int id_carta
 * @param string cor
 * @param string jogador
 * @param string conn
 */

function insereCarta($carta, $id_carta, $cor, $id_jogo, $jogador, $conn) {
    $query_insert_cartas = "INSERT INTO cartas_jogador (id_jogo, id_carta, id_jogador, carta, cor) VALUES('$id_jogo','$id_carta','$jogador', '$carta', '$cor') ";
    mysqli_query($conn, $query_insert_cartas) or die(mysqli_error());
}

/*
 * Seleciona uma carta aleatória para ser inserida na função insereCarta
 * @param string jogador
 * @param int id_jogo
 * @param string conn
 */

function rand_carta($jogador, $id_jogo, $conn) {
    $sql_cartas = "SELECT * FROM cartas ORDER BY RAND() LIMIT 1";

    $dados_cartas = mysqli_query($conn, $sql_cartas) or die();

    while ($row = mysqli_fetch_assoc($dados_cartas)) {
        $existe_carta = verificaCartasRepetidas($id_jogo, $row['cidade'], $row['id'], $conn);
        if (!$existe_carta) {
            insereCarta($row['cidade'], $row['id'], $row['cor'], $id_jogo, $jogador, $conn);
        } else {
            rand_carta($jogador, $id_jogo, $conn);
        }
    }
}

/*
 * A funcao processa 9 cidades de forma especial para inserir doencas no inicio do jogo
 * 3 doenças para 3 cidades, 2 doenças para 3 cidades, 1 doença para 3 cidades
 * Sem haver cidades repetidas
 * 
 * @param int id_jogo
 * @param string conn
 */

function infectaCidadesIniciais($id_jogo, $conn) {
    for ($contador = 0; $contador < 3; $contador++) {
        $id_a_inserir = rand(1, 40);
        while (verificaCidadeInfectada($id_a_inserir, $id_jogo, $conn)) {
            $id_a_inserir = rand(1, 40);
        }
        insereDoencasEmNovasCidades($id_a_inserir, $id_jogo, $conn, 3);
    }


    for ($contador = 0; $contador < 3; $contador++) {
        $id_a_inserir = rand(1, 40);

        while (verificaCidadeInfectada($id_a_inserir, $id_jogo, $conn)) {
            $id_a_inserir = rand(1, 40);
        }
        insereDoencasEmNovasCidades($id_a_inserir, $id_jogo, $conn, 2);
    }

    for ($contador = 0; $contador < 3; $contador++) {
        $id_a_inserir = rand(1, 40);

        while (verificaCidadeInfectada($id_a_inserir, $id_jogo, $conn)) {
            $id_a_inserir = rand(1, 40);
        }
        insereDoencasEmNovasCidades($id_a_inserir, $id_jogo, $conn);
    }
}

/*
 * Insere numero de doenças na cidade específica
 * 
 * @param int id_cidade
 * @param int id_jogo
 * @param string conn
 * @param int numero_doencas
 */

function insereDoencasEmNovasCidades($id_cidade, $id_jogo, $conn, $numero_doencas = 1) {
    $query_informacao_cidade = "SELECT * FROM cidades WHERE id=$id_cidade";
    $executa_query = mysqli_query($conn, $query_informacao_cidade);
    while ($row = mysqli_fetch_assoc($executa_query)) {
        $id_cidade_inserir = $row['id'];
        $nome_cidade_inserir = $row['nome'];
        $cor_da_cidade = $row['cor'];
        mysqli_query($conn, "INSERT INTO cidades_infectadas (id_jogo, id_cidade, nome_cidade, n_doencas, cor) VALUES($id_jogo, $id_cidade_inserir,'$nome_cidade_inserir', $numero_doencas, '$cor_da_cidade' )");
    }
}

/*
 * Corre a bd para ver se a cor da doença já foi erradicada
 * @param int id_jogo
 * @param string cor
 * @param string conn
 * 
 * @return boolean
 */

function verificaSeDoencaEstaErradicada($id_jogo, $cor, $conn) {
    $query_doencas_ja_erradicadas = "SELECT `$cor` FROM doencas_erradicadas WHERE id_jogo='$id_jogo'";
    $executa_query = mysqli_query($conn, $query_doencas_ja_erradicadas);
    if (!$executa_query) {
        return false;
    }
    $doenca_erradicada = mysqli_fetch_row($executa_query);
    if (intval($doenca_erradicada[0]) != 0) {
        return true;
    } else {
        return false;
    }
}

/*
 * Verifica se cidade específica já foi infectada
 * 
 * @param int id_cidade
 * @param int id_jogo
 * @param string conn
 * 
 * @return boolean
 */

function verificaCidadeInfectada($id_cidade, $id_jogo, $conn) {
    $query_verifica_cidadade_infectada = "SELECT * FROM cidades_infectadas WHERE id_cidade=$id_cidade AND id_jogo=$id_jogo";
    $executa_verificao = mysqli_query($conn, $query_verifica_cidadade_infectada);
    if ($executa_verificao) {
        $row = mysqli_fetch_assoc($executa_verificao);
        if ($row['n_doencas'] > 0) {
            return true;
        }
    } else {
        return false;
    }
}

/*
 * Conta o numero de doenças existente na cidade envaida por parametro
 * 
 * @param int id_cidade
 * @param int id_jogo
 * @param string conn
 * 
 * @return int n_doencas
 */

function contaInfecoes($id_cidade, $id_jogo, $conn) {
    $query_por_cidade = "SELECT n_doencas FROM cidades_infectadas WHERE id_jogo='$id_jogo' AND id_cidade='$id_cidade'";
    $executa_query = mysqli_query($conn, $query_por_cidade);
    $row = mysqli_fetch_assoc($executa_query);
    $n_doencas = $row['n_doencas'];
    return $n_doencas;
}

/*
 * altera o numero de doencas numa cidade
 * 
 * @param int id_cidade
 * @param int id_jogo
 * @param int n_doencas
 * @param string conn
 */

function actualizaNumeroDoencas($id_cidade, $id_jogo, $n_doencas, $conn) {
    if ($n_doencas == 0) {
        $query_actualizacao_doencas = "DELETE FROM cidades_infectadas WHERE id_cidade=$id_cidade AND id_jogo=$id_jogo";
    } else {
        $query_actualizacao_doencas = "UPDATE cidades_infectadas SET n_doencas='$n_doencas' WHERE id_cidade=$id_cidade AND id_jogo=$id_jogo";
    }
    mysqli_query($conn, $query_actualizacao_doencas);
}

/*
 * Verifica se carta já tinha sido descartada
 * 
 * @param int jogo
 * @param string carta
 * @param int id_carta
 * @param string conn
 * 
 * return boolean
 */

function verificaCartasRepetidas($jogo, $carta, $id_carta, $conn) {
    $query_selecionar_cartas = "SELECT * FROM cartas_jogador WHERE id_jogo='$jogo' AND carta='$carta'";
    $dados_cartas = mysqli_query($conn, $query_selecionar_cartas) or die();
    $cartas_descartadas = array();

    $query_cartas_descartadas = "SELECT pilha_descarte FROM estado_jogo WHERE id_jogo='$jogo'";
    $pilha_descarte = mysqli_query($conn, $query_cartas_descartadas) or die();
    $row = mysqli_fetch_assoc($pilha_descarte);
    $cartas_descartadas = explode(', ', $row['pilha_descarte']);


    if (in_array($id_carta, $cartas_descartadas)) {
        return false;
    }

    $total_cartas_em_mao = mysqli_num_rows($dados_cartas);
    if ($total_cartas_em_mao > 0) {
        return true;
    } else {
        return false;
    }
}

/*
 * Verifica o estado actual do jogo
 * @param int id_jogo
 * @param string conn
 * 
 * @return string
 */

function verificaEstadoJogo($id_jogo, $conn) {
    $query_verificacao = "SELECT * FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $linha_jogo = mysqli_query($conn, $query_verificacao) or die();
    if ($linha_jogo === FALSE || mysqli_num_rows($linha_jogo) == 0) {
        return false;
    } else {
        foreach ($linha_jogo as $estado_jogo) {
            $linha_estado_jogo = $estado_jogo;
        }
        return $linha_estado_jogo;
    }
}

/*
 * Converte as cartas que pertencem a cada jogador em código html para ser interpretado pelo browser, através de pedido ajax
 * 
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 * @return string
 */

function processaCartasJogador($id_jogo, $nickname, $conn) {

    $string_processada = "";
    $cartas = obtemCartasJogador($id_jogo, $nickname, $conn);
    separaCartasPorCor($id_jogo, $nickname, $conn);

//  Converte as cartas de cada jogador numa string a ser interpretada pelo browser
    foreach ($cartas as $carta => $valor) {
        $string_processada .= '<span class="cartas ' . $valor['cor'] . '">' . $valor['carta'] . '</span>' . ', ';
    }

    return rtrim($string_processada, ', ');
}

/*
 * obtem um array de todas as cartas do jogador, sem ordenação
 * 
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 * @return array
 */

function obtemCartasJogador($id_jogo, $nickname, $conn) {
    $cartas = array();
    $contador = 0;
    $query_obter_cartas = "SELECT id_carta, carta, cor FROM cartas_jogador WHERE id_jogo='$id_jogo' AND id_jogador='$nickname' AND ja_jogada=0";
    $resultado_query = mysqli_query($conn, $query_obter_cartas);
    while ($row = mysqli_fetch_assoc($resultado_query)) {
        $cartas[$contador]['id_carta'] = $row['id_carta'];
        $cartas[$contador]['cor'] = $row['cor'];
        $cartas[$contador]['carta'] = $row['carta'];
        $contador++;
    }
    return $cartas;
}

/*
 * processas as cartas do jogador e coloca-as num array associativo ordenando-as por cores
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 * @return array
 */

function separaCartasPorCor($id_jogo, $nickname, $conn) {
    $cartas_vermelhas = array();
    $cartas_azuis = array();
    $cartas_amarelas = array();
    $cartas_pretas = array();

    $todas_as_cartas = obtemCartasJogador($id_jogo, $nickname, $conn);
    foreach ($todas_as_cartas as $carta) {
        switch ($carta['cor']) {
            case 'Vermelho' :
                $cartas_vermelhas[] = $carta['id_carta'];
                break;
            case 'Amarelo' :
                $cartas_amarelas[] = $carta['id_carta'];
                break;
            case 'Azul' :
                $cartas_azuis[] = $carta['id_carta'];
                break;
            case 'Amarelo' :
                $cartas_pretas[] = $carta['id_carta'];
                break;
        }
    }
    $cartas_totais_ordenadas = array('Vermelho' => $cartas_vermelhas, 'Azul' => $cartas_azuis, 'Amarelo' => $cartas_amarelas, 'Preto' => $cartas_pretas);

    return $cartas_totais_ordenadas;
}

/*
 * Verifica se estão reunidas as condições necessárias para se poder erradcar uma doença
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 * @return boolean
 */

function verificaSePodeCurarDoenca($id_jogo, $nickname, $conn) {
    $cartas_actuais_ordenadas = separaCartasPorCor($id_jogo, $nickname, $conn);
    $centros_pesquisa = obtemCentrosPesquisa($id_jogo, $conn);
    $cidade_actual = obtemCidadeActual($id_jogo, $nickname, $conn)[0];

    if (verificaSeDoencaEstaErradicada($id_jogo, $cidade_actual['cor'], $conn)) {
        return false;
    }
    if (in_array($cidade_actual['id'], $centros_pesquisa) && count($cartas_actuais_ordenadas[$cidade_actual['cor']]) >= 5) {
        return true;
    } else {
        return false;
    }
}

/*
 * Erradica uma doenca do jogo
 * @param int id_jogo
 * @param string cor
 * @param string jogador
 * @param array cartas
 */

function curaDoenca($id_jogo, $cor, $jogador, $cartas, $conn) {
    if (!verificaSeDoencaEstaErradicada($id_jogo, $cor, $conn)) {
        mysqli_query($conn, "UPDATE doencas_erradicadas SET `$cor`=1 WHERE id_jogo=$id_jogo");
        mysqli_query($conn, "DELETE FROM cidades_infectadas WHERE cor='$cor' ");
        foreach ($cartas as $carta) {
            mysqli_query($conn, "UPDATE cartas_jogador SET ja_jogada=1 WHERE id_carta='$carta' AND id_jogador='$jogador'");
        }
        incrementaNumeroJogadas($id_jogo, $conn);
    }
}

/*
 * devolve os dados da cidade onde o jogador está actualmente
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 * return array
 */

function obtemCidadeActual($id_jogo, $nickname, $conn) {
    $numero_jogador_procurar = "";
    $query_jogador = "SELECT jogador1, jogador2, jogador3, jogador4 FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado = mysqli_query($conn, $query_jogador);
    foreach ($resultado as $jogadores => $valor) {
        foreach ($valor as $jogador) {
            if ($valor['jogador1'] == $nickname) {
                $numero_jogador_procurar = 1;
            } else if ($valor['jogador2'] == $nickname) {
                $numero_jogador_procurar = 2;
            } else if ($valor['jogador3'] == $nickname) {
                $numero_jogador_procurar = 3;
            } else if ($valor['jogador4'] == $nickname) {
                $numero_jogador_procurar = 4;
            }
        }
    }
    $query_cidade_actual = "Select cidade_jogador$numero_jogador_procurar FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado = mysqli_query($conn, $query_cidade_actual);
    $cidade_actual_id = mysqli_fetch_assoc($resultado);
    $cidade_actual = obterUmaCidade($cidade_actual_id['cidade_jogador' . $numero_jogador_procurar], $conn);


    return $cidade_actual;
}

/*
 * indica qual é o jogador a jogar
 * @param int id_jogo
 * @param int numero_turno
 * @param string conn
 * 
 * return string
 */

function obtemTurnoDoJogador($id_jogo, $numero_turno, $conn) {
    switch ($numero_turno) {
        case(1):
            $query_obter_jogadores = "SELECT jogador1 FROM estado_jogo WHERE id_jogo='$id_jogo' ";
            break;
        case(2):
            $query_obter_jogadores = "SELECT jogador2 FROM estado_jogo WHERE id_jogo='$id_jogo' ";
            break;
        case(3):
            $query_obter_jogadores = "SELECT jogador3 FROM estado_jogo WHERE id_jogo='$id_jogo' ";
            break;
        case(4):
            $query_obter_jogadores = "SELECT jogador4 FROM estado_jogo WHERE id_jogo='$id_jogo' ";
            break;
    }

    $resultado = mysqli_query($conn, $query_obter_jogadores);
    $row = mysqli_fetch_row($resultado);
    $jogador_actual = $row[0];
    return $jogador_actual;
}

/*
 * muda o estado do jogo para Desistiram
 * @param int id_jogo
 * @param string conn
 */

function desistirJogo($id_jogo, $conn) {
    $query_desistir = "UPDATE estado_jogo SET estado='Desistiram' WHERE id_jogo='$id_jogo'";
    mysqli_query($conn, $query_desistir);
}

/*
 * Devolve todas as cidades que existem
 * @param string conn
 * @param string cor
 * 
 * @return array
 */

function obterCidades($conn, $cor = '') {
    if ($cor != '') {
        $query_cidades = "SELECT * FROM cidades WHERE cor='$cor'";
    } else {
        $query_cidades = "SELECT * FROM cidades";
    }
    $resultado_cidades = mysqli_query($conn, $query_cidades);
    $cidades = array();
    foreach ($resultado_cidades as $resultado) {
        $cidades[] = $resultado;
    }
    return $cidades;
}

/*
 * obtem os dados de apenas uma cidade
 * @param int id
 * @param string conn
 * 
 * @return array
 */

function obterUmaCidade($id, $conn) {
    $query_cidade = "SELECT * FROM cidades WHERE id='$id'";
    $resultado_cidade = mysqli_query($conn, $query_cidade);
    $cidade = array();
    foreach ($resultado_cidade as $cidade_escolhida) {
        $cidade[] = $cidade_escolhida;
    }
    return $cidade;
}

/*
 * transforma as conexoes das cidades em botoes em html para processamento pelo browser através de um pedido ajax
 * @param int posicao_actual
 * @param string conn
 * 
 * @return string
 */

function verificaConexoes($posicao_actual, $conn) {
    $query_conexoes = "SELECT conexoes FROM cidades where nome='$posicao_actual'";
    $resultado_conexoes = mysqli_query($conn, $query_conexoes);
    while ($row = mysqli_fetch_assoc($resultado_conexoes)) {
        $conexoes = explode(', ', $row['conexoes']);
    }
    $string_botoes = "";

// Processa o array com strings de forma a devolver logo os botõees das cidades
    foreach ($conexoes as $conexao) {
        $string_botoes .= '<button type="button" class="btn btn-info cidade_escolhida" value="' . $conexao . '" >' . $conexao . '</button>';
    }

    $string_botoes .= '<button type="button" class="btn btn-danger cidade_escolhida" id="cancel "value="cancelar" >Cancelar</button>';
    echo($string_botoes);
}

/*
 * muda a posicao actual do jogador
 * @param int id_jogo
 * @param string destino
 * @param string nickname
 * @param string conn
 * 
 * @return array
 */

function moverParaCidade($id_jogo, $nickname, $destino, $conn) {
    $query_destino = "SELECT * FROM cidades WHERE nome ='$destino'";
    $resultado_destino = mysqli_query($conn, $query_destino);
    foreach ($resultado_destino as $cidade) {
        $id_cidade_actualizada = $cidade['id'];
    }

    $query_pesquisa_jogador = "SELECT criador, jogador2, jogador3, jogador4 FROM jogo WHERE id='$id_jogo'";
    $result = mysqli_query($conn, $query_pesquisa_jogador);
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($row as $campo => $valor) {
            if ($valor == $nickname && $campo != 'criador') {
                $campo_jogador = $campo;
                $numero_jogador = substr($campo, -1);
            } else if ($valor == $nickname && $campo == 'criador') {
                $campo_jogador = 'jogador1';
                $numero_jogador = 1;
            }
        }
    }
    $query_update_jogador = "UPDATE estado_jogo SET cidade_jogador$numero_jogador = '$id_cidade_actualizada' WHERE $campo_jogador='$nickname' AND id_jogo='$id_jogo' ";
    mysqli_query($conn, $query_update_jogador);
    incrementaNumeroJogadas($id_jogo, $conn);
}

/*
 * aumenta o numero de jogadas por turno
 * @param int id_jogo
 * @param string conn
 * 
 */

function incrementaNumeroJogadas($id_jogo, $conn) {
    $jogadas = verificaNumeroJogadasFeitas($id_jogo, $conn);
    $proximo_turno = obtemNumeroTurnoActual($id_jogo, $conn) + 1;
    if ($jogadas < 2) {
        $jogadas++;
        mysqli_query($conn, "UPDATE estado_jogo SET jogadas='$jogadas' WHERE id_jogo='$id_jogo'");
    } else {
        $query_jogador_actualmente_com_turno = "SELECT turno_jogador FROM estado_jogo WHERE id_jogo=$id_jogo";
        $executa_jogador_actualmente_com_turno = mysqli_query($conn, $query_jogador_actualmente_com_turno);
        $turno_jogador_actual = mysqli_fetch_assoc($executa_jogador_actualmente_com_turno);
        $turno_jogador = $turno_jogador_actual['turno_jogador'];
        mudaTurno($id_jogo, obtemNumeroTurnoActual($id_jogo, $conn), $turno_jogador, $conn, obtemTurnoDoJogador($id_jogo, obtemNumeroTurnoActual($id_jogo, $conn), $conn));
//        mysqli_query($conn, "UPDATE estado_jogo SET jogadas='0', n_turnos=$proximo_turno WHERE id_jogo='$id_jogo'");
    }
}

/*
 * verifica quantas jogadas foram feitas neste turno
 * @param int id_jogo
 * @param string conn
 * 
 * @return int
 */

function verificaNumeroJogadasFeitas($id_jogo, $conn) {
    $query_jogadas = "SELECT jogadas FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado = mysqli_query($conn, $query_jogadas);
    while ($row = mysqli_fetch_assoc($resultado)) {
        return intval($row['jogadas']);
    }
}

/*
 * bisca duas cartas de cidade ou uma cidade e um surto
 * @param int id_jogo
 * @param string nickname
 * @param string conn
 * 
 */

function biscar($id_jogo, $nickname, $conn) {
    $estado_actual_infecoes = obtemVelocidadeInfecao($id_jogo, $conn);
    if ($estado_actual_infecoes['surtos'] <= 4) {
        $verifica_carta = rand(1, 45);
        $cidade_com_surto = rand(1, 40);
    } else {
        $verifica_carta = rand(1, 40);
    }

    if ($verifica_carta > 40) {
        $contador = 1;
        originaSurto($id_jogo, $cidade_com_surto, $conn);
    } else {
        $contador = 0;
    }

    while ($contador < 2) {
        rand_carta($nickname, $id_jogo, $conn);
        $contador++;
    }
    aumentaCartasBiscadas($id_jogo, $contador + 1, $conn);
}

/*
 * aumenta o numero de cartas biscadas
 * @param int id_jogo
 * @param int contador
 * @param string conn
 * 
 */

function aumentaCartasBiscadas($id_jogo, $contador, $conn) {
    $numero_cartas_biscadas_actualmente = mysqli_query($conn, "SELECT cartas_biscadas FROM estado_jogo WHERE id_jogo=$id_jogo");
    $incrementador = 0;
    while ($row = mysqli_fetch_row($numero_cartas_biscadas_actualmente)) {
        $incrementador = $incrementador + $row[0];
    }
    $incrementador = $incrementador + $contador;
    mysqli_query($conn, "UPDATE estado_jogo SET cartas_biscadas=$incrementador WHERE id_jogo=$id_jogo");
}

/*
 * aumenta os turnos do jogo
 * @param int id_jogo
 * @param int n_turnos
 * @param int turno_jogador
 * @param string conn
 * @param string nickname
 * 
 */

function mudaTurno($id_jogo, $n_turnos, $turno_jogador, $conn, $nickname) {
    biscar($id_jogo, $nickname, $conn);

    $turno_jogador = intval($turno_jogador);

    $novo_turno = obtemNumeroTurnoActual($id_jogo, $conn) + 1;

    $query_numero_jogadores = "SELECT n_jogadores FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado_numero_jogadores = mysqli_query($conn, $query_numero_jogadores);

    $row = mysqli_fetch_assoc($resultado_numero_jogadores);
    $numero_jogadores = intval($row['n_jogadores']);
    if (intval($turno_jogador + 1) > $numero_jogadores) {
        $proximo_jogador = 1;
    } else {
        $proximo_jogador = intval($turno_jogador + 1);
    }
    $contador = 0;
    infectaCidades($id_jogo, $conn);

    mysqli_query($conn, "UPDATE estado_jogo SET n_turnos=$novo_turno, turno_jogador=$proximo_jogador, jogadas=0 WHERE id_jogo='$id_jogo'");
}

/*
 * verifica o turno actual
 * @param int id_jogo
 * @param string conn
 * 
 * @return int
 */

function obtemNumeroTurnoActual($id_jogo, $conn) {
    $query_numero_jogadores = "SELECT n_turnos FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $executa_query = mysqli_query($conn, $query_numero_jogadores);
    $get_n_turnos = mysqli_fetch_assoc($executa_query);
    $n_turnos = $get_n_turnos['n_turnos'];
    return intval($n_turnos);
}

/*
 * procura as cidades com centros de pesquisa criados
 * @param int id_jogo
 * @param string conn
 * 
 * @return array
 */

function obtemCentrosPesquisa($id_jogo, $conn) {
    $query_select_cps = "SELECT centros_pesquisa FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado_cps = mysqli_query($conn, $query_select_cps);
    $ids_cidades = array();
    while ($cidades = mysqli_fetch_assoc($resultado_cps)) {
        $cidades_separadas = explode(',', $cidades['centros_pesquisa']);
        foreach ($cidades_separadas as $cidades) {
            if ($cidades != '') {
                $ids_cidades[] = $cidades;
            }
        }
    }

    return $ids_cidades;
}

/*
 * cria um novo centro de pesquisa na cidade actual
 * @param int id_jogo
 * @param int id_cidade
 * @param string carta
 * @param string conn 
 * 
 */

function criarCentroPesquisa($id_jogo, $id_cidade, $carta, $jogador, $conn) {
    $query_select_cps = "SELECT centros_pesquisa FROM estado_jogo WHERE id_jogo='$id_jogo'";
    $resultado_cps = mysqli_query($conn, $query_select_cps);
    $string_update_cps = '';
    while ($cidades = mysqli_fetch_assoc($resultado_cps)) {
        $cidades_separadas = explode(',', $cidades['centros_pesquisa']);
        foreach ($cidades_separadas as $cidades) {
            if ($cidades != '' && $cidades != $id_cidade) {
                $string_update_cps .= $cidades . ',';
            }
        }
    }
    $string_update_cps .= $id_cidade . ',';
    removeCarta($id_jogo, $carta, $jogador, $conn);

    mysqli_query($conn, "UPDATE estado_jogo SET centros_pesquisa='$string_update_cps' WHERE id_jogo='$id_jogo'");
    incrementaNumeroJogadas($id_jogo, $conn);
}

/*
 * muda o estado da carta de nao jogada para jogada
 * @param int id_jogo
 * @param string carta
 * @param string jogador
 * @param string conn 
 * 
 */

function removeCarta($id_jogo, $carta, $jogador, $conn) {
    $query_actualiza_carta_jogada = "UPDATE cartas_jogador SET ja_jogada=1 WHERE id_jogo=$id_jogo AND id_jogador='$jogador' AND carta='$carta'";
    mysqli_query($conn, $query_actualiza_carta_jogada);
}

/*
 * Verifica estado da infecao no jogo
 * @param int id_jogo
 * @param string conn
 * 
 * @return array
 */

function obtemVelocidadeInfecao($id_jogo, $conn) {
    $infecao = array();
    $query_velocidade_infecao = "SELECT velocidade_infecao, mudar_velocidade, surtos FROM estado_jogo WHERE id_jogo=$id_jogo";
    $executa_query = mysqli_query($conn, $query_velocidade_infecao);
    $row = mysqli_fetch_assoc($executa_query);
    $infecao['velocidade'] = $row['velocidade_infecao'];
    $infecao['muda_velocidade'] = $row['mudar_velocidade'];
    $infecao['surtos'] = $row['surtos'];

    return $infecao;
}

/*
 * Retira uma doenca da cidade
 * @param int id_jogo
 * @param int id_cidade
 * @param string conn
 */

function removeUmaDoencaEmCidade($id_jogo, $id_cidade, $conn) {
    $numero_doencas_actuais_na_cidade = contaInfecoes($id_cidade, $id_jogo, $conn);
    if ($numero_doencas_actuais_na_cidade > 0) {
        $numero_doencas_actualizado = $numero_doencas_actuais_na_cidade - 1;
        actualizaNumeroDoencas($id_cidade, $id_jogo, $numero_doencas_actualizado, $conn);
        incrementaNumeroJogadas($id_jogo, $conn);
    }
}

/*
 * Permite saber se a página deve fazer refresh, pedido por ajax
 * @param int jogo
 * @param string conn
 */

function getJogadaActual($jogo, $conn) {

    echo json_encode(array('jogada' => verificaNumeroJogadasFeitas($jogo, $conn), 'turno' => obtemNumeroTurnoActual($jogo, $conn)));
}

/*
 * atribui doencas a cidades no final de cada turno
 * @param int id_jogo
 * @param string conn
 */

function infectaCidades($id_jogo, $conn) {

    $cidades_a_infectar = array();
    $estado_infeccao = obtemVelocidadeInfecao($id_jogo, $conn);
    $contador = 0;
    while ($contador < $estado_infeccao['velocidade']) {
        $possivel_id = rand(1, 40);
        while (in_array($possivel_id, $cidades_a_infectar) || verificaSeDoencaEstaErradicada($id_jogo, obterUmaCidade($possivel_id, $conn)[0]['cor'], $conn)) {
            $possivel_id = rand(1, 40);
        }
        $cidades_a_infectar[] = $possivel_id;
        $contador++;
    }

    foreach ($cidades_a_infectar as $cidade) {
        if (verificaCidadeInfectada($cidade, $id_jogo, $conn)) {
            if (contaInfecoes($cidade, $id_jogo, $conn) < 3) {
                actualizaNumeroDoencas($cidade, $id_jogo, contaInfecoes($cidade, $id_jogo, $conn) + 1, $conn);
            } else {
                originaOutbreak($id_jogo, $cidade, $conn);
            }
        } else {
            insereNovaDoencaEmCidade($id_jogo, $cidade, $conn);
        }
    }
}

/*
 * atribui uma doenca a uma cidade ainda nao infectada
 * @param int id_jogo
 * @param int id_cidade
 * @param string conn
 */

function insereNovaDoencaEmCidade($id_jogo, $id_cidade, $conn) {
    $cidade_especificada = obterUmaCidade($id_cidade, $conn)[0];
    $nome_cidade = $cidade_especificada['nome'];
    $cor = $cidade_especificada['cor'];
    $insere_cidade_com_doenca = "INSERT INTO cidades_infectadas (id_jogo, id_cidade, nome_cidade,n_doencas, cor) VALUES ($id_jogo, $id_cidade, '$nome_cidade', 1, '$cor') ";
    mysqli_query($conn, $insere_cidade_com_doenca);
}

/*
 * altera o estado das infecoes, conforme o surto
 * @param int id_jogo
 * @param string conn 
 * 
 */

function incrementaVelocidadeInfeccao($id_jogo, $conn) {
    /*
     * mudar_velocidade 0,1,2 = velocidade_infecao 2
     * mudar_velocidade 3,4 = velocidade_infecao 3
     * mudar_velocidade 5, >5 = velocidade_infecao 4
     */
    $estado_infecao = obtemVelocidadeInfecao($id_jogo, $conn);
    switch ($estado_infecao['surtos'] + 1) {
        case 1:
        case 2:
            $velocidade_infecao = 2;
            break;
        case 3:
        case 4:
            $velocidade_infecao = 3;
            break;
        case 5:
            $velocidade_infecao = 4;
            break;
        default :
            $velocidade_infecao = 4;
            break;
    }
    $incremento_numero_de_surto = $estado_infecao['surtos'] + 1;
    mysqli_query($conn, "UPDATE estado_jogo SET surtos='$incremento_numero_de_surto', velocidade_infecao='$velocidade_infecao' WHERE id_jogo='$id_jogo'");
}

/*
 * provoca um surto numa cidade
 * @param int id_jogo
 * @param int id_cidade
 * @param string conn
 */

function originaSurto($id_jogo, $id_cidade, $conn) {
    if (verificaCidadeInfectada($id_cidade, $id_jogo, $conn)) {
        actualizaNumeroDoencas($row['id'], $id_jogo, 3, $conn);
        originaOutbreak($id_jogo, $id_cidade, $conn);
    } else {
        insereNovaDoencaEmCidade($id_jogo, $row['id'], $conn);
        actualizaNumeroDoencas($row['id'], $id_jogo, 3, $conn);
    }
}

/*
 * Espalha doencas para cidades vizinhas
 * @param int id_jogo
 * @param int id_cidade
 * @param string conn
 */

function originaOutbreak($id_jogo, $id_cidade, $conn) {

    $cidade_especificada = obterUmaCidade($id_cidade, $conn)[0];


    $array_nome_de_cidades = explode(', ', $cidade_especificada['conexoes']);

    foreach ($array_nome_de_cidades as $cidade) {
        $query_ids_cidades = "SELECT * FROM cidades WHERE nome='$cidade'";

        $executa_query = mysqli_query($conn, $query_ids_cidades);
        $row = mysqli_fetch_assoc($executa_query);


        if (verificaCidadeInfectada($row['id'], $id_jogo, $conn)) {
            if (contaInfecoes($row['id'], $id_jogo, $conn) < 3) {
                actualizaNumeroDoencas($row['id'], $id_jogo, contaInfecoes($row['id'], $id_jogo, $conn) + 1, $conn);
            }
        } else {
            insereNovaDoencaEmCidade($id_jogo, $row['id'], $conn);
        }
    }
}

/*
 * Verifica se o jogo pode continuar ou termina
 * 
 * @param int id_jogo
 * @param string conn
 * 
 * @return string
 */

function confirmaJogoADecorrer($id_jogo, $conn) {
    $estado = '';

    if (verificaSeDoencaEstaErradicada($id_jogo, "Vermelho", $conn) && verificaSeDoencaEstaErradicada($id_jogo, "Amarelho", $conn) && verificaSeDoencaEstaErradicada($id_jogo, "Azul", $conn) && verificaSeDoencaEstaErradicada($id_jogo, "Preto", $conn)) {
        $estado = 'Vitoria';
        mysqli_query($conn, "UPDATE estado_jogo SET estado='$estado' WHERE id_jogo=$id_jogo");
//        return $estado;
        echo json_encode(array('estado' => $estado));
    } else {
        $estado = 'Derrota';

        $query_cartas_biscadas = "SELECT cartas_biscadas FROM estado_jogo WHERE id_jogo=$id_jogo";
        $executa_query = mysqli_query($conn, $query_cartas_biscadas);
        $row = mysqli_fetch_assoc($executa_query);
        if ($row['cartas_biscadas'] >= 40) {
            mysqli_query($conn, "UPDATE estado_jogo SET estado='Derrota' WHERE id_jogo=$id_jogo");
//            return $estado;
            echo json_encode(array('estado' => $estado));
        }
        $numero_cidades_infectadas = "SELECT * FROM cidades_infectadas WHERE id_jogo=$id_jogo";
        $executa_query_cidades = mysqli_query($conn, $numero_cidades_infectadas);
        $total_cidades_infectadas = mysqli_num_rows($executa_query_cidades);
        if ($total_cidades_infectadas >= 40) {
            mysqli_query($conn, "UPDATE estado_jogo SET estado='Derrota' WHERE id_jogo=$id_jogo");
//            return $estado;
            echo json_encode(array('estado' => $estado));
        }
    }
    
    $estado = mysqli_fetch_assoc(mysqli_query($conn, "SELECT estado FROM estado_jogo WHERE id_jogo=$id_jogo"))['estado'];
    echo json_encode(array('estado' => $estado));
}
