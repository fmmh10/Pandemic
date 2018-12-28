<!DOCTYPE html>
<html>
    <head>
        <title>Pandemic</title>
        <?php include('headers.php'); ?>
    </head>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>
        <div class="registo">
            <h2>Recover</h2>
            <form method="post" id="change_pass">
                <div class="form-group">
                    <label for="nickname">Nickname:</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" required>
                    <br>
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                    <br>
                    <label for="password">Nova password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <br>
                    <button type="button" onclick="" id="muda_password" class="btn btn-default">Mudar</button>
                </div>
            </form>
        </div>
        <div class="sucesso">

        </div>


    </body>
    <script>

        $('#muda_password').click(function () {
            var nickname = $('#nickname').val();
            var new_password = $('#password').val();
            var email = $('#email').val();

            $.ajax({
                url: 'mudar_pass.php',
                type: 'POST',
                data: {
                    nickname: nickname,
                    password: new_password,
                    email: email,
                },
                success: function (msg) {
                    console.log(msg);
                    if (msg == "alterado") {
                        $('#change_pass').hide();
                         $(".sucesso").html("");
                        $(".sucesso").append("<div>Password reposta com sucesso. Pode efectuar o login.</div>");

                    } else if (msg == "negado") {
                        $(".sucesso").append("<div>Ocorreu um erro. Verifique se colocou um nickname e um e-mail válidos.</div>");
                    }
                }
            });
        });

    </script>
</html>
