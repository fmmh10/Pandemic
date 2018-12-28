<!DOCTYPE html>
<html>
    <?php
    include('headers.php');
    include('functions.php');
    include("db_config.php");
    $meu_login = $_COOKIE['user'];
    $query = "SELECT id, nome, descricao, jogadores_actuais, n_jogadores, data_comeco, criador FROM jogo WHERE criador='$meu_login' OR jogador2='$meu_login' OR jogador3='$meu_login' OR jogador4='$meu_login'";
    $dados = mysqli_query($conn, $query) or die();
    $linha = mysqli_fetch_assoc($dados); // transforma numa lista
    $total = mysqli_num_rows($dados);   //total de dados
    ?>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>
        <div id="logs">
            <button id="botao_logout" href="homepage.php">Voltar</button>
        </div>


        <div class="registo">
            <h2>Lista de jogos</h2>
            <table border="1" id="lista_jogos">
                <td class="cabecalho">Nome</td>
                <td class="cabecalho">Descrição</td>
                <td class="cabecalho">Nº de jogadores</td>
                <td colspan="1" class="cabecalho">Criado por</td>
                <td class="cabecalho">Opções</td>
                <tbody>
                    <?php
                    // se o número de resultados for maior que zero, mostra os dados
                    if ($total > 0) {
                        // inicia o loop que vai mostrar todos os dados
                        do {
                            ?>

                            <tr>
                                <td><?php echo $linha['nome'] ?> </td>
                                <td><?php echo $linha['descricao'] ?> </td>
                                <td><?php echo $linha['n_jogadores'] ?></td>
                                <td><?php echo $linha['criador'] ?></td>

                                <td><a href="jogo.php?jogo=<?php echo $linha['id'] ?>"><button id="juntar_jogo" class="btn btn-success"> Juntar a jogo</button></a></td>

                            </tr>

                            <?php
                            // finaliza o loop que vai mostrar os dados
                        } while ($linha = mysqli_fetch_assoc($dados));
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <script type="text/javascript">
            $('#botao_logout').click(function () {
                window.location.replace("homepage.php");
            })

        </script>
    </body>
</html>
