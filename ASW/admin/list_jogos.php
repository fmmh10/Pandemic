<?php
include('../db_config.php');

if (!isset($_COOKIE['admin'])) {
    exit();
}

include './functions.php';

if (isset($_POST['procurar']) && $_POST['procurar'] != '') {
    $result_lista = pesquisaEstadoJogo($conn, $_POST['procurar']) or die();
} else {
    $result_lista = pesquisaEstadoJogo($conn) or die();
}

if (isset($_POST['a_procurar']) && $_POST['a_procurar']) {

    $campo_a_procurar = $_POST['a_procurar'];
    $valor_a_procurar = $_POST['especifico_a_procurar'];
    $result_lista = pesquisaJogoEspecifico($conn, $campo_a_procurar, $valor_a_procurar);
}
?>
<html>
    <?php include 'consts.php'; ?>
    <?php include 'headers.php'; ?>

    <body>
        <div class="container-fluid">
            <table>
                <tr>
                    <th>Jogo nº</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Nº Jogadores</th>
                    <th>Criado Por</th>
                    <th>Jogador 2</th>
                    <th>Jogador 3</th>
                    <th>Jogador 4</th>
                    <th>Data de criação</th>
                    <th>Data de início</th>
                    <th>Estado</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($result_lista)) {

                    $vista_geral = vistaGeralJogo($row['id_jogo'], $conn);
                    foreach ($vista_geral as $vista) {
                        $criador = $vista['criador'];
                        $nome = $vista['nome'];
                        $descricao = $vista['descricao'];
                        $data_criacao = $vista['data_comeco'];
                    }

//                    }
                    ?>
                    <tr>
                        <td><?php echo $row['id_jogo'] ?></td>
                        <td><?php echo $nome ?></td>
                        <td><?php echo $descricao ?></td>
                        <td><?php echo $row['n_jogadores'] ?></td>
                        <td><?php echo $criador ?></td>
                        <td><?php echo $row['jogador2'] ?></td>
                        <td><?php echo ($row['jogador3'] != 'NULL' ? $row['jogador3'] : "Vazio") ?></td>
                        <td><?php echo ($row['jogador4'] != 'NULL' ? $row['jogador4'] : "Vazio") ?></td>
                        <td><?php echo $data_criacao ?></td>
                        <td><?php echo $row['data_inicio'] ?></td>
                        <td><span class="<?php echo ($row['estado'] == 'Iniciado' ? "Verde" : "Vermelho") ?>"><?php echo $row['estado'] ?></span></td>


                        <?php
                    }
                    $detalhes = array();
                    ?>
                </tr>
                <?php
//                }
                ?>


            </table>
            <form action="" method="POST">
                <label for="procurar">Procurar por estado:</label>
                <select name="procurar">
                    <option value="">Todos</option>
                    <option value="Iniciado">Iniciado</option>
                    <option value="Desistiram">Desistiram</option>
                    <option value="Derrota">Terminado</option>
                    <option value="Vitoria">Vitória</option>
                </select>
                <button type="submit" class="btn btn-primary">Procurar</button>
            </form>
            <form action="" method="POST">
                <label for="procurar">Procurar por específicos:</label>
                <select name="a_procurar">
                    <option value="nome">Nome</option>
                    <option value="descricao">Descrição</option>
                    <option value="criador">Dono</option>
                </select>
                <input type="text" name="especifico_a_procurar" />
                <button type="submit" class="btn btn-primary">Procurar</button>
            </form>
        </div>

    </body>
    <style>
        .Verde{
            color: green;
        }
        .Vermelho{
            color: red;
        }
    </style>
</html>
