<?php
require './bd/basedados.php'; // Inclui a conexão com o banco de dados

try {
    // Consulta para obter os clientes
    $query = "SELECT * FROM clientes";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar clientes: " . $e->getMessage());
}

// Verifica se a requisição para apagar ou editar foi feita
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    try {
        $query = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $delete_id);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a mesma página para atualizar a lista
    } catch (PDOException $e) {
        die("Erro ao excluir cliente: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    // Atualiza o cliente
    $id_cliente = $_POST['edit_id'];
    $nome = $_POST['nome'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    try {
        $query = "UPDATE clientes SET nome = :nome, password = :password, email = :email, role = :role WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id_cliente);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a mesma página para atualizar a lista
    } catch (PDOException $e) {
        die("Erro ao atualizar cliente: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- jQuery (necessário para o DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            position: relative;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-back {
            background-color: #2196F3;
            color: white;
            position: fixed;
            bottom: 20px;
            left: 20px;
        }
    </style>

</head>
<body>

    <h1>Lista de Clientes</h1>

    <!-- Tabela com dados dos clientes -->
    <table id="clientesTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['password']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['role']); ?></td>
                    <td>
                        <!-- Botões de editar e excluir -->
                        <a href="?edit_id=<?php echo $cliente['id']; ?>" class="btn btn-edit">Editar</a>
                        <a href="?delete_id=<?php echo $cliente['id']; ?>" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Inicializar DataTable -->
    <script>
        $(document).ready( function () {
            $('#clientesTable').DataTable(); // Inicializa a DataTable
        });
    </script>

    <?php
    // Se a requisição for para editar, exibe o formulário de edição
    if (isset($_GET['edit_id'])):
        $edit_id = $_GET['edit_id'];

        // Busca os dados do cliente para edição
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $edit_id);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

        <h2>Editar Cliente</h2>
        <form method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $cliente['id']; ?>">

            Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required><br><br>
            Password: <input type="password" name="password" value="<?php echo htmlspecialchars($cliente['password']); ?>" required><br><br>
            Email: <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required><br><br>
            Role: <input type="text" name="role" value="<?php echo htmlspecialchars($cliente['role']); ?>" required><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    <?php endif; ?>

    <!-- Botão de voltar à página admin -->
    <a href="admin.php" class="btn btn-back">Voltar à Página Admin</a>

</body>
</html>