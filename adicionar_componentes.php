<?php
require './bd/basedados.php'; // Inclui a conexão com o banco de dados
session_start(); // Inicia a sessão

// Inicialização de variáveis de mensagem
$errorMessage = '';   // Inicializa a variável de mensagem de erro
$successMessage = ''; // Inicializa a variável de mensagem de sucesso

// Função para buscar todos os componentes
function getComponentes($pdo) {
    $stmt = $pdo->query("SELECT id_componentes, componente FROM componentes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para adicionar ou atualizar componente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nomeComponente = trim($_POST['componente']);

    // Verifica se o campo de nome do componente está preenchido
    if (empty($nomeComponente)) {
        $errorMessage = "Preencha o nome do componente!";
    } else {
        if ($id) {
            // Atualizar componente
            $stmt = $pdo->prepare("UPDATE componentes SET componente = ? WHERE id_componentes = ?");
            $stmt->execute([$nomeComponente, $id]);
            $successMessage = "Componente atualizado com sucesso!";
        } else {
            // Inserir novo componente
            $stmt = $pdo->prepare("INSERT INTO componentes (componente) VALUES (?)");
            $stmt->execute([$nomeComponente]);
            $successMessage = "Componente adicionado com sucesso!";
        }
    }
}

// Função para excluir componente
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM componentes WHERE id_componentes = ?");
    $stmt->execute([$id]);
    $successMessage = "Componente excluído com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Componentes</title>
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
  
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container input {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Componentes</h1>

    <!-- Mensagens de Sucesso e Erro -->
    <?php if (!empty($successMessage)): ?>
        <p class="success"><?= $successMessage ?></p>
    <?php endif; ?>
    <?php if (!empty($errorMessage)): ?>
        <p class="error"><?= $errorMessage ?></p>
    <?php endif; ?>

    <!-- Formulário de Adicionar/Editar Componente -->
    <div class="form-container">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $_GET['edit'] ?? '' ?>">
            <input type="text" name="componente" placeholder="Nome do Componente" value="<?= $_GET['componente'] ?? '' ?>" required>
            <button type="submit"><?= isset($_GET['edit']) ? 'Atualizar' : 'Adicionar' ?></button>
        </form>
    </div>

    <!-- Tabela de Componentes -->
    <table id="componentesTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Componente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getComponentes($pdo) as $componente): ?>
                <tr>
                    <td><?= $componente['id_componentes'] ?></td>
                    <td><?= htmlspecialchars($componente['componente']) ?></td>
                    <td>
                        <a href="?edit=<?= $componente['id_componentes'] ?>&componente=<?= urlencode($componente['componente']) ?>">Editar</a> |
                        <a href="?delete=<?= $componente['id_componentes'] ?>" onclick="return confirm('Tem certeza que deseja excluir este componente?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- JS DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#componentesTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
</body>
</html>
