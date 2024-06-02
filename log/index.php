<?php
include('conexao.php');

$error_message = ""; // Vareavel para erro

if(isset($_POST['email']) || isset($_POST['senha'])) {
    // Campos de falha para login
    if(strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: ../painel.php");

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
    <!--Icon-->
        <link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAArElEQVR4nO2XQQrAMAgE/f+np6deAiWQVKNmB3IqFCa7UmsmekHQcae8CEE3hbdQeRGCz4tEslTKPZF2IgTNBBL5wOum0iSyi0RWUSITVK1VVK0JqtYq7auFdi3LsTR6gUSS/7O/zJ7fI0LQbLjPTHkRkpwRiZyCvxOx20VwmgUk4lS32bvwTKSNSCRIZOD0F52/d6yyIhyejZHtJLKAkkgC1Yeb3Wq3ERF2mAcEA+E7Kou21QAAAABJRU5ErkJggg==" type="image/x-icon">
    <!--Icon-->
    <!--Css-->
    <link rel="stylesheet" href="../css/reset.css">
    <!--Log-->
    <link rel="stylesheet" href="./css/main.css">
    <!--Log-->
    <!--Css-->
</head>
<body>
    <!--Formulario de login-->
    <section class="ContainerLogin">
        <article>
            <h1>Suporte T.I</h1>
            <br>
            <!--login-->
                <form action="" method="POST">
                    <!--Email-->
                        <div>
                            <input placeholder="Digite seu e-mail:" type="text" name="email">
                        </div>
                    <!--Email-->
                    <!--Senha-->
                        <div>
                            <input placeholder="Digite sua senha:" type="password" name="senha">
                        </div>
                    <!--Senha-->
                    <!--Erros-->
                        <?php if ($error_message != ""): ?>
                            <div style="color: red;">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                    <!--Erros-->
                    <!--Botao de login-->
                        <div>
                            <button type="submit">Entrar</button>
                            <a href="./cadastro.php">Cadastro</a>
                        </div>
                    <!--Botao de login-->
                </form>
            <!--login-->
        </article>
    </section>
    <!--Formulario de login-->    
</body>
</html>
