<?php
include('./log/protect.php');
include('tailwind.php');

// Conectar ao banco de dados
$usuario = 'root';
$senha = '';
$database = 'helpdesk';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

// Verifica conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Obter o ID do registro a partir da URL
$id = $_GET['id'];

// Processar o formulário de comentário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comentario']) && $id && !isset($_POST['comentario_id'])) {
        // Adicionar comentário
        $comentario = $_POST['comentario'];
        $stmt = $mysqli->prepare("UPDATE help SET comentario = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $comentario, $id);
            if ($stmt->execute()) {
                echo 'Comentário adicionado com sucesso<br>';
            } else {
                echo 'Erro na execução: ' . $stmt->error . '<br>';
            }
            $stmt->close();
        } else {
            echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
        }
    } elseif (isset($_POST['comentario_id'])) {
        // Editar comentário
        $comentario_id = $_POST['comentario_id'];
        $comentario = $_POST['comentario'];
        $stmt = $mysqli->prepare("UPDATE help SET comentario = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $comentario, $comentario_id);
            if ($stmt->execute()) {
                echo 'Comentário atualizado com sucesso<br>';
            } else {
                echo 'Erro na execução: ' . $stmt->error . '<br>';
            }
            $stmt->close();
        } else {
            echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
        }
    }
}

// Excluir comentário
if (isset($_GET['delete_comentario_id'])) {
    $comentario_id = $_GET['delete_comentario_id'];
    $stmt = $mysqli->prepare("UPDATE help SET comentario = NULL WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $comentario_id);
        if ($stmt->execute()) {
            echo 'Comentário excluído com sucesso<br>';
        } else {
            echo 'Erro na execução: ' . $stmt->error . '<br>';
        }
        $stmt->close();
    } else {
        echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
    }
}

// Obter os dados do registro
if ($id) {
    $stmt = $mysqli->prepare("SELECT id, nome, mensagem, comentario FROM help WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
        }
        $stmt->close();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes</title>
</head>
<body>
    <?php if (isset($data)) { ?>
        <h1>Detalhes do Registro</h1>
        <p>Chamado: <?php echo $data['id']; ?></p>
        <p>Nome: <?php echo $data['nome']; ?></p>
        <p>Mensagem: <?php echo $data['mensagem']; ?></p>
        <h2>Comentários</h2>
        <p><?php echo nl2br($data['comentario']); ?></p>
        
        <?php if ($data['comentario']) { ?>
            <a href="?id=<?php echo $id; ?>&edit_comentario_id=<?php echo $id; ?>">Editar Comentário</a> |
            <a href="?id=<?php echo $id; ?>&delete_comentario_id=<?php echo $id; ?>">Excluir Comentário</a>
        <?php } ?>

        <?php if (isset($_GET['edit_comentario_id'])) { ?>
            <h2>Editar Comentário</h2>
            <form method="post">
                <input type="hidden" name="comentario_id" value="<?php echo $id; ?>">
                <textarea name="comentario" rows="4" cols="50" required><?php echo $data['comentario']; ?></textarea><br>
                <input type="submit" value="Atualizar Comentário">
            </form>
        <?php } else { ?>
            <h2>Adicionar Comentário</h2>
            <form method="post">
                <textarea name="comentario" rows="4" cols="50" required></textarea><br>
                <input type="submit" value="Adicionar Comentário">
            </form>
        <?php } ?>
    <?php } else { ?>
        <p>Registro não encontrado.</p>
    <?php } ?>

    <p><a href="painel.php">Voltar</a></p>
</body>
</html>
