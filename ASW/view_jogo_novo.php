<div class="container">
    <div class="col-lg-12">
        <div class="row">
            <table>
                <tr>
                    <th>Jogadores</th>
                </tr>
                <tr>
                    <td><?php echo $linha['criador']; ?></td>
                </tr>
                <tr>
                    <td><?php echo ($linha['jogador2'] ? $linha['jogador2'] : "Lugar vago" ) ?></td>
                </tr>
                <tr>
                    <td><?php echo ($linha['jogador3'] ? $linha['jogador3'] : "Lugar vago" ) ?></td>
                </tr>
                <tr>
                    <td><?php echo ($linha['jogador4'] ? $linha['jogador4'] : "Lugar vago" ) ?></td>
                </tr>
            </table>
            <?php if (!checkPlayer($_GET['jogo'], $nickname_jogador, $conn)) { ?>
                <button class="join_game">Juntar-me a este jogo</button>
                <?php
            }
            if ($nickname_jogador == $linha['criador'] && $linha['jogador2']) {
                ?>
                <button id="iniciar_jogo">Começar o jogo</button>
            <?php } else { ?>
                <span>Aguarde para que se juntem mais pessoas...</span>
            <?php }
            ?>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="container-fluid">

        <div class="col-lg-5">
            <div class="row">

                <table id="tabela1">
                    <tr>
                        <th>Nome do jogo</th>
                        <th>Criado por</th>
                        <th>Descrição</th>
                        <th>Inicio do jogo</th>
                    </tr>
                    <tr>
                        <td> <?php echo $linha['nome']; ?> </td>
                        <td><?php echo $linha['criador']; ?></td>
                        <td><?php echo $linha['descricao']; ?></td>
                        <td> <?php echo $linha['data_comeco']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>