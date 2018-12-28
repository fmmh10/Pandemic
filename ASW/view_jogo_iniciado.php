
<div class="col-lg-12">
    <div class="container-fluid">

        <div class="col-lg-8">
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

                <br>

                <table id="tabela_cidades">
                    <tr>
                        <th>Cidade</th>
                        <th>Conexões</th>
                        <th>Centro de Pesquisa</th>
                        <th>Número de doenças</th>
                    </tr>
                    <?php foreach ($cidades as $cidade) { ?>
                        <tr>
                            <td><span class="<?php echo $cidade['cor'] ?>"><?php echo $cidade['nome'] ?></span></td>
                            <td><?php echo $cidade['conexoes'] ?></td>
                            <td data-id_cidade="<?php echo $cidade['id'] ?>"><?php
                                if (in_array($cidade['id'], $centros_pesquisa)) {
                                    echo "<span class='Verde'>Sim</span>";
                                } else {
                                    echo "<span class='Vermelho'>Não</span>";
                                }
                                ?></td>
                            <?php
                            if (verificaCidadeInfectada($cidade['id'], $_GET['jogo'], $conn)) {
                                switch (contaInfecoes($cidade['id'], $_GET['jogo'], $conn)) {
                                    case 1:
                                        $classe = "Verde";
                                        break;
                                    case 2:
                                        $classe = "Laranja";
                                        break;
                                    case 3:
                                        $classe = "Vermelho_Urgente";
                                        break;
                                }
                                ?>
                                <td><span class="<?php echo $classe ?>"><?php echo contaInfecoes($cidade['id'], $_GET['jogo'], $conn) ?></span></td>
                            <?php } else {
                                ?>
                                <td><span class="">Sem doenças</span></td>

                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>

                </table>

                <br>

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
        <div class="col-lg-4">
            <div class="row">
                <table id="dados_jogadores">
                    <th id="nomes">Jogadores</th>
                    <th id="cartas">Cartas</th>
                    <th id="posicao">Posição</th>
                    </tr>
                    <tr>
                        <td><?php echo $verifica_jogo['jogador1']; ?></td>
                        <td><?php echo $cartas_jogador1 ?></td>
                        <td><span class="<?php echo($cidade_actual_jogador1['cor']); ?>"><?php echo($cidade_actual_jogador1['nome']); ?></span></td>
                    </tr>
                    <tr>
                        <td><?php echo $verifica_jogo['jogador2']; ?></td>
                        <td><?php echo $cartas_jogador2 ?></td>
                        <td><span class="<?php echo($cidade_actual_jogador2['cor']); ?>"><?php echo($cidade_actual_jogador2['nome']); ?></span></td>
                    </tr>

                    <?php if ($verifica_jogo['jogador3'] != 'NULL' && $verifica_jogo['jogador3'] != "") { ?>
                        <tr>
                            <td ><?php echo $verifica_jogo['jogador3']; ?></td>
                            <td><?php echo $cartas_jogador3 ?></td>
                            <td><span class="<?php echo($cidade_actual_jogador3['cor']); ?>"><?php echo($cidade_actual_jogador3['nome']); ?></span></td>
                        </tr>
                        <?php
                    }
                    if ($verifica_jogo['jogador4'] != 'NULL' && $verifica_jogo['jogador4'] != "") {
                        ?>
                        <tr>
                            <td><?php echo $verifica_jogo['jogador4']; ?></td>
                            <td><?php echo $cartas_jogador4 ?></td>
                            <td><span class="<?php echo($cidade_actual_jogador4['cor']); ?>"><?php echo($cidade_actual_jogador4['nome']); ?></span></td>
                        </tr>
                    <?php } ?>

                </table>
                <?php if (!checkPlayer($_GET['jogo'], $nickname_jogador, $conn)) { ?>
                    <button class="join_game">Juntar-me a este jogo</button>
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <span class="turno">Turno do jogador:</span>
                <p class="jogador_actual"><?php echo (obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn) == $_COOKIE['user'] ? "É a sua vez" : obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn)) ?></p>
                <span class="turno">Turno número:</span>
                <p class="numero_turnos"><?php echo $verifica_jogo['n_turnos'] ?></p>
                <span class="turno">Jogada número:</span>
                <p class="numero_turnos"><?php echo verificaNumeroJogadasFeitas($_GET['jogo'], $conn) + 1 ?></p>
            </div>
        </div>
    </div>

    <?php if ($_COOKIE['user'] == obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn) && verificaNumeroJogadasFeitas($_GET['jogo'], $conn) <= 3) { ?>
        <?php if (checkPlayer($_GET['jogo'], $nickname_jogador, $conn)) { ?>


            <div class="controlos_jogo container">
                <h3>Controlos do Jogo</h3>
                <?php if (verificaCidadeInfectada($cidade_jogador['id'], $_GET['jogo'], $conn)) { ?>
                    <button type="button" id="tratar_uma_doenca">Tratar uma doença</button>
                <?php } ?>
                <button type="button" id="move">Deslocar para outra cidade</button>
                <?php if (!in_array($cidade_jogador['id'], $centros_pesquisa) && in_array($cidade_jogador['nome'], $cartas_disponiveis)) { ?>
                    <button type="button" id="criar_cp" value="<?php echo $cidade_jogador['id'] ?>">Criar centro de Pesquisa</button>
                <?php } if ($pode_criar_cura && verificaSePodeCurarDoenca($_GET['jogo'], $_COOKIE['user'], $conn)) { ?>
                    <button type="button" id="abrir_cartas_de_cura" >Descobrir cura</button>
                <?php } ?>
                <button type="button" class="btn btn-info" id="fim_turno">Terminar o turno.</button>

                <div id="destinations"></div>
                <?php if ($_COOKIE['user'] == $verifica_jogo['jogador1'] && $verifica_jogo['jogador1'] == obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn)) { ?>
                    <div class="row" id="curar_doenca">
                        <h5>Escolha as cartas para jogar.</h5>
                        <?php
                        $cartas_jogaveis = $cartas_na_mao_jogador[$cidade_jogador['cor']];

                        $array_completo_cartas = obtemCartasJogador($_GET['jogo'], $_COOKIE['user'], $conn);

                        foreach ($array_completo_cartas as $carta) {
                            if (in_array($carta['id_carta'], $cartas_jogaveis)) {
                                $cor_a_erradicar = $carta['cor'];
                                ?>
                                <button class="btn btn-info botoes_cartas <?php echo $carta['cor'] ?>" value="<?php echo $carta['id_carta'] ?>"><?php echo $carta['carta'] ?></button>
                                <?php
                            }
                        }
                        ?>
                        <button id="jogar_cartas">Jogar Cartas</button>
                        <button id="cancelar_jogada">Cancelar</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-danger btn-lg" id="abrir_modal_desistir" data-toggle="modal" data-target="#modal_desistir">DESISTIR DO JOGO</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    } else if ($_COOKIE['user'] == obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn) && verificaNumeroJogadasFeitas($_GET['jogo'], $conn) > 3) {
        if (checkPlayer($_GET['jogo'], $nickname_jogador, $conn)) {
            ?>
            <div class="controlos_jogo container">
                <h3>Já fez toda as jogadas possíveis</h3>
                <button type="button" class="btn btn-info" id="fim_turno">Terminar o turno.</button>
            </div>
            <?php
        }
    } else if ($_COOKIE['user'] != obtemTurnoDoJogador($_GET['jogo'], $verifica_jogo['turno_jogador'], $conn)) {
        ?>
        <div class = "controlos_jogo container">
            <h3>Aguarde pelo seu turno...</h3>

        </div>
    <?php }
    ?>

</div>


<div id="modal_desistir" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tem a certeza de que quer desisitr?</h4>
            </div>
            <div class="modal-body">
                <p>Desistir é uma escolha definitiva e irreversível.</p>
            </div>
            <div>
                <button type="button" class="btn btn-success botoes-modal" data-dismiss="modal">Pensando bem, não vou desistir.</button>
                <button type="button" class="btn btn-danger botoes-modal" id="desistir" value="<?php echo $_GET['jogo'] ?>">Não vale a pena. A humanidade está condenada!</button>
            </div>
        </div>
    </div>
</div>


<script>


    $(document).ready(function () {

        $("#curar_doenca").hide();
        $('#jogar_cartas').hide()
        //scoped
        var JOGO = '<?php echo $_GET['jogo']; ?>';
        var JOGADA_ACTUAL = parseInt(<?php echo verificaNumeroJogadasFeitas($_GET['jogo'], $conn); ?>);
        var TURNO = '<?php echo $verifica_jogo['n_turnos'] ?>'

        //cria-se uma funcao global para aceder à variavel scoped.
        window.getJogadaActual = function () {
            return JOGADA_ACTUAL;
        };

        window.getJogo = function () {
            return JOGO;
        };

        window.getTurnoActual = function () {
            return TURNO
        }

        $('#abrir_cartas_de_cura').on("click", function () {
            $("#curar_doenca").show("fast");
            $('#abrir_cartas_de_cura').hide();
        });
        $('#cancelar_jogada').on('click', function () {
            location.reload();
        });

        var array_cartas = new Array();


        $('.botoes_cartas').click(function () {
            array_cartas.push($(this).val());
            $(this).hide("fast");
            if (array_cartas.length === 5) {
                $('#jogar_cartas').show("fast");
                $('.botoes_cartas').hide();
            }
        });

        $('#jogar_cartas').click(function () {
            var cartas = array_cartas;
            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "erradicar_doenca",
                    id_jogo: '<?php echo $_GET['jogo'] ?>',
                    jogador: '<?php echo $_COOKIE['user'] ?>',
                    cartas: cartas,
                    cor: '<?php echo (isset($cor_a_erradicar) ? $cor_a_erradicar : "NULL") ?>'
                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

        $('#tratar_uma_doenca').click(function () {
            var id_cidade = <?php echo $cidade_jogador['id'] ?>;
            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "curar_uma_doenca",
                    id_jogo: '<?php echo $_GET['jogo'] ?>',
                    jogador: '<?php echo $_COOKIE['user'] ?>',
                    id_cidade: id_cidade
                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

        $('#criar_cp').click(function () {
            var id_cidade = $(this).val();
            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "criar_cp",
                    id_jogo: '<?php echo $_GET['jogo'] ?>',
                    jogador: '<?php echo $_COOKIE['user'] ?>',
                    id_cidade: id_cidade,
                    carta: '<?php echo $cidade_jogador['nome'] ?>',
                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

        $('#fim_turno').click(function () {
            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "turno",
                    id_jogo: '<?php echo $_GET['jogo'] ?>',
                    n_turno: '<?php echo $verifica_jogo['n_turnos'] ?>',
                    turno_jogador: '<?php echo $verifica_jogo['turno_jogador'] ?>',
                    nickname: "<?php echo $nickname_jogador ?>",
                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

        $('#move').click(function () {
            var posicao_actual = "<?php echo $cidade_jogador['nome'] ?>";

            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "conexoes",
                    cidade_actual: posicao_actual,
                },
                success: function (msg) {
                    $(".controlos_jogo").append('<div id="destinations"></div>');
                    $("#destinations").append(msg);
                    $("#move").hide("fast");
                    $('#cancel').on('click', function () {
                        location.reload();
                    });
                    $('.cidade_escolhida').on('click', function () {
                        moverParaCidade($(this).val());
                    });
                }
            });

        });

        $('#desistir').click(function () {
            console.log("desistir?");
            var id_jogo = $(this).val();
            $.ajax({
                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "desistir",
                    id_jogo: id_jogo,
                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

    });



    /**
     * 
     * @return {undefined}     
     */
    function testarJogadaActual() {
        $.ajax({
            url: 'controlos_jogo.php',
            data: {
                'funcao': 'getJogadaActual',
                'id_jogo': getJogo(),
                'turno': getTurnoActual(),
            },
            method: 'post',
            dataType: 'json',
            success: function (json) {

                if (parseInt(json.jogada) != getJogadaActual() || parseInt(json.turno) != getTurnoActual()) {
                    window.location.reload();
                } else {
                    setTimeout(testarJogadaActual, 2000);
                }
            }
        });
    }

    setTimeout(testarJogadaActual, 2000);





    function moverParaCidade($destino) {

        $.ajax({
            url: 'controlos_jogo.php',
            type: 'POST',
            data: {
                funcao: "mover",
                destino: $destino,
                id_jogo: "<?php echo $_GET['jogo'] ?>",
                nickname: "<?php echo $nickname_jogador ?>",

            },
            success: function (msg) {
                $(".controlos_jogo").append('<div id="destinations"></div>');
                $("#destinations").append(msg);
                $("#move").hide("fast");
                $('#cancel').on('click', function () {
                    location.reload();
                });
                $('.cidade_escolhida').on('click', function () {
                    moverParaCidade($(this).val());
                });
            }
        });
    }
</script>
