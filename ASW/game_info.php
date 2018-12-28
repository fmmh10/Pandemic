<!DOCTYPE html>
<html>
    <?php
    include('headers.php');
    include('functions.php');

    ?>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>

        <script type="text/javascript">

          $(document).ready(function () {
              var d = new Date();
              var n = d.getHours();
              var j = d.getMinutes();
              document.getElementById("horas").innerHTML = n + ":" + j;
          });

        </script>

        <style media="screen">

          table, th, td {
            border: 1px solid black;
          }

          .controlos_jogo {
            float: right;
          }


        </style>

        <div class="controlos_jogo">
          <h3>Controlos do Jogo</h3>
          <button type="button">Tratar uma doença</button>
          <button type="button">Deslocar para outra cidade</button>
          <button type="button">Criar centro de Pesquisa</button>
          <button type="button">Descobrir cura</button>
        </div>

        <table id="tabela1">
          <tr>
            <th>Nome do jogo</th>
            <th>Hora de inicio do jogo</th>
          </tr>
          <tr>
            <td> <!--Nome do jogo a ir buscar à base de dados --> </td>
            <td id="horas"> </td>
          </tr>
        </table>
        <br>

        <table id="tabela_jogadores">
          <tr>
            <th>Jogadores</th>
            <th>Cartas</th>
            <th>Jogador Atual</th>
            <th>Posição</th>
          </tr>
          <tr>
            <td>jogador1</td>
            <td>Paris, Beijim</td>
            <td>Sim</td>
            <td>Miami</td>
          </tr>
          <tr>
            <td>jogador2</td>
            <td>Roma</td>
            <td>Não</td>
            <td>Miami</td>
          </tr>
        </table>
        <br>
        <br>

        <table id="tabela_cidades">
          <tr>
            <th>Cidade</th>
            <th>Cor da carta</th>
            <th>Conexões</th>
            <th>Centro de Pesquisa</th>
            <th>Número de doenças</th>
          </tr>
          <tr>
            <td>Madrid</td>
            <td>Azul</td>
            <td>Londres, Paris, New-York </td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>Atlanta</td>
            <td>Azul</td>
            <td>Chicago, Miami, Washington </td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>Miami</td>
            <td>Amarelo</td>
            <td>Washington, Atlanta, Mexico City, Bogotá </td>
            <td>1</td>
            <td>2</td>
          </tr>
          <tr>
            <td>São Paulo</td>
            <td>Amarelo</td>
            <td>Buenos Aires, Bogotá, Lagos, Madrid </td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>Moscow</td>
            <td>Preto</td>
            <td>St. Petersburg, Istanbul, Tehran</td>
            <td>0</td>
            <td>1</td>
          </tr>
          <tr>
            <td>Bagdad</td>
            <td>Preto</td>
            <td>Tehran, Istanbul, Cairo</td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>Tokyo</td>
            <td>Vermelho</td>
            <td>Seoul,Osaka,Shanghai,San Francisco</td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>Shanghai</td>
            <td>Vermelho</td>
            <td>Hong Kong,Tripei,Tokyo,Sedul,Beijing</td>
            <td>1</td>
            <td>2</td>
          </tr>

        </table>
        <br>

        <table id="tabela_surtos">
          <tr>
            <th>Velocidade da infeção</th>
            <th>Surtos</th>
            <th>Número de centros de Pesquisa</th>
          </tr>
          <tr>
            <td>3</td>
            <td>0</td>
            <td>2</td>
          </tr>

        </table>
        <br>
        <table id="tabela_curas">
          <tr>
            <th>Cura_Azul</th>
            <th>Cura_Vermelho</th>
            <th>Cura_Preto</th>
            <th>Cura_Amarelo</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>


    </body>
</html>
