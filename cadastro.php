<?php
include('./log/conexao.php');
include('tailwind.php');

if (isset($_POST['email']) || isset($_POST['senha']) || isset($_POST['nome'])) {
    // Verificação dos campos de dados
    if (strlen($_POST['nome']) == 0) {
        $error_message = "Preencha seu nome";
    } else if (strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($sql_query) {
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
    <?php if (isset($error_message) && $error_message != ""): ?>
        <script>
            swal ({
                title: "Algo deu errado🤔",
                text: "<?php echo $error_message; ?>",
                icon: "error",
                });
        </script>
    <?php endif; ?>
    <?php if (isset($success_message) && $success_message != ""): ?>
        <script>
            swal ({
                title: "Usuário cadastrado😁",
                text: "<?php echo $success_message; ?>",
                icon: "success",
                });
        </script>
    <?php endif; ?>
    <!--Formulario de cadastro-->
    <section class="h-screen flex justify-center items-center">
        <article class="flex justify-center items-center flex-col text-center shadow-2xl p-8 rounded-2xl">
            <h1 class="text-2xl font-medium">Cadastro</h1>
            <br>
            <!--Cadastro-->
            <form class="flex flex-col gap-y-3.5" action="" method="POST">
                <!--nome-->
                <div>
                    <input class="border-solid border-2 border-black rounded-2xl px-6 py-1" placeholder="Digite seu nome:" type="text" name="nome">
                </div>
                <!--nome-->
                <!--email-->
                <div>
                    <input class="border-solid border-2 border-black rounded-2xl px-6 py-1" placeholder="Digite seu e-mail:" type="email" name="email">
                </div>
                <!--email-->
                <!--senha-->
                <div>
                    <input class="border-solid border-2 border-black rounded-2xl px-6 py-1" placeholder="Digite sua senha:" type="password" name="senha">
                </div>
                <!--senha-->
                <!--Botão de cadastro-->
                <div class="flex justify-center items-center gap-2">
                    <button class="font-medium bg-slate-300 rounded-2xl px-6 py-1 hover:bg-green-600" type="submit">Cadastrar</button>
                    <a class="font-medium bg-slate-300 rounded-2xl px-5 py-1 hover:bg-rose-600" href="./index.php">Voltar</a>
                </div>
                <!--Botão de cadastro-->
            </form>
            <!--Cadastro-->
        </article>
    </section>
    <!--Formulario de cadastro-->    
</body>
</html>
