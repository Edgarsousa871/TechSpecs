<?php
session_start();
require_once('./bd/basedados.php'); // Conexão com o banco de dados

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver autenticado
    exit();
}

// Consulta o papel do usuário no banco de dados para confirmar se ele é admin
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pap', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT role FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user'], PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o papel do usuário é diferente de 'admin'
    if (!$user || $user['role'] !== 'admin') {
        header('Location: index .php'); // Redireciona para uma página de acesso negado
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao verificar permissões: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="./css/admin.css">
</head>

<body>
    <main>
        <div class="dashboard-options">
            <!-- Opções do painel de administração -->
            <div class="option-box">
                <h3>Gerenciar Produtos</h3>
                <p>Adicionar, editar ou excluir produtos na loja.</p>
                <a href="gerenciar_produtos.php" class="button">Gerenciar Produtos</a>
            </div>
            <div class="option-box">
                <h3>Gerenciar Clientes</h3>
                <p>Visualize e gerencie os clientes registrados no site.</p>
                <a href="gerenciar_clientes.php" class="button">Gerenciar Pedidos</a>
            </div>
            <div class="option-box">
                <h3>Configurações da Loja</h3>
                <p>Configure aspectos gerais da loja.</p>
                <a href="configuracoes.php" class="button">Configurações</a>
            </div>

            <div class="option-box">
                <h3>Gerenciar componentes</h3>
                <p>Configure aspectos gerais da loja.</p>
                <a href="adicionar_componentes.php" class="button">Configurações</a>
            </div>
        </div>

    </main>
</body>

</html>
