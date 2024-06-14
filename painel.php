<?php
include('./log/protect.php');
include('tailwind.php');

// Bd Crud
$usuario = 'root';
$senha = '';
$database = 'helpdesk';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

// Verifica conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// CRUD
// Insert
if (isset($_POST['nome']) && isset($_POST['mensagem']) && empty($_POST['id'])) {
    $stmt = $mysqli->prepare("INSERT INTO help (nome, mensagem) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $_POST['nome'], $_POST['mensagem']);
        if ($stmt->execute()) {
            echo 'Inserido com sucesso<br>';
        } else {
            echo 'Erro na execução: ' . $stmt->error . '<br>';
        }
        $stmt->close();
    } else {
        echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
    }
}

// Update
if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['nome']) && isset($_POST['mensagem'])) {
    $stmt = $mysqli->prepare("UPDATE help SET nome = ?, mensagem = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $_POST['nome'], $_POST['mensagem'], $_POST['id']);
        if ($stmt->execute()) {
            echo 'Atualizado com sucesso<br>';
        } else {
            echo 'Erro na execução: ' . $stmt->error . '<br>';
        }
        $stmt->close();
    } else {
        echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
    }
}

// Delete
if (isset($_GET['delete_id'])) {
    $stmt = $mysqli->prepare("DELETE FROM help WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $_GET['delete_id']);
        if ($stmt->execute()) {
            echo 'Deletado com sucesso<br>';
        } else {
            echo 'Erro na execução: ' . $stmt->error . '<br>';
        }
        $stmt->close();
    } else {
        echo 'Erro na preparação da declaração: ' . $mysqli->error . '<br>';
    }
}

// Read
$result = $mysqli->query("SELECT id, nome, mensagem FROM help");

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Chamado</th>
                <th>Nome</th>
                <th>Mensagem</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nome'] . "</td>
                <td>" . $row['mensagem'] . "</td>
                <td>
                    <a href='detalhes.php?id=" . $row['id'] . "'>Detalhes</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado";
}

// Fetch data for editing
if (isset($_GET['edit_id'])) {
    $stmt = $mysqli->prepare("SELECT id, nome, mensagem FROM help WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $_GET['edit_id']);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $edit_data = $result->fetch_assoc();
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
    <title>Painel</title>
</head>
<body>
    Bem-vindo ao Painel, <?php echo $_SESSION['nome']; ?>.

    <p>
        <a href="./log/logout.php">Sair</a>
    </p>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($edit_data['id']) ? $edit_data['id'] : ''; ?>">
        <input type="text" name="nome" value="<?php echo isset($edit_data['nome']) ? $edit_data['nome'] : ''; ?>" required>
        <input type="text" name="mensagem" value="<?php echo isset($edit_data['mensagem']) ? $edit_data['mensagem'] : ''; ?>" required>
        <input type="submit" value="<?php echo isset($edit_data) ? 'Atualizar' : 'Enviar'; ?>">
    </form>
</body>
</html>
