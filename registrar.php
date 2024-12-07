<?php
session_start();

require_once('./bd/basedados.php');
require_once('./bd/autenticacao.php');

$errorMessage = "";
$successMessage = "";

if (isset($_POST['register'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($nome) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errorMessage = "Por favor, preencha todos os campos.";
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "As senhas não coincidem.";
    } else {
        // Verifica se o email já está registrado
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $errorMessage = "Este email já está registrado.";
        } else {
            // Cria um novo registro de cliente
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, password) VALUES (:nome, :email, :password)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);
            $stmt->execute();

            header("Location: login.php");
            exit;

        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Conta</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <main class="formLogin">
        <form action="" method="post" class="cantosArredondados">
            <label class="title">Registrar Nova Conta</label>
            
            <?php if ($errorMessage): ?>
                <p class="error"><?= $errorMessage ?></p>
            <?php endif; ?>
            
            <?php if ($successMessage): ?>
                <p class="success"><?= $successMessage ?></p>
            <?php endif; ?>

            <div class="linha">
                <label for="nome">Nome</label>
                <input type="text" name="nome" placeholder="Insira seu nome" required class="cantosArredondados"/>
            </div>
            <div class="linha">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Insira seu email" required class="cantosArredondados"/>
            </div>
            <div class="linha">
                <label for="password">Senha</label>
                <input type="password" name="password" placeholder="Insira a sua senha" required class="cantosArredondados"/>
            </div>
            <div class="linha">
                <label for="confirm_password">Confirmar Senha</label>
                <input type="password" name="confirm_password" placeholder="Confirme sua senha" required class="cantosArredondados"/>
            </div>
            <div class="botao">
                <button type="submit" name="register" class="cantosArredondados">Registrar</button>
            </div>
            <div class="linha link">
                <a href="login.php">Já tem uma conta? Faça login!</a>
            </div>
        </form>
    </main>
</body>
</html>