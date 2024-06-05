<?php
include('./log/conexao.php');
include('tailwind.php');

$error_message = ""; // Variável para erro

if (isset($_POST['email']) || isset($_POST['senha'])) {
    // Campos de falha para login
    if (strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");
        } else {
            $error_message = "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="Pt-Br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Help</title>
</head>
<body>
    <!--Formulario de login-->
        <section class="h-screen flex justify-center items-center">
            <article class="flex justify-center items-center flex-col shadow-2xl text-center p-8 rounded-2xl">
                <h1 class="text-2xl font-medium">Suporte T.I</h1>
                <br>
                <!--login-->
                <form class="flex flex-col gap-y-3.5" action="" method="POST">
                    <!--Email-->
                    <div>
                        <input class="border-solid border-2 border-black rounded-2xl px-8 py-1" placeholder="Digite seu e-mail:" type="text" name="email">
                    </div>
                    <!--Email-->
                    <!--Senha-->
                    <div>
                        <input id="senha" class="border-solid border-2 border-black rounded-2xl px-5 py-1" placeholder="Digite sua senha:" type="password" name="senha">
                        <button type="button" id="toggleSenha" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-sm text-blue-500" onclick="togglePasswordVisibility()">🤫</button>
                    </div>
                    <!--Senha-->
                    <!--Botao de login-->
                    <div class="flex justify-center items-center gap-2">
                        <button class="font-medium bg-slate-300 rounded-2xl px-7 py-1 hover:bg-green-600" type="submit">Entrar</button>
                    </div>
                    <div>
                        <p>Ainda não tem cadastro? Aperte <a style="color: #0000FF;" href="./cadastro.php">aqui.</a></p>
                    </div>
                    <!--Botao de login-->
                </form>
                <!--login-->
            </article>
        </section>
    <!--Formulario de login-->
</body>
    <!--Erros-->
        <?php if ($error_message != ""): ?>
            <script>
                swal ({
                    title: "Algo deu errado🤔",
                    text: "<?php echo $error_message; ?>",
                    icon: "error",
                    });
            </script>
        <?php endif; ?>
    <!--Erros-->
    <!--Senha-->
        <script src="./log/js/passaword.js"></script>
    <!--Senha-->
</html>
