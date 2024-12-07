<?php
session_start();
require_once('./bd/basedados.php');

// Função para criar um novo administrador
function criarAdmin($id, $nome, $email, $senha, $role) {
    $bd = conexaoBD();
    try {
        // Criação do hash seguro da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserção no banco de dados
        $stmt = $bd->prepare("INSERT INTO clientes (id, nome, email, password, role) VALUES (:id, :nome, :email, :senha, :role)");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':role', $role);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Erro ao criar administrador: " . $e->getMessage();
        return false;
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['password'];

    // Validação básica dos campos
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        if (criarAdmin($id, $nome, $email, $senha, $role)) {
            // Redireciona para a página de login após sucesso
            header("Location: login.php");
            exit();
        } else {
            echo "<p>Erro ao criar o administrador. Tente novamente.</p>";
        }
    } else {
        echo "<p>Preencha todos os campos.</p>";
    }
}
?>
