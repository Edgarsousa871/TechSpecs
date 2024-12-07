<?php
// Conexão com o banco de dados (código como no seu exemplo)
$servername = "localhost";
$username = "root"; // Substitua pelo seu usuário do banco de dados
$password = ""; // Substitua pela sua senha do banco de dados
$dbname = "pap"; // Substitua pelo nome do seu banco de dados

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexão falhou: " . $e->getMessage());
}

// Registro de novo usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['password'];

    // Criptografar a senha
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir novo usuário no banco de dados
    $stmt = $conn->prepare("INSERT INTO users (nome, password) VALUES (:nome, :senha)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':senha', $senhaCriptografada);

    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar usuário.";
    }
}
?>
