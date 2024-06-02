<?php
include('conexao.php');

if(isset($_POST['email']) || isset($_POST['senha']) || isset($_POST['nome'])) {

    if(strlen($_POST['nome']) == 0) {
        $error_message = "Preencha seu nome";
    } else if(strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {

        $nome = $mysqli->real_escape_string($_POST['nome']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if($sql_query) {
            $success_message = "Usuário cadastrado com sucesso!";
        } else {
            $error_message = "Falha ao cadastrar usuário!";
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
    <title>Cadastro | Help</title>
    <!--Css-->
    <link rel="stylesheet" href="../css/reset.css">
    <!--Log-->
    <link rel="stylesheet" href="./css/main.css">
    <!--Log-->
    <!--Css-->
</head>
<body>
    <!--Formulario de cadastro-->
    <section class="ContainerLogin">
        <article>
            <h1>Cadastro</h1>
            <br>
            <form action="" method="POST">
                <div>
                    <input placeholder="Digite seu nome:" type="text" name="nome">
                </div>
                <div>
                    <input placeholder="Digite seu e-mail:" type="email" name="email">
                </div>
                <div>
                    <input placeholder="Digite sua senha:" type="password" name="senha">
                </div>
                <?php if (isset($error_message) && $error_message != ""): ?>
                    <div style="color: red;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($success_message) && $success_message != ""): ?>
                    <div style="color: green;">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </article>
    </section>
    <!--Formulario de cadastro-->    
</body>
</html>
