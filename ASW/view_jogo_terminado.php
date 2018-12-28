
<div class="col-lg-12">
    <div class="container-fluid">
        <div class="col-lg-3">
        </div>

        <div class="col-lg-6">
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
        <div class="col-lg-3">
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-lg-3">
        </div>

        <div class="col-lg-6">
            <div class="row">

                <table id="tabela_surtos">
                    <tr>
                        <th>Velocidade da infeção</th>
                        <th>Surtos</th>
                        <th>Número de centros de Pesquisa</th>
                    </tr>
                    <tr>
                        <td><?php echo $estado_infecao['velocidade'] ?></td>
                        <td><?php echo $estado_infecao['surtos'] ?></td>
                        <td><?php echo count($centros_pesquisa) ?></td>
                    </tr>

                </table>
                <br>
                <table id="tabela_curas">
                    <tr>
                        <th class="Azul">Cura Azul</th>
                        <th class="Vermelho">Cura Vermelho</th>
                        <th class="Preto">Cura Preto</th>
                        <th class="Amarelo">Cura Amarelo</th>
                    </tr>
                    <tr>
                        <td><?php echo(verificaSeDoencaEstaErradicada($_GET['jogo'], 'Azul', $conn) ? "<span>Descoberta!</span>" : "<span>Por descobrir</span>") ?></td>
                        <td><?php echo(verificaSeDoencaEstaErradicada($_GET['jogo'], 'Vermelho', $conn) ? "<span>Descoberta!</span>" : "<span>Por descobrir</span>") ?></td>
                        <td><?php echo(verificaSeDoencaEstaErradicada($_GET['jogo'], 'Preto', $conn) ? "<span>Descoberta!</span>" : "<span>Por descobrir</span>") ?></td>
                        <td><?php echo(verificaSeDoencaEstaErradicada($_GET['jogo'], 'Amarelo', $conn) ? "<span>Descoberta!</span>" : "<span>Por descobrir</span>") ?></td>
                    </tr>
                </table>
            </div>

        </div>
        <div class="col-lg-3">
        </div>
    </div>
    <div class="container">
        <div class="col-lg-12">
            <?php if ($verifica_jogo['estado'] == 'Desistiram') { ?>
                <div class="row game_over">
                    <span >Game over!</span>
                    <h4>Desistiram.</h4>
                    <h4>A iminência da dizimação do mundo foi demasiado para se aguentar.</h4>
                    <h4>Melhor sorte numa próxima.</h4>
                </div>
            <?php } else if ($verifica_jogo['estado'] == 'Vitoria') { ?>
                <span style="color: green">Vitória!</span>
                <h4>Após muito esforço e suor, eis que surge um futuro risonho para a humanidade.</h4>
                <h4>Mas quem sabe se estarão prontos para uma nova epidemia?</h4>
            <?php } else if ($verifica_jogo['estado'] == 'Derrota') { ?>
                <span style="color: green">Game over!</span>
                <h4>Apesar do esforço sobrehumano para salvar a humanidade, a natureza não está munida de compaixão.</h4>
                <h4>Talvez se as coisas tivessem sido feitas de outra forma...</h4>
            <?php } ?>
        </div>
    </div>
</div>

