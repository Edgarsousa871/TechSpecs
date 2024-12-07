<?php
session_start();

// Incluindo a função para conectar ao banco de dados
include_once 'conexao.php'; // Arquivo que faz a conexão com o banco de dados

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validando os dados (pode adicionar mais validações conforme necessário)
    if (empty($nome) || empty($email) || empty($password)) {
        $_SESSION['erro'] = 'Todos os campos são obrigatórios!';
        header('Location: registrar.php');
        exit();
    }

    // Criptografando a senha com bcrypt
    $senha_hash = password_hash($password, PASSWORD_BCRYPT);

    // Conectando ao banco de dados e tentando adicionar o cliente
    try {
        // Chamando a função para inserir os dados no banco
        $conn = conexaoBD(); // Conexão com o banco de dados
        $query = "INSERT INTO clientes (email, nome, senha) VALUES (:email, :nome, :senha)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->execute();

        // Se a inserção for bem-sucedida, redireciona para a página de login
        $_SESSION['sucesso'] = 'Cliente registrado com sucesso! Agora, faça login.';
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        // Se houver erro ao inserir no banco, mostra uma mensagem de erro
        $_SESSION['erro'] = 'Erro ao registrar cliente: ' . $e->getMessage();
        header('Location: registrar.php');
        exit();
    }
}
?>
