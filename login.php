<?php
require './bd/conexao.php'; // Inclui a conexão com a base de dados
session_start(); // Garante que a sessão seja iniciada
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validação de campos vazios
    if (empty($email)) {
        $error_message = "Preencha seu e-mail.";
    } elseif (empty($password)) {
        $error_message = "Preencha sua password.";
    } else {
        try {
            // Conexão com o banco de dados
            $pdo = new PDO('mysql:host=localhost;dbname=pap', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta para verificar o usuário
            $sql = "SELECT id, nome, role, password FROM clientes WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) { // Substitua com hashing seguro
                // Configurando a sessão do usuário
                $_SESSION['user'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['role'] = $user['role'];

                // Redireciona baseado no papel do usuário
                if ($user['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: index .php");

                }   
                exit();
          } else {
 
}

        } catch (PDOException $e) {
            $error_message = "Erro na conexão com o banco de dados: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        form h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form p {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #888888;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #666666;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: black;
            text-decoration: none;
        }

        .register-link a:hover {
            color: grey;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Entrar</h1>
        <p>
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
        <p class="register-link">
            Ainda não tem conta? <a href="registrar.php">Registre-se</a>
        </p>
        <?php if ($error_message): ?>
            <div class="error-message"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
