<?php
if (!$_COOKIE["user"]) {
    exit;
} else {
    $nickname_jogador = $_COOKIE["user"];
}
;

include 'headers.php';
include 'controlos_jogo.php';

$query = "SELECT * FROM jogo WHERE id ='" . $_GET['jogo'] . "' ";

$dados = mysqli_query($conn, $query) or die();
$linha = mysqli_fetch_assoc($dados); // transforma numa lista
$total = mysqli_num_rows($dados);   //total de dados

$cidades = obterCidades($conn);


$verifica_jogo = verificaEstadoJogo($_GET['jogo'], $conn);
if ($verifica_jogo) {
    if ($verifica_jogo['estado'] != 'Iniciado') {
        $terminado = true;
    } else {
        $terminado = false;
    }
}
?>
<!--<!DOCTYPE html>
<html>-->
<?php
include('headers.php');
include('functions.php');
?>
<div class="container">
    <!--<h1 id="titlexxx" style="display: inline-block"><a href="index.php" style="display: inline-block"><img id="logo" src="fundo.jpg"/>PANDEMIC</a></h1>-->
</div>

<?php
//var_dump(confirmaJogoADecorrer($_GET['jogo'], $conn));
//$verifica_jogo['estado'] == 'Iniciado';
if (!$verifica_jogo) {
    include './view_jogo_novo.php';
} else {
    if ($terminado) {
        $estado_infecao = obtemVelocidadeInfecao($_GET['jogo'], $conn);
         $centros_pesquisa = obtemCentrosPesquisa($_GET['jogo'], $conn);
        include './view_jogo_terminado.php';
    } else {
        $cartas_jogador1 = processaCartasJogador($_GET['jogo'], $verifica_jogo['jogador1'], $conn);
        $cidade_actual_jogador1 = obtemCidadeActual($_GET['jogo'], $verifica_jogo['jogador1'], $conn)[0];

        $cartas_jogador2 = processaCartasJogador($_GET['jogo'], $verifica_jogo['jogador2'], $conn);
        $cidade_actual_jogador2 = obtemCidadeActual($_GET['jogo'], $verifica_jogo['jogador2'], $conn)[0];


// <editor-fold defaultstate="collapsed" desc="Cartas para jogadores 3 e 4, se houverem">
        $cartas_jogador3 = processaCartasJogador($_GET['jogo'], $verifica_jogo['jogador3'], $conn);
        $cidade_actual_jogador3 = obtemCidadeActual($_GET['jogo'], $verifica_jogo['jogador3'], $conn)[0];
        $cartas_jogador4 = processaCartasJogador($_GET['jogo'], $verifica_jogo['jogador4'], $conn);
        $cidade_actual_jogador4 = obtemCidadeActual($_GET['jogo'], $verifica_jogo['jogador4'], $conn)[0];
// </editor-fold>

        $cidade_jogador = obtemCidadeActual($_GET['jogo'], $_COOKIE['user'], $conn)[0];

        $centros_pesquisa = obtemCentrosPesquisa($_GET['jogo'], $conn);

        $cartas_na_mao_jogador = separaCartasPorCor($_GET['jogo'], $_COOKIE['user'], $conn);

        $cartas_disponiveis = array();
        $cartas_processadas = array();
        if ($_COOKIE['user'] == $verifica_jogo['jogador1']) {
            $cartas_processadas = explode(", ", $cartas_jogador1);
        } else if ($_COOKIE['user'] == $verifica_jogo['jogador2']) {
            $cartas_processadas = explode(", ", $cartas_jogador2);
        } else if ($_COOKIE['user'] == $verifica_jogo['jogador3']) {
            $cartas_processadas = explode(", ", $cartas_jogador3);
        } else if ($_COOKIE['user'] == $verifica_jogo['jogador4']) {
            $cartas_processadas = explode(", ", $cartas_jogador4);
        }

        foreach ($cartas_processadas as $cartas) {
            $cartas_disponiveis[] = strip_tags($cartas);
        }

        $estado_infecao = obtemVelocidadeInfecao($_GET['jogo'], $conn);

        $pode_criar_cura = verificaSePodeCurarDoenca($_GET['jogo'], $_COOKIE['user'], $conn);


        include './view_jogo_iniciado.php';
    }
}
?>

<style media="screen">

    table, th, td {
        border: 1px solid black;
    }

    .controlos_jogo {
        /*        float: right;*/
        text-align: center;
    }
    .desistir{
        height: 55px;
        width: 150px;
        color: white;
        background-color: red;
    }

    .Amarelo{
        font-size: 15px;
        font-weight: bold;
        color: yellow;
    }
    .Azul{
        font-size: 15px;
        font-weight: bold;
        color: blue;
    }
    .Vermelho_Urgente{
        font-size: 20px;
        font-weight: bolder;
        color: red;
    }
    .Laranja{
        font-size: 18px;
        font-weight: bold;
        color: firebrick;
    }
    .Vermelho{
        font-size: 15px;
        font-weight: bold;
        color: red;
    }
    .Preto{
        font-size: 15px;
        font-weight: bold;
        color: black;
    }
    .Verde{
        color: green;
        font-size: 15px;
        font-weight: bold;

    }

</style>

<script type="text/javascript">


    $(document).ready(function () {

        var CONFIRMAR_JOGO = '<?php echo $_GET['jogo']; ?>';
        var ESTADO_ACTUAL = '<?php echo $verifica_jogo['estado'] ?>';

        window.getCONFIRMAR_JOGO = function () {
            return CONFIRMAR_JOGO;
        };

        window.getESTADO_ACTUAL = function () {
            return ESTADO_ACTUAL;
        }



        setTimeout(verificarEstadoJogo, 2000);
        console.log("oi? no document");

        $('.join_game').click(function () {

//            console.log("entra");
            $.ajax({

                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "insert",
                    id_jogo: "<?php echo $_GET['jogo'] ?>",
                    nickname: "<?php echo $nickname_jogador ?>",

                },
                success: function (msg) {
                    console.log(msg)
                    if (msg == "success") {
                        location.reload();
                    }
                }
            });
        });
        $('#iniciar_jogo').click(function () {
            $.ajax({

                url: 'controlos_jogo.php',
                type: 'POST',
                data: {
                    funcao: "start",
                    id_jogo: "<?php echo $_GET['jogo'] ?>",
                    jogador1: "<?php echo $linha['criador'] ?>",
                    jogador2: "<?php echo $linha['jogador2'] ?>",
                    jogador3: "<?php echo $linha['jogador3'] ?>",
                    jogador4: "<?php echo $linha['jogador4'] ?>"

                },
                success: function (msg) {
                    location.reload();
                }
            });
        });

    });
    function verificarEstadoJogo() {
        $.ajax({
            url: 'controlos_jogo.php',
            data: {
                'funcao': 'verifica_estado_jogo',
                'id_jogo': getCONFIRMAR_JOGO(),
            },
            method: 'post',
            dataType: 'json',
            success: function (json) {
                if (json.estado != getESTADO_ACTUAL()) {
                    window.location.reload();
                } else {
                    setTimeout(verificarEstadoJogo, 2000);
                }
            }
        });
    }

</script>

</body>
