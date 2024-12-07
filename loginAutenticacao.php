<?php
require_once './bd/basedados.php'; // Conexão com o banco de dados
session_start();

// Função para realizar login
function login($email, $senha) {
    $bd = conexaoBD();
    try {
        // Verifica login do admin
        $stmt = $bd->prepare("SELECT * FROM admin WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $dados['password'])) {
                $_SESSION['id'] = $dados['id_admin'];
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['role'] = 'admin';

                header("Location: admin.php");
                exit();
            }
        }

        // Verifica login de cliente
        $stmt = $bd->prepare("SELECT * FROM clientes WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $dados['password'])) {
                $_SESSION['id'] = $dados['id_utilizador'];
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['role'] = 'cliente';

                header("Location: index .php");
                exit();
            }
        }

        return false;
    } catch (PDOException $e) {
        echo "Erro de autenticação: " . $e->getMessage();
        exit();
    }
}

// Função para registrar novo usuário
function registrarUsuario($nome, $email, $senha) {
    $bd = conexaoBD();
    try {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Hash seguro da senha
        $registro = $bd->prepare("INSERT INTO clientes (nome, email, password) VALUES (:nome, :email, :senha)");
        $registro->bindValue(":nome", $nome);
        $registro->bindValue(":email", $email);
        $registro->bindValue(":senha", $senhaHash);
        $registro->execute();

        // Realiza login automático após registro
        return login($email, $senha);
    } catch (PDOException $e) {
        return false;
    }
}

// Processamento de requisição POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['entrar'])) {
        $email = filter_input(INPUT_POST, 'login-email', FILTER_VALIDATE_EMAIL);
        $senha = $_POST['login-password'];

        if (!$email || !$senha || !login($email, $senha)) {
            $erro = "Login ou senha incorretos!";
        }
    } elseif (isset($_POST['registrar'])) {
        $nome = trim($_POST['nome']);
        $email = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
        $senha = $_POST['Password'];

        if (!$nome || !$email || !$senha || !registrarUsuario($nome, $email, $senha)) {
            $erroRegistro = "Erro ao registrar novo usuário!";
        }
    }
}
?>
