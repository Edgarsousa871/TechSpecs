<?php
require './bd/basedados.php'; // Inclui a conexão com o banco de dados
session_start(); // Inicia a sessão

// Inicialização de variáveis de mensagem
$errorMessage = '';   // Inicializa a variável de mensagem de erro
$successMessage = ''; // Inicializa a variável de mensagem de sucesso

// Função para buscar todos os produtos com o nome do componente associado
function getProdutos($pdo) {
    $stmt = $pdo->query("
        SELECT p.id_produto, p.nome, p.preco, p.imagem, p.componente, c.componente AS nome_componente 
        FROM produtos p
        LEFT JOIN componentes c ON p.componente = c.id_componentes
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar todos os componentes disponíveis
function getComponentes($pdo) {
    echo('Some message here.');
    $stmt = $pdo->query("SELECT id_componentes, componente FROM componentes");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para adicionar ou atualizar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome']);
    $preco = trim($_POST['preco']);
    $componente = trim($_POST['componente']);

    // Variável para o caminho da imagem
    $imagem = '';

    // Verifica se um arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Define o diretório de upload
        $uploadDir = './uploads/';
        $uploadFile = $uploadDir . basename($_FILES['imagem']['name']);

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
            $imagem = $uploadFile; // Armazena o caminho da imagem
        } else {
            $errorMessage = "Erro ao fazer o upload da imagem.";
        }
    } else {
        // Se não houver upload, mantém a imagem atual
        $imagem = $_POST['imagem_atual'] ?? '';
    }

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($preco) || empty($imagem) || empty($componente)) {
        $errorMessage = "Preencha todos os campos!";
    } else {
        if ($id) {
            // Atualizar produto
            $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, imagem = ?, componente = ? WHERE id_produto = ?");
            $stmt->execute([$nome, $preco, $imagem, $componente, $id]);
            $successMessage = "Produto atualizado com sucesso!";
        } else {
            // Inserir novo produto
            $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, imagem, componente) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $preco, $imagem, $componente]);
            $successMessage = "Produto adicionado com sucesso!";
        }
    }
}

// Função para excluir produto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id_produto = ?");
    $stmt->execute([$id]);
    $successMessage = "Produto excluído com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
  
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container input, .form-container select {
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
        .prod-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Produtos</h1>

    <!-- Mensagens de Sucesso e Erro -->
    <?php if (!empty($successMessage)): ?>
        <p class="success"><?= $successMessage ?></p>
    <?php endif; ?>
    <?php if (!empty($errorMessage)): ?>
        <p class="error"><?= $errorMessage ?></p>
    <?php endif; ?>

    <!-- Formulário de Adicionar/Editar Produto -->
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $_GET['edit'] ?? '' ?>">
            <input type="hidden" name="imagem_atual" value="<?= $_GET['imagem'] ?? '' ?>">

            <input type="text" name="nome" placeholder="Nome do Produto" value="<?= $_GET['nome'] ?? '' ?>" required>
            <input type="number" step="0.000001" name="preco" placeholder="Preço" value="<?= $_GET['preco'] ?? '' ?>" required>

            <!-- Campo de Upload de Imagem -->
            <label>Imagem do Produto:</label>
            <input type="file" name="imagem" accept="image/*">
            
            <!-- Dropdown para selecionar o componente -->
            <label>Componente:</label>
            <select name="componente" required>
                <option value="">Selecione um componente</option>
                <?php foreach (getComponentes($pdo) as $componente): ?>
                    <option value="<?= $componente['id_componentes'] ?>"
                        <?= (isset($_GET['componente']) && $_GET['componente'] == $componente['id_componentes']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($componente['componente']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"><?= isset($_GET['edit']) ? 'Atualizar' : 'Adicionar' ?></button>
        </form>
    </div>

    <!-- Tabela de Produtos -->
    <table id="produtosTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Imagem</th>
                <th>Componente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getProdutos($pdo) as $produto): ?>
                <tr>
                    <td><?= $produto['id_produto'] ?></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= number_format($produto['preco'], 6, ',', '.') ?></td>
                    <td><img class="prod-image" src="<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem do Produto"></td>
                    <td><?= htmlspecialchars($produto['nome_componente'] ?? 'Desconhecido') ?></td>
                    <td>
                        <a href="?edit=<?= $produto['id_produto'] ?>">Editar</a> |
                        <a href="?delete=<?= $produto['id_produto'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
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
            $('#produtosTable').DataTable({
                language: {
                    "decimal": ",",
                    "thousands": ".",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Nenhum registro encontrado",
                    "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)",
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
</body>
</html>
